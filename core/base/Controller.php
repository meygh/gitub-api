<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/21/22
 * Time: 12:53 AM
 */

namespace Meygh\GithubApi\Base;


use Meygh\GithubApi\Contracts\iController;


/**
 * Class Controller is the base controller.
 * @package core\base
 */
class Controller implements iController
{
    /** @var Router */
    protected $router;

    /** @var string */
    protected $controllerName;

    /** @var string */
    protected $controllerRoute;

    /**
     * @var string of current controller extends of base\controller
     */
    public $controller;

    /** @var string of action name */
    public $actionName;

    /**
     * @var string name of action method in current controller
     */
    public $action;

    /**
     * Controller constructor.
     * @param Router $router
     * @param string $controller
     * @param string $action
     * @throws \Exception
     */
    public function __construct(Router $router, string $controller, string $action)
    {
        $this->router = $router;
        $this->controllerRoute = camel_to_dashed($controller);
        $this->controllerName = $controller;
        $this->controller = static::class;
        $this->actionName = $action;
        $this->action = 'action' . ucfirst($action);

        if (!method_exists($this->controller, $this->action)) {
            redirect_to_not_found_page();
        }

        $this->init();
        $this->run();
    }

    public function init()
    {

    }

    public function filterVerbs()
    {
        return [];
    }

    public function getControllerName()
    {
        return $this->controllerName;
    }

    public function getControllerRoute()
    {
        return $this->controllerRoute;
    }

    public function getActionName()
    {
        return $this->actionName;
    }

    /**
     * Doing something or validate something before run action method.
     * @return bool
     */
    public function beforeAction(): bool
    {
        if ($this->validateRoute()) {
            return true;
        }

        return false;
    }

    /**
     * Doing something after run action method.
     */
    public function afterAction()
    {

    }

    protected function validateRoute()
    {
        $filters = $this->filterVerbs();

        if ($methods = (array) array_get($filters, $this->getActionName())) {
            if (in_array($_SERVER['REQUEST_METHOD'], $methods)) {
                return true;
            }

            throw new \RuntimeException('You are not allowed to perform this action');
        }

        return true;
    }

    /**
     * Run action method if beforeRun() method returns true.
     */
    public function run()
    {
        if ($this->beforeAction()) {
            $output = call_user_func_array([$this, $this->action], get());

            if (is_string($output)) {
                echo $output;
            } elseif (is_array($output) || is_object($output)) {
                echo $this->jsonResponse($output);
            }

            $this->afterAction();
        }
    }

    /**
     * Sets json application as header for response
     */
    public function setJsonResponse()
    {
        header('Content-Type: application/json');
    }

    /**
     * Generates and return json response
     * @param string|mixed $params
     */
    public function jsonResponse($params)
    {
        $this->setJsonResponse();
        echo json_encode((array) $params);
        exit;
    }
}