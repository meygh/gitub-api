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
        if (!is_a($this->client, '\\Meygh\\GithubApi\\API')) {
            parent::__construct();
            $this->client = $client;
        }
    }

    /**
     * Sets Content-Type for the request
     * @param bool $json
     */
    public function requestType(bool $json = false)
    {
        $type = 'application/x-www-form-urlencoded';

        if ($json) {
            $type = 'application/json';
        }

        $this->client->header('Content-Type', $type);
    }

    /**
     * Checks and parse errors if an API request has been failed.
     * @return bool
     */
    public function validateResult()
    {
        $result = $this->client->request->response;

        if (!$result) {
            $this->addErrorMessage("Server connection has been failed!");

            return false;
        } elseif (isset($result->message)) {
            $this->addErrorMessage($result->message);

            if (isset($result->errors)) {
                foreach ($result->errors as $errorInfo) {
                    $this->addErrorInfo((array) $errorInfo);
                }
            }

            return false;
        }

        return true;
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

    /**
     * @param string $url
     * @param array $query_parameters
     * @param array $data
     * @return mixed
     */
    public function delete(string $url, array $query_parameters = [], array $data = [])
    {
        return $this->client->request->delete($url, $query_parameters, $data);
    }
}