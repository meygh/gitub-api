<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/18/22
 * Time: 12:20 AM
 */

namespace Meygh\GithubApi\Commands;


use Meygh\GithubApi\Base\CommandBase;
use Meygh\GithubApi\Contracts\iCommand;

/**
 * Command ListRepositories
 * @package Meygh\GithubApi\Commands
 */
class ListCommands extends CommandBase
{
    public static $signature = 'list-commands';

    public function run(array $argv = []): iCommand
    {
        echo "\n----------------------------------------\n";
        echo "\n** Welcome to GitHub API console **\n\n\n";

        if ($commands_list = Console()->getCommandList()) {
            echo "You can use the following commands on this CLI application:\n";

            foreach ($commands_list as $command) {
                echo "\t> " . $command . "\n";
            }

            echo "\n----------------------------------------\n\n";
        }

        return $this;
    }
}
