<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/17/22
 * Time: 7:40 PM
 */

namespace Meygh\GithubApi;


use ErrorException;
use Exception;


/**
 * Class Application is the base of http and restful api kernel
 * @package Meygh\GithubApi
 */
class Application extends Singleton
{
    /** @var string of path to config directory */
    protected $configDir = 'config';
    /** @var string name of config file */
    protected $configFileName = 'web';
    /** @var string of path to config file */
    protected $configFilePath = '';

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
        $this->loadConfigurations()->loadServices();

        return true;
    }

    /**
     * Initialize the Console kernel.
     */
    public function run()
    {

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
}