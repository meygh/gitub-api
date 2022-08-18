<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/18/22
 * Time: 8:32 PM
 */

namespace Meygh\GithubApi;


use ErrorException;
use ReflectionClass;
use ReflectionException;
use RuntimeException;

/**
 * Class Service
 * @package Meygh\GithubApi
 */
class Service extends Singleton
{
    /**
     * Container of classes which are assigned as a service.
     * @var array
     */
    private $instances = [];

    /**
     * Checks whether an instance of given class name is exists or not.
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return isset($this->instances[$name]);
    }

    /**
     * Assigns a new definition the a specific name.
     * @param string $name
     * @param $definition
     * @param array $params
     * @param bool $is_singleton
     * @return mixed|object
     * @throws ErrorException
     * @throws \ReflectionException
     */
    public function assign(string $name, $definition, array $params = [], bool $is_singleton = true)
    {
        if (isset($this->instances[$name])) {
            return $this->get($name);
        }

        if (is_array($definition)) {
            $class = array_get($definition, 'class', null, true);

            if (!$class) {
                throw new ErrorException('The definition parameter must contains `class` index!');
            }

            $params = $definition;
        } else {
            $class = $definition;
        }

        $this->instances[$name] = [
            'class' => $class,
            'singleton' => $is_singleton,
            'params' => $params
        ];

        return $this->get($name);
    }

    /**
     * Sets class to the container.
     * @param string $name
     * @param $definition
     * @param array $params
     * @return mixed|object
     * @throws ErrorException
     * @throws \ReflectionException
     */
    public function set(string $name, $definition, array $params = [])
    {
        if (is_array($definition)) {
            $class = array_get($definition, 'class', null, true);

            if (!$class) {
                throw new ErrorException('the definition should has a`class` index!');
            }

            $params = $definition;
        } else {
            $class = $definition;
        }

        $this->instances[$name] = [
            'class' => $class,
            'singleton' => false,
            'params' => $params
        ];

        return $this->get($name);
    }

    /**
     * Get instance of given class definition.
     * if this class is not already exist will set automatically.
     * @param string $definition
     * @param array $params
     * @return mixed|object
     * @throws ErrorException
     * @throws \ReflectionException
     */
    public function get(string $definition, $params = [])
    {
        if (!isset($this->instances[$definition])) {
            if (!strstr($definition, '\\')) {
                throw new ErrorException('Concrete class namespace is invalid!');
            }

            $name = substr(strrchr($definition, '\\'), 0);

            $this->set($name, $definition);
        }

        if ($concrete = array_get($this->instances[$definition], 'class')) {
            return $this->resolve($concrete, array_get($this->instances[$definition], 'params', $params));
        }

        throw new ErrorException('Concrete class namespace is invalid!');
    }

    /**
     * Resolves the class namespace to make an object.
     * @param \Closure|string $concrete
     * @param array $params
     * @return mixed|object
     * @throws ErrorException
     * @throws ReflectionException
     */
    public function resolve($concrete, $params = [])
    {
        if ($concrete instanceof \Closure) {
            return $concrete($this, $params);
        }

        if (!class_exists($concrete)) {
            throw new ReflectionException("Class `$concrete` is not exists!");
        }

        $reflector = new ReflectionClass($concrete);

        if (!$reflector->isInstantiable()) {
            throw new RuntimeException("Class `$concrete` is not instantiable!");
        }

        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            return $reflector->newInstance();
        }

        $implements = class_implements($concrete);

        if (!isset($implements['core\contracts\iComponent'])) {
            // Get parameters of concrete constructor
            $constructor_params = $constructor->getParameters();

            if (!empty($params)) {
                foreach ($constructor_params as $k => $cparam) {
                    if (isset($params[$cparam->name])) {
                        $constructor_params[$k][$cparam->name] = $params[$cparam->name];
                    }
                }
            }

            $parameters = $this->getDependencies($constructor_params);

            return $reflector->newInstanceArgs($parameters);
        }

        return $reflector->newInstanceArgs([$params]);
    }

    /**
     * Fetches dependencies of requested instance.
     * @param array $parameters
     * @return array
     * @throws ErrorException
     * @throws ReflectionException
     */
    public function getDependencies(array $parameters): array
    {
        $dependencies = [];

        foreach ($parameters as $key => $parameter) {
            if (is_object($parameter) && $dependency = $parameter->getClass()) {
                $dependencies[$key] = $this->get($dependency->name);
            } else {
                $dependencies[$key] = $parameter;
            }
        }

        return $dependencies;
    }

    /**
     * @param string $name
     * @return mixed|object
     * @throws ErrorException
     * @throws ReflectionException
     */
    public function __get(string $name)
    {
        if (isset($this->instances[$name])) {
            return $this->get($name);
        }

        throw new ErrorException("Undefined component or concrete class `$name`");
    }
}