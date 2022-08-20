<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/19/22
 * Time: 1:04 PM
 */

namespace Meygh\GithubApi\API;

use Meygh\GithubApi\Base\Api;

/**
 * Class GitHubApi
 * This class is an enum list of GitHub api names
 * @package Meygh\GithubApi\App\api
 */
abstract class GitHubApi extends Api
{
    /** @var Client */
    protected $client;

    public function __construct(Client $client)
    {
        parent::__construct();
        $this->client = $client;
    }
}