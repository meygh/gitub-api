<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/17/22
 * Time: 11:51 PM
 */

return [
    'baseUrl' => 'https://api.github.com',
    'appID' => '230178',
    'clientID' => 'Iv1.db897b30273661f5',
    'token' => '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',
    'authMethod' => \Meygh\GithubApi\App\api\AuthMethod::ACCESS_TOKEN,

    'services' => [
        'Router' => [
            'class' => '\\Meygh\\GithubApi\\Base\\Router',

            'controllerPath' => 'app/controllers',
            'controllerNamespace' => '\\Meygh\GithubApi\App\\Controllers\\'
        ],
        'GitHubClient' => '\\Meygh\\GithubApi\\API\\Client'
    ]
];