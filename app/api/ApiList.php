<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/19/22
 * Time: 4:00 PM
 */

namespace Meygh\GithubApi\API;


use PHPUnit\Framework\MockObject\UnknownClassException;

final class ApiList
{
    private static $baseNamespace = '\\Meygh\\GithubApi\\API\\';

    private static $list = [
        'user' => 'user\\User',
        'repos' => 'user\\Repository'
    ];

    /**
     * @param string $api_name
     * @return false|string
     */
    public static function get(string $api_name)
    {
        if (!$api_name) {
            return false;
        }

        if ($api = array_get(self::$list, $api_name)) {
            $api_class = self::$baseNamespace . $api;
            
            return $api_class;
        }

        return false;
    }

    /**
     * @param Client $client
     * @param string $api_name
     * @return GitHubApi
     */
    public static function build(Client $client, string $api_name): GitHubApi
    {
        $api_class = self::get($api_name);

        if ($api_class) {
            try {
                return new $api_class($client);
            }  catch (\Exception $e) {
                throw new UnknownClassException($api_class);
            }
        }

        throw new UnknownClassException($api_class);
    }
}