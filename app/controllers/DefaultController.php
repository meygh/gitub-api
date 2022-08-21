<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/21/22
 * Time: 1:29 AM
 */

namespace Meygh\GithubApi\App\Controllers;


use Meygh\GithubApi\Base\Controller;


class DefaultController extends Controller
{
    public function actionIndex()
    {
        return [
            'status' => true,
            'msg' => 'Default Controller Action index!'
        ];
    }
}
