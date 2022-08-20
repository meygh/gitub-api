<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/20/22
 * Time: 4:56 PM
 */

namespace Meygh\GithubApi\App\Commands;


use Meygh\GithubApi\Base\CommandBase;

/**
 * Class GitHubCommandBase
 * @package Meygh\GithubApi\App\Commands
 */
abstract class GitHubCommandBase extends CommandBase
{
    /** @var \Meygh\GithubApi\API\Client $client */
    protected $apiClient;

    public function init()
    {
        $this->apiClient = Service()->GitHubClient;
    }
}