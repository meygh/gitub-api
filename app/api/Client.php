<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/18/22
 * Time: 1:12 AM
 */

namespace Meygh\GithubApi\API;


use BadMethodCallException;
use InvalidArgumentException;
use Meygh\GithubApi\App\api\AuthMethod;
use Meygh\GithubApi\Base\Api;
use RuntimeException;

/**
 * Class Client
 * @package Meygh\GithubApi\App\API
 *
 * @method \Meygh\GithubApi\API\User\User user()
 * @method \Meygh\GithubApi\API\Repos\Repository repos()
 */
class Client extends Api
{
    /** @var string */
    private $authMethod;

    /** @var string of the app token */
    private $token;

    /** @var string|null */
    private $password;

    /**
     * Initialize GitHub API client.
     * @throws \ErrorException
     */
    protected function init()
    {
        parent::init();

        $this->authMethod = Kernel()->getConfig('authMethod');
        $this->token = Kernel()->getConfig('token');

        $this->header('Accept', 'application/vnd.github+json');
        $this->authenticate();
    }

    /**
     * Authenticate user and returns its info.
     *
     * @link https://docs.github.com/en/rest/users/users#get-the-authenticated-user
     */
    protected function authenticate(): void
    {
        $this->header('Authorization', $this->getAuthorizationHeader());
    }

    /**
     * @param string $api_name
     * @return GitHubApi
     */
    public function api(string $api_name): GitHubApi
    {
        return ApiList::build($this, $api_name);
    }

    /**
     * @param string $api_name
     * @param $args
     * @return GitHubApi
     */
    public function __call($api_name, $args): GitHubApi
    {
        try {
            return $this->api($api_name);
        } catch (InvalidArgumentException $e) {
            throw new BadMethodCallException(sprintf('Undefined method called: "%s"', $api_name));
        }
    }

    /**
     * Returns token part of header to authenticate user
     * @return string
     */
    private function getAuthorizationHeader(): string
    {
        switch ($this->authMethod) {
            case AuthMethod::CLIENT_ID:
                return sprintf('Basic %s', base64_encode($this->token.':'.$this->password));
//            case AuthMethod::OAuth:
            case AuthMethod::ACCESS_TOKEN:
                return sprintf('token %s', $this->token);
            case AuthMethod::JWT:
                return sprintf('Bearer %s', $this->token);
            default:
                throw new RuntimeException(sprintf('%s login method is not yet implemented', $this->authMethod));
        }
    }
}