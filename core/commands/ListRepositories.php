<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/18/22
 * Time: 12:28 AM
 */

namespace Meygh\GithubApi\Commands;


use Meygh\GithubApi\Base\CommandBase;
use Meygh\GithubApi\contracts\CommandInterface;

/**
 * Command ListRepositories
 * @package Meygh\GithubApi\Commands
 */
class ListRepositories extends CommandBase
{
    public static $signature = 'list-repositories';

    public function run(array $argv = []): CommandInterface
    {
        echo "List of your github repositories.\n\n";

        return $this;
    }
}
