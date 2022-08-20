<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/20/22
 * Time: 12:53 PM
 */

namespace Meygh\GithubApi\App\Commands;


use Meygh\GithubApi\Base\CommandBase;
use Meygh\GithubApi\contracts\CommandInterface;


/**
 * Command ListRepositories
 * @package Meygh\GithubApi\App\commands
 */
class PrivateRepositories extends CommandBase
{
    /** @var \Meygh\GithubApi\API\Client $client */
    protected $gitHubClient;

    /** @var string */
    public static $signature = 'user-repos';

    public function init()
    {
        $this->gitHubClient = Service()->GitHubClient;
    }

    public function run(array $args = []): CommandInterface
    {
        echo "List of your github repositories.\n\n";

        $allRepositories = $this->gitHubClient->user()->repos($this->arguments('since'));

        echo count($allRepositories);

        return $this;
    }
}
