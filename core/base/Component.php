<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/18/22
 * Time: 7:10 PM
 */

namespace Meygh\GithubApi\Base;


use Meygh\GithubApi\exceptions\ReadOnlyPropertyException;
use Meygh\GithubApi\exceptions\UnknownMethodException;
use Meygh\GithubApi\exceptions\UnknownPropertyException;

/**
 * Class Base Component.
 *
 * If you want to make a read-only dynamic property,
 * you will only need to define a getter method.
 *
 * @package Meygh\GithubApi\Base
 */
abstract class Component
{
    /**
     * @var array of dynamic properties
     */
    protected $properties = [];

    /**
     * Component constructor.
     * The init() method will calls automatically for the first time.
     */
    public function __construct() {
        // Calls init() method of wrapper class if defined
        if ($this->hasMethod('init')) {
            try {
                $this->init();
            } catch (\Exception $e) {
                exit($e->getMessage());
            }
        }
    }

    /**
     * Set value to given property if it is exists and is not read-only.
     * @param string $name
     * @param $value
     * @return true
     * @throws ReadOnlyPropertyException
     * @throws UnknownPropertyException
     */
    protected function setValue(string $name, $value)
    {
        if ($setter = $this->canSetProperty($name)) {
            $this->{$setter}($value);

            return true;
        }

        if ($this->canGetProperty($name)) {
            throw new ReadOnlyPropertyException($name);
        }

        if ($this->issetProperty($name)) {
            $this->properties[$name] = $value;

            return true;
        }

        throw new UnknownPropertyException($name);
    }

    /**
     * Set value to given property if it is exists and is not read-only.
     * @param string $name
     * @param $value
     * @throws ReadOnlyPropertyException
     * @throws UnknownPropertyException
     */
    public function __set(string $name, $value)
    {
        $this->setValue($name, $value);
    }

    /**
     * Return value of given property if already exists.
     * @param string $name
     * @return mixed|null
     * @throws UnknownPropertyException
     */
    #[ReturnTypeWillChange]
    public function __get(string $name)
    {
        if ($getter = $this->canGetProperty($name)) {
            return $this->{$getter}();
        }

        if ($this->issetProperty($name)) {
            return array_get($this->properties, $name);
        }

        throw new UnknownPropertyException($name);
    }

    /**
     * Checks whether a getter method is exists or not.
     * @param string $name
     * @return bool
     */
    public function __isset(string $name): bool
    {
        $getter = $this->getterMethod($name);

        if (method_exists($this, $getter)) {
            return $this->$getter() !== null;
        }

        return false;
    }

    /**
     * Unset a particular property if is writable.
     * @param string $name of the property
     * @return true
     * @throws ReadOnlyPropertyException
     * @throws UnknownPropertyException
     */
    public function __unset(string $name)
    {
        return $this->setValue($name, null);
    }

    /**
     * When a method is not exists or not callable this method will be called.
     * @param string $name
     * @param $arguments
     * @throws UnknownMethodException
     */
    public function __call(string $name, $arguments)
    {
        throw new UnknownMethodException($name);
    }

    /**
     * Reset last object properties when a new one is cloned.
     */
    public function __clone()
    {
        $this->properties = [];
    }

    /**
     * Checks whether a particular property is exists and can be used or not.
     * @param string $name of target property
     * @return bool
     */
    public function hasProperty(string $name): bool
    {
        return $this->canSetProperty($name) && $this->canGetProperty($name);
    }

    /**
     * Checks whether the Object has the method and its callable or not.
     * @param string $name of target property
     * @return bool
     */
    public function hasMethod(string $name): bool
    {
        return method_exists($this, $name);
    }

    /**
     * Checks whether a dynamic property is defined or not.
     * @param string $name
     * @return bool
     */
    public function issetProperty(string $name): bool
    {
        return isset($this->properties[$name]);
    }

    /**
     * Returns setter method name.
     * @param string $name
     * @return string
     */
    public function setterMethod(string $name): string
    {
        return 'set' . ucfirst($name);
    }

    /**
     * Returns getter method name.
     * @param string $name
     * @return string
     */
    public function getterMethod(string $name): string
    {
        return 'get' . ucfirst($name);
    }

    /**
     * Checks whether the Object has any callable getter method or not.
     * it will returns name of the setter method.
     * @param string $name of target property
     * @return false|string
     */
    public function canSetProperty(string $name): bool
    {
        $setter = $this->setterMethod($name);

        return method_exists($this, $setter) ? $setter : false;
    }

    /**
     * Checks whether the Object has any callable setter method or not.
     * it will returns name of the getter method.
     * @param string $name of target property
     * @return false|string
     */
    public function canGetProperty(string $name)
    {
        $getter = $this->getterMethod($name);

        if ($this->hasMethod($getter)) {
            return $getter;
        }

        return false;
    }
}