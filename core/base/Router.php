<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/21/22
 * Time: 12:58 AM
 */

namespace Meygh\GithubApi\Base;



use Meygh\GithubApi\Contracts\iController;

/**
 * Class Router.
 * This class will do routing to load requested controller and run its action.
 *
 * @package core\base
 */
class Router extends Component
{
    /** @var iController */
    protected $controller;
    /** @var callable action method */
    protected $action;

    /** @var string */
    public $controllerPath;
    /** @var string */
    public $controllerNamespace;
    /** @var string */
    public $defaultController = 'default';
    /** @var string */
    public $defaultAction = 'index';

    /**
     * Router initializer.
     * @throws \Exception
     */
    public function init()
    {
        $this->validateControllerPath();
        $this->lunch();
    }

    /**
     * @throws \Exception
     */
    protected function validateControllerPath()
    {
        if (empty($this->controllerPath)) {
            $this->controllerPath = 'app/controllers';
            $this->controllerNamespace = '\\Meygh\GithubApi\App\\Controllers\\';
        }

        if (!is_dir($this->controllerPath)) {
            throw new \Exception("Invalid controller path `$this->controllerPath`");
        }

        if (is_null($this->controllerNamespace)) {
            $this->controllerNamespace = str_replace('/', '\\', $this->controllerPath). '\\';
        }

        $this->controllerPath .= DS;
    }

    /**
     * @throws \Exception
     */
    public function lunch()
    {
        $route = get('page', $this->defaultController, 'string', true);
        $routeParts = explode('/', $route); // Limit to controller/action but it is possible to add some url route pattern

        $_controller = array_get($routeParts, 0);
        $this->controller = sanitize_router($_controller, true);
        $controller = $this->controllerNamespace . $this->controller . 'Controller';

        if ($_controller != 'page-not-found' && !class_exists($controller)) {
            redirect_to_not_found_page();
        }

        $this->action = sanitize_router(array_get($routeParts, 1, $this->defaultAction));

        if (!class_exists($controller)) {
            throw new \Exception("Controller `$controller` was not found!");
        }

        $controller = call_user_func([new \ReflectionClass($controller), 'newInstance'], $this, $this->controller, $this->action);

        if (!is_a($controller, '\\Meygh\\GithubApi\\Contracts\\iController')) {
            throw new \Exception("The controller must be instance of `\\Meygh\\GithubApi\\base\\Controller`");
        }
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }
}