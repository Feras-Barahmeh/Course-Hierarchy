<?php

namespace App\Core;

use AllowDynamicProperties;
use ErrorException;

#[AllowDynamicProperties]
class View extends Template
{
    /**
     * name directory has the view file
     * @var string|mixed 
     */
    protected string $directory ;
    /**
     * name view file {name file }.view.php
     * @var string|mixed 
     */
    protected string $view;
    /**
     * controller object called this class 
     * @var object|null
     */
    protected ?object $controller;
    /**
     * array contain words language
     * @var array
     */
    private array $dictionary;
    /**
     * object contain all you need registration like message and language objects
     * @var object
     */
    private object $registry;
    /**
     * object message class
     * @var object
     */
    private object $messages;

    private array $params;
    public function __construct(private string|array $viewName, ?object $controller=null , private array $param=[])
    {

        $this->viewName = explode('.', $this->viewName);
        $this->directory = $this->viewName[0];
        $this->view = $this->viewName[1];
        $this->controller = $controller;
        $this->params = $this->param;
        $this->parseController($this->controller);

        unset($this->viewName);
        unset($this->controller);
        
    }

    /**
     * method to get
     * @param $controller
     * @return void
     */
    private function parseController($controller): void
    {

        if ($controller) {

            if (isset($controller->registry->language)) {
                $this->dictionary = $controller->registry->language->getDictionary();
            }

            if (isset($this->controller->registry)) {
                $this->registry = $controller->registry;
            }

            if (isset($this->controller->registry->messages)) {
                $this->messages = $this->controller->registry->messages;
            }

        }
    }

    /**
     * @throws ErrorException
     */
    public static function view(string $viewName, $controller=null, array $param = []): self
    {
        $instance = new static($viewName, $controller, $param);
        $instance->render();
        return $instance;
    }

    /**
     * @throws ErrorException
     */
    public function render(): void
    {

        $view = VIEWS_PATH . $this->directory . DS . $this->view . ".view.php";
        
        if (! file_exists($view)) {
            $view =  VIEWS_PATH ."NotFound" . DS . "controller.view.php";
        }

        Template::engin($view);

        if (isset($this->dictionary)) extract($this->dictionary);
        if (isset($this->param)) extract($this->params);
        require TEMPLATE_PATH . self::getNameFileFromPath($view, 2);
    }
}