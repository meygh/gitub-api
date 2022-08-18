<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/17/22
 * Time: 11:51 PM
 */

return [
    'token' => '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',
    'auth_type' => \Meygh\GithubApi\App\api\AuthType::OAuth,
    'services' => [
        'GitHubClient' => '\\Meygh\\GithubApi\\App\\API\\Client'
    ],
    'commands' => [
        '\\Meygh\\GithubApi\\App\\commands\\ListRepositories'
    ]
];