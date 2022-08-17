<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/17/22
 * Time: 7:35 PM
 */

/**
 * Return a specific array element without any exception.
 *
 * @param array $array
 * @param $index
 * @param null $default
 * @param bool $pop
 * @return mixed|null true to unset after read the array element
 */
function array_get(array &$array, $index, $default = null, $pop = false)
{
    $value = $default;

    if (isset($array[$index])) {
        $value = $array[$index];

        if ($pop) {
            unset($array[$index]);
        }
    }


    return $value;
}