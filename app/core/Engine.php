<?php

namespace App\Core;

class Engine
{
    const NOT_FOUND_CONTROLLER = "App\Controllers\NotFoundController";
    const  NOT_FOUND_ACTION = "NotFoundAction";
    /**
     * name controller default index
     * @var string
     */
    protected string $controller = 'index';
    /**
     * name action (method in controller) default name is default
     * @var string
     */
    protected string $action       = "index";
    /**
     * params in GET url
     * @var array|null
     */
    protected array|null $params    = [];
    /**
     * template object
     * @var Template
     */
    private Template  $template;
    /**
     * registration object
     * @var Registration
     */
    private  Registration $registry;

    public function __construct(Template $temp, Registration $registry)
    {
        $this->template = $temp;
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
     * method to pares url and set values in specific property
     * @return void
     * @version 1.0
     * @author Feras Barahmeh
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
     * request page depend name controller
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

        $controller = new $controllerClass();

        $controller->setController($this->controller);
        $controller->setAction($this->action);
        $controller->setParams($this->params);
        $controller->setTemplate($this->template);
        $controller->setRegistry($this->registry);

        $controller->$actionMethod();

    }
}