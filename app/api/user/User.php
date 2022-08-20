<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/19/22
 * Time: 7:49 PM
 */

namespace Meygh\GithubApi\API\User;


use Meygh\GithubApi\API\GitHubApi;

/**
 * Class Repository API
 * @package Meygh\GithubApi\API\User
 */
class User extends GitHubApi
{
    /**
     * Get the authenticated user
     *
     * @link https://docs.github.com/en/rest/users/users#get-the-authenticated-user
     */
    public function currentUser()
    {
        return $this->get('/user');
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
    public function repos($since = null)
    {
        if (!is_int($since)) {
            return $this->get('/user/repos');
        }

        return $this->get('/user/repos', ['since' => $since]);
    }

    /**
     * Creates a repository for the authenticated user.
     * Name parameter is required.
     *
     * @link https://docs.github.com/en/rest/repos/repos#create-a-repository-for-the-authenticated-user
     *
     * @param array $parameters
     * @return mixed
     */
    public function create(array $parameters)
    {
        if (!isset($parameters['name'])) {
            exit("Name of repository is needed to create it!");
        }

        $this->requestType(true);

        $result = $this->post('/user/repos', $parameters);
        $this->validateResult();

        return $result;
    }

    /**
     * Deletes a repository of the authenticated user
     *
     * Required parameter: repo:your_repository_name
     * @link https://docs.github.com/en/rest/repos/repos#delete-a-repository
     *
     * @param array $parameters
     * @return mixed
     */
    public function deleteRepo(array $parameters)
    {
        $user = $this->currentUser();

        if (!$this->validateResult()) {
            $this->addErrorMessage('Authentication is failed!');

            return false;
        }

        if (!isset($parameters['repo'])) {
            $this->addErrorMessage('Name of your repository is needed to delete it!');

            return false;
        }

        $url = '/repos/' . $user->login . '/' . $parameters['repo'];

        $this->requestType(true);
        $result = $this->delete($url);

        if (!empty($result)) {
            $this->validateResult();
        }

        return $result;
    }
}