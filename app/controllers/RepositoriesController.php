<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/21/22
 * Time: 7:36 PM
 */

namespace Meygh\GithubApi\App\Controllers;


use Meygh\GithubApi\Base\Controller;

/**
 * Class RepositoriesController
 * @package Meygh\GithubApi\App\Controllers
 */
class RepositoriesController extends Controller
{
    public function filterVerbs()
    {
        return [
            'index' => 'GET'
        ];
    }

    public function actionIndex()
    {
        // Takes raw data from the request
        $json = file_get_contents('php://input');
        $params = json_decode($json);

        $api_result = (array) Service()->GitHubClient->user()->repos();
        $result = [];

        if (!isset($api_result['message'])) {
            $last_user = '';
            $repositories = [];

            foreach ($api_result as $repo) {
                if ($last_user && $last_user != $repo->owner->login) {
                    $result[] = [
                        'username' => $last_user,
                        'repositories' => $repositories
                    ];

                    $repositories = [];
                }

                $repositories[] = [
                    'full_name' => $repo->full_name,
                    'url' => $repo->html_url
                ];

                $last_user = $repo->owner->login;
            }

            $result[] = [
                'username' => $last_user,
                'repositories' => $repositories
            ];
        }

        if (isset($params->user)) {
            $result = array_filter($result, function ($item) use ($params) {
                return ($item['username'] == $params->user);
            });
        }

        return $result;
    }
}