<?php

namespace App\Controllers;

use App\Core\Registration;
use App\Enums\MessagesType;
use App\Helper\HandsHelper;
use Generator;

abstract  class AbstractController
{
    use HandsHelper;
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

    /**
     * return the current controller
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * return action
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * return language
     * @return string
     */
    public function getLang(): string
    {
        return $this->lang;
    }
    /**
     * method to add errors forms to messages session
     * each message contain type
     * @param array $messages array contain all messages
     * @return void
     */
    public function addErrorsMethodToSession(array $messages): void
    {
        foreach ($messages as $message) {
            $this->messages->add($message, MessagesType::Danger);
        }
    }
    /**
     * Fill object or array (any iterator) in lazy way
     *
     * @param mixed $containerValues the element you want fill
     * @param Generator $records generator contains all data you want translate in $containerValues
     *
     * @return void
     */
    public function putLazy(mixed &$containerValues, Generator $records): void
    {
        while ($records->valid()) {
            $containerValues[] = $records->current();
            $records->next();
        }
    }
}