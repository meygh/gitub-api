<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/17/22
 * Time: 7:40 PM
 */

namespace Meygh\GithubApi;


use ErrorException;
use Meygh\GithubApi\Contracts\iCommand;
use Meygh\GithubApi\exceptions\InvalidCommandException;
use Exception;


/**
 * Class Kernel
 * @package Meygh\GithubApi
 */
class Console extends Singleton
{
    /** @var string of path to config directory */
    protected $configDir = 'config';
    /** @var string name of config file */
    protected $configFileName = 'console';
    /** @var string of path to config file */
    protected $configFilePath = '';
    /** @var string of the name of default command if nothing was given to the kernel */
    protected $defaultCommand = 'list-commands';

    /** @var array list of commands' class namespaces */
    protected $commands = [

    ];

    /** @var array of loaded configurations */
    protected $config = [];

    /**
     * Console kernel initializer.
     * @return bool
     * @throws ErrorException
     * @throws \ReflectionException
     */
    public function init()
    {
        $this->loadConfigurations()
            ->loadServices()
            ->loadCommands();

        return true;
    }

    /**
     * Initialize the Console kernel.
     */
    public function run()
    {
        $this->handleRequest();
    }

    /**
     * Returns configuration array.
     * @return array
     */
    public function getConfigs(): array
    {
        return $this->config;
    }

    /**
     * Returns a specific configuration by its key.
     * @param string $key
     * @return mixed|null
     */
    public function getConfig(string $key)
    {
        return array_get($this->config, $key);
    }

    /**
     * Returns the list of commands' signatures.
     * @return array
     */
    public function getCommandList(): array
    {
        return array_keys($this->commands);
    }

    /**
     * Execute the requested command.
     */
    public function handleRequest()
    {
        if (!isset($_SERVER['argc'])) {
            exit('You are not allowed to run CLI application through web browser!');
        }

        $argv = $_SERVER['argv'];

        if ($signature = array_get($argv, 1, $this->defaultCommand, true)) {
            unset($argv[0]);

            try {
                if ($command = $this->getCommand($signature)) {
                    if ($command->hasMethod('setArguments')) {
                        $command->setArguments($argv);
                    }

                    if ($command->beforeRun()) {
                        call_user_func([$command, "run"], array_values($argv));
                    }

                    $command->afterRun();
                }
            } catch (Exception $e) {
                exit($e->getMessage());
            }
        }
    }

    /**
     * Return the object of requested command.
     * @param string $signature
     * @return iCommand
     * @throws InvalidCommandException
     */
    public function getCommand(string $signature): iCommand
    {
        if ($command = $this->isValidCommand($signature)) {
            return new $command();
        }

        throw new InvalidCommandException($signature);
    }

    /**
     * Checks if the given command is already exists or not.
     * @param string $signature
     * @return false|string
     */
    public function isValidCommand(string $signature)
    {
        $signature = array_get($this->commands, $signature);

        if ($signature && class_exists($signature)) {
            return $signature;
        }

        return false;
    }

    /**
     * Retrieve and load configuration parameters from config file.
     * @return $this
     * @throws ErrorException
     */
    protected function loadConfigurations()
    {
        if (!$this->getConfigs()) {
            if (!$this->configFilePath) {
                $this->configFilePath = APP_DIR;

                if (!empty($this->configDir)) {
                    $this->configFilePath .= $this->configDir . DS;
                }

                $this->configFilePath .= $this->configFileName . '.php';

                if (!file_exists($this->configFilePath)) {
                    throw new ErrorException("Config file is not found!\nFile Path: {$this->configFilePath}\n\n");
                }
            }

            try {
                $config = (array) require_once $this->configFilePath;
            } catch (Exception $e) {
                throw new ErrorException("Config file could not be loaded!\nFile Path: {$this->configFilePath}\n\n");
            }

            $this->config = $config;
        }

        return $this;
    }

    /**
     * Initialize Service container and load default services
     * which are defined within config files.
     * @return $this
     * @throws ErrorException
     * @throws \ReflectionException
     */
    protected function loadServices()
    {
        /** @var Service $Service */
        $Service = Service::getInstance();

        if ($services = (array) $this->getConfig('services')) {
            foreach ($services as $service => $definition) {
                $Service->set($service, $definition);
            }
        }

        return $this;
    }

    /**
     * Validate and load all defined commands.
     * @return $this
     */
    protected function loadCommands()
    {
        $core_commands_dir = CORE_DIR . DS . 'commands';

        if (is_dir($core_commands_dir) && is_readable($core_commands_dir)) {
            $core_commands =  array_diff(scandir($core_commands_dir), ['.', '..']);

            foreach ($core_commands as $command) {
                $file_extension = substr(strrchr($command, '.'), 0);

                if ($file_extension == '.php') {
                    $command = rtrim($command, $file_extension);
                    $this->commands[$command] = "\\Meygh\\GithubApi\\Commands\\$command";
                }
            }
        }

        if ($external_commands = array_get($this->config, 'commands')) {
            $this->commands += $external_commands;
        }

        foreach ($this->commands as $key => $command) {
            unset($this->commands[$key]);

            if (class_exists($command) && ($signature = $command::signature())) {
                $this->commands[$signature] = $command;
            }
        }

        if (!$this->commands) {
            exit("There is no any commands defined yet!");
        }

        return $this;
    }
}