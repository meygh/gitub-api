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
}