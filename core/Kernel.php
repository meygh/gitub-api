<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/17/22
 * Time: 7:40 PM
 */

namespace Meygh\GithubApi;


use ErrorException;
use Meygh\GithubApi\contracts\CommandInterface;
use Meygh\GithubApi\exceptions\InvalidCommand;
use Exception;


class Kernel extends Singleton
{
    /** @var string of path to config directory */
    protected $configDir = 'config';
    /** @var string name of config file */
    protected $configFileName = 'main';
    /** @var string of path to config file */
    protected $configFilePath = '';
    /** @var string of the name of default command if nothing was given to the kernel */
    protected $defaultCommand = 'list';

    /** @var array list of commands' class namespaces */
    protected $commands = [

    ];

    /** @var array of loaded configurations */
    protected $config = [];

    /**
     * Console kernel initializer.
     * @throws \ErrorException
     */
    public function init()
    {
        $this->loadConfigurations();
        $this->loadCommands();
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
    public function getConfig(): array
    {
        return $this->config;
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
                    $command->beforeRun();
                    call_user_func([$command, "run"], array_values($argv));
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
     * @return CommandInterface
     * @throws InvalidCommand
     */
    public function getCommand(string $signature): CommandInterface
    {
        if ($command = $this->isValidCommand($signature)) {
            return class_exists($signature);
        }

        throw new InvalidCommand($signature);
    }

    /**
     * Checks if the given command is already exists or not.
     * @param string $signature
     * @return bool
     */
    public function isValidCommand(string $signature): bool
    {
        if (array_get($this->commands, $signature)) {
            return true;
        }

        return false;
    }

    /**
     * Retrieve and load configuration parameters from config file.
     * @throws \ErrorException
     */
    protected function loadConfigurations()
    {
        if (!$this->getConfig()) {
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
    }

    /**
     * Validate and load all defined commands.
     */
    protected function loadCommands()
    {
        if ($external_commands = array_get($this->config, 'commands')) {
            $this->commands = array_merge($this->commands, $external_commands);
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
    }
}