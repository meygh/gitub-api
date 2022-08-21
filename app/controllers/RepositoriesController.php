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
    public function actionIndex()
    {
        return [
            'status' => true,
            'msg' => 'Repositories Controller Action index!'
        ];
    }
}