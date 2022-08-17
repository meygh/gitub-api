<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/17/22
 * Time: 8:16 PM
 */

namespace Meygh\GithubApi\exceptions;


use Throwable;

class InvalidCommand extends \Exception
{
    /**
     * InvalidCommand constructor.
     * @param string $command_signature of command signature
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $command_signature = "", int $code = 0, Throwable $previous = null)
    {
        $message = "Error! The command of `{$command_signature}` is invalid!";

        parent::__construct($message, $code, $previous);
    }
}