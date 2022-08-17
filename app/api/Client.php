<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/18/22
 * Time: 1:12 AM
 */

namespace Meygh\GithubApi\App\api;

use Meygh\GithubApi\Singleton;

class Client extends Singleton
{
    /** @var string of the app token */
    protected $token;

    /** @var string of the api to run */
    protected $api;

    /**
     * Initialize GitHub API client.
     */
    public function init()
    {
        $this->token = Kernel()->getConfig('token');
    }

    /**
     * Sets api command to execute its actions.
     * @param string $api_name
     */
    public function api(string $api_name)
    {
        $this->api = $api_name;
    }
}