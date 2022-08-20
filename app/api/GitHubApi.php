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

    /**
     * @param string $url
     * @param array $data
     * @return mixed
     */
    public function get(string $url, array $data = [])
    {
        return $this->client->request->get($url, $data);
    }

    /**
     * @param string $url
     * @param array $data
     * @param bool $redirection
     * @return mixed
     */
    public function post(string $url, array $data = [], bool $redirection = false)
    {
        return $this->client->request->post($url, $data, $redirection);
    }
}