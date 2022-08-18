<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/17/22
 * Time: 8:16 PM
 */

namespace Meygh\GithubApi\exceptions;


use Throwable;

class ReadOnlyPropertyException extends \Exception
{
    /**
     * ReadOnlyPropertyException constructor.
     * @param string $name of command signature
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $name = "", int $code = 0, Throwable $previous = null)
    {
        $message = "`$name` is a read-only property and you're not allowed to set a value!";

        parent::__construct($message, $code, $previous);
    }
}