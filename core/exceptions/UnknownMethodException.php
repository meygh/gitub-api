<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/17/22
 * Time: 8:16 PM
 */

namespace Meygh\GithubApi\exceptions;


use Throwable;

class UnknownMethodException extends \Exception
{
    /**
     * UnknownMethodException constructor.
     * @param string $name of command signature
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $name = "", int $code = 0, Throwable $previous = null)
    {
        $trace = debug_backtrace();
        // Get the class that is asking for who awoke it
        $class = $trace[1]['class'];

        $message = "Unknown method " . $class . "::{$name}() was called!";

        parent::__construct($message, $code, $previous);
    }
}