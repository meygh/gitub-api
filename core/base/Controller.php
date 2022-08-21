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
    /**
     * @var string of current controller extends of base\controller
     */

    public $controller;
    /**
     * @var string name of action method in current controller
     */
    public $action;


    protected $router;
    protected $controllerName;
    protected $controllerRoute;

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

    public function getControllerName()
    {
        return $this->controllerName;
    }

    public function getControllerRoute()
    {
        return $this->controllerRoute;
    }

    /**
     * Doing something or validate something before run action method.
     * @return bool
     */
    public function beforeAction(): bool
    {
        return true;
    }

    /**
     * Doing something after run action method.
     */
    public function afterAction()
    {

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