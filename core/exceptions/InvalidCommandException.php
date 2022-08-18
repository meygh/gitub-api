<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/17/22
 * Time: 8:16 PM
 */

namespace Meygh\GithubApi\exceptions;


use Throwable;

class InvalidCommandException extends \Exception
{
    /**
     * InvalidCommand constructor.
     * @param string $name of command signature
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $name = "", int $code = 0, Throwable $previous = null)
    {
        $message = "Error! The command of `{$name}` is invalid!";

        parent::__construct($message, $code, $previous);
    }
}