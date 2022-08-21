<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/21/22
 * Time: 1:21 AM
 */

namespace Meygh\GithubApi\App\Controllers;


use Meygh\GithubApi\Base\Controller;


class PageNotFoundController extends Controller
{
    public function beforeAction(): bool
    {
        if (parent::beforeAction()) {
            header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);

            return true;
        }

        return false;
    }

    public function actionIndex($msg = '')
    {
        return [
            'status' => false,
            'msg' => ($msg ?: 'Page was not found!')
        ];
    }
}