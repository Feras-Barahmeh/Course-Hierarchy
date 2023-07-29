<?php

namespace App\Core;

use App\Helper\HandsHelper;
use App\Models\StudentModel;

class Engine
{
    use HandsHelper;
    const NOT_FOUND_CONTROLLER = "App\Controllers\NotFoundController";

    /**
     * Default controller name.
     *
     * This property holds the name of the default controller to be used when no specific controller
     * is specified in the URL or when the requested controller is not found. The default controller
     * typically represents the main entry point of the application or a default landing page.
     *
     * @var string
     */
    protected string $controller = 'index';
    /**
     * Default action (method in the controller) name.
     *
     * This property holds the name of the default action (method in the controller) to be executed
     * when no specific action is specified in the URL or when the requested action method is not found
     * in the controller. The default action is typically the method that handles the primary functionality
     * of the controller or a default action to be executed when no specific action is requested.
     *
     * @var string
     */
    protected string $action       = "index";
    /**
      * Parameters from the URLs query string (GET method).
      *
      * This property holds an array of parameters extracted from the URL's query string when using
      * the GET method. Parameters are additional data sent with the request and are typically used
      * to provide inputs or instructions to the controller's action method.
      *
      * @var array|null
      */
    protected array|null $params    = [];

    /**
     * Registration object.
     *
     * This property represents an instance of the `Registration` class, which is used as a registration object
     * or container in the context of the application. The `Registration` class likely provides a mechanism to
     * register and store various components, services, or shared objects to be accessed across the application.
     *
     * @var Registration
     */
    private  Registration $registry;

    public function __construct( Registration $registry)
    {
        $this->registry = $registry;
        $this->paresURL();
    }
    /**
     * to set name controller
     * @param string $controller the name controller
     * @return void
     */
    public function setController(string $controller): void
    {
        $this->controller = ! $controller ? $this->controller : $controller;
    }
    /**
     * to set name action
     * @param string|null $name the name action
     * @return void
     */
    public function setAction(string|null $name): void
    {
        $this->action = ! $name ? $this->action : $name;
    }
    /**
     * to set name params
     * @param array $names the params
     * @return void
     */
    public function setParam(array $names): void
    {
        $this->params = ! $names ? $this->params : $names;
    }

    /**
     * Parse the URL of the incoming request and extract the controller, action, and parameters.
     *
     * This method is used to extract essential information from the URL of the incoming request
     * and sets the controller, action, and parameters accordingly. The URL is parsed to determine
     * the structure of the requested page, which typically follows the pattern: /controller/action/param1/param2/...
     * The method uses PHP's built-in `parse_url()` and `explode()` functions to extract the information.
     * If a specific part of the URL is missing, the method sets default values to handle such cases.
     *
     * @return void
     */
    private function paresURL(): void
    {
        $url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $url = explode(DS,  trim($url, DS), 3);

        $this->setController(@$url[0]);
        $this->setAction(@$url[1]);
        $this->setParam((array)@$url[2]);
    }

    /**
     * Process the incoming request and execute the corresponding action method.
     *
     * This method is responsible for handling incoming requests, identifying the appropriate
     * controller and action based on the requested page's name, and then executing the
     * corresponding action method. It also performs checks to ensure the existence of the
     * requested controller and action method and handles certain authentication scenarios.
     *
     * @return void
     */
    public function request(): void
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $controllerClass    =  "\App\Controllers\\" . ucfirst($this->controller) . "Controller";
        $actionMethod      = $this->action;


        if (! class_exists($controllerClass)) {
            $controllerClass = self::NOT_FOUND_CONTROLLER;
            $actionMethod = "controllerNotFount";
        }

        if (! method_exists((new $controllerClass), $actionMethod)) {
            $controllerClass = self::NOT_FOUND_CONTROLLER;
            $this->action = $actionMethod = "actionNotFound";
        }

        if (! Auth::isLogged()) {
            $controllerClass = "\App\Controllers\AuthController";
            $this->controller = 'auth';
            $this->action = $actionMethod = "login";
        }
        $controller = new $controllerClass();

        $controller->setController($this->controller);
        $controller->setAction($this->action);
        $controller->setParams($this->params);
        $controller->setRegistry($this->registry);
        $controller->setLang(Session::get("lang"));
        $controller->$actionMethod();

    }
}