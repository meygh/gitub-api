<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/18/22
 * Time: 12:28 AM
 */

namespace Meygh\GithubApi\App\Commands;


use Meygh\GithubApi\Base\CommandBase;
use Meygh\GithubApi\contracts\CommandInterface;


/**
 * Command ListRepositories
 * @package Meygh\GithubApi\App\commands
 */
class ListRepositories extends CommandBase
{
    /** @var \Meygh\GithubApi\API\Client $client */
    protected $gitHubClient;

    /** @var string */
    public static $signature = 'repositories';

    public function init()
    {
        $this->gitHubClient = Service()->GitHubClient;
    }

    public function run(array $argv = []): CommandInterface
    {
        echo "List of your github repositories.\n\n";

        $allRepositories = $this->gitHubClient->repos()->user();

        pd($allRepositories);
        echo count($allRepositories);

        return $this;
    }
}
