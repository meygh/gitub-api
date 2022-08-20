<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/18/22
 * Time: 1:03 AM
 */

namespace Meygh\GithubApi\App\api;

/**
 * Class AuthType
 * This is an enum class to determine how the client will authenticate user in GitHub.
 * @package Meygh\GithubApi\App\api
 */
final class AuthMethod
{
    /**
     * Authenticate using a combination of client_id and client_secret.
     * @var string
     */
    public const CLIENT_ID = 'client_id';

    /**
     * Authenticate using a GitHub personal access token.
     * @var string
     */
    public const OAuth = 'oauth';

    /**
     * Authenticate using a GitHub personal access token.
     * @var string
     */
    public const ACCESS_TOKEN = 'access_token';

    /**
     * JWT authentication.
     * @var string
     */
    public const JWT = 'jwt';
}