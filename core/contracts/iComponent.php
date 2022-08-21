<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/21/22
 * Time: 7:03 PM
 */

namespace Meygh\GithubApi\Contracts;


interface iComponent
{
    /**
     * Checks whether a particular property is exists and can be used or not.
     * @param string $name of target property
     * @return bool
     */
    public function hasProperty(string $name): bool;

    /**
     * Checks whether the Object has the method and its callable or not.
     * @param string $name of target property
     * @return bool
     */
    public function hasMethod(string $name): bool;

    /**
     * Checks whether a dynamic property is defined or not.
     * @param string $name
     * @return bool
     */
    public function issetProperty(string $name): bool;

    /**
     * Returns setter method name.
     * @param string $name
     * @return string
     */
    public function setterMethod(string $name): string;

    /**
     * Returns getter method name.
     * @param string $name
     * @return string
     */
    public function getterMethod(string $name): string;

    /**
     * Checks whether the Object has any callable getter method or not.
     * it will returns name of the setter method.
     * @param string $name of target property
     * @return false|string
     */
    public function canSetProperty(string $name): bool;

    /**
     * Checks whether the Object has any callable setter method or not.
     * it will returns name of the getter method.
     * @param string $name of target property
     * @return false|string
     */
    public function canGetProperty(string $name);
}