<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/18/22
 * Time: 7:06 PM
 */

namespace Meygh\GithubApi\API\Repos;


use Meygh\GithubApi\API\GitHubApi;

/**
 * Class Repository API
 * @package Meygh\GithubApi\API\User
 */
class Repository extends GitHubApi
{
    /**
     * Lists all public repositories.
     *
     * @since Only show notifications updated after the given time.
     * This is a timestamp in ISO 8601 format: YYYY-MM-DDTHH:MM:SSZ
     *
     * @link https://docs.github.com/en/rest/repos/repos#list-public-repositories
     *
     * @param int|null $since timestamp
     * @return array list of users found
     */
    public function all($since = null)
    {
        if (!is_int($since)) {
            return $this->get('repositories');
        }

        return $this->get('repositories', ['since' => $since]);
    }

    /**
     * Lists repositories that the authenticated user
     * has explicit permission (:read, :write, or :admin) to access.
     *
     * @since Only show notifications updated after the given time.
     * This is a timestamp in ISO 8601 format: YYYY-MM-DDTHH:MM:SSZ
     *
     * @link https://docs.github.com/en/rest/repos/repos#list-repositories-for-the-authenticated-user
     *
     * @param int|null $since timestamp
     * @return array list of users found
     */
    public function user($since = null)
    {
        if (!is_int($since)) {
            return $this->get('/user/repos');
        }

        return $this->get('/user/repos', ['since' => $since]);
    }
}