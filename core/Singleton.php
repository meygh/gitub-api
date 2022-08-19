<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/17/22
 * Time: 7:36 PM
 */

namespace Meygh\GithubApi;


abstract class Singleton
{
    /**
     * The Singleton's instance is stored in a static field. This field is an
     * array, because we'll allow our Singleton to have subclasses. Each item in
     * this array will be an instance of a specific Singleton's subclass.
     */
    private static $instances = [];

    /**
     * The Singleton's constructor should always be private to prevent direct.
     * construction calls with the `new` operator.
     */
    final public function __construct() {}

    /**
     * Singletons should not be cloneable.
     */
    private function __clone() { }

    /**
     * Object initializer method which should  defined in the wrapper class.
     */
    public function init()
    {
    }

    /**
     * Singletons should not be unserializable.
     * @throws \Exception
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot deserialize a singleton object.");
    }

    /**
     * This is the static method that controls the access to the singleton
     * instance. On the first run, it creates a singleton object and places it
     * into the static field. On subsequent runs, it returns the client existing
     * object stored in the static field.
     */
    public static function getInstance()
    {
        $cls = static::class;

        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();

            // Calls init() method of wrapper class if defined
            if (method_exists(self::$instances[$cls], 'init')) {
                self::$instances[$cls]->init();
            }
        }

        return self::$instances[$cls];
    }
}