<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/21/22
 * Time: 12:54 AM
 */

namespace Meygh\GithubApi\Contracts;


use Meygh\GithubApi\Base\Router;

interface iController
{
    public function __construct(Router $router, string $controller, string $action);
    public function init();
    public function beforeAction() : bool;
    public function afterAction();
    public function run();
}