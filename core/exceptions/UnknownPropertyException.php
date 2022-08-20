<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/17/22
 * Time: 8:16 PM
 */

namespace Meygh\GithubApi\exceptions;


use Throwable;

class UnknownPropertyException extends \Exception
{
    /**
     * UnkownPropertyException constructor.
     * @param string $name of command signature
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $name = "", int $code = 0, Throwable $previous = null)
    {
        $trace = debug_backtrace();
        // Get the class that is asking for who awoke it
        $class = $trace[1]['class'];

        $message = "property `$name` is not defined in `" .$class. "`!";

        parent::__construct($message, $code, $previous);
    }
}