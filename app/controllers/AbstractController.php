<?php

namespace App\Controllers;

use App\Core\Registration;
abstract  class AbstractController
{
    /**
     * controller name
     * @var string $controller
     */
    protected string $controller;
    /**
     * action name
     * @var string $action
     */
    protected  string $action;
    /**
     * params name
     * @var array|null  $params
     */
    protected  array|null $params;
    /**
     * array contain all variable you need translate it to view
     * @var array  $injection
     */
    public array $injection = [];

    /**
     * object from registration class
     * @var Registration
     */
    public Registration $registry;


    /**
     * contain language user en or ar
     * @var string
     */
    public string $lang;
    /**
     * to set name controller
     * @param string $controller the name controller
     * @return void
     */
    public function setController(string $controller): void
    {
        $this->controller = $controller;
    }
    /**
     * to set name action
     * @param string|null $action the name action
     * @return void
     */
    public function setAction(string|null  $action): void
    {
        $this->action = $action;
    }
    /**
     * to set name params
     * @param array $params the params
     * @return void
     */
    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    /**
     * set registry
     * @param Registration $registry
     * @return void
     */
    public function setRegistry(Registration $registry): void
    {
        $this->registry = $registry;
    }

    public function setLang(string $lang): void
    {
        $this->lang = $lang;
    }
    /**
     * get object from registry object
     * @param string $name name object
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->registry->$name;
    }
}