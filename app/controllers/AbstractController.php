<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Registration;
use App\Core\Session;
use App\Core\View;
use App\Enums\Language;
use App\Enums\MessagesType;
use App\Helper\HandsHelper;
use App\Models\InstructorModel;
use ErrorException;
use Generator;
use App\Core\Cookie;

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
     * contain language user english or arabic
     * @var string
     */
    public string $lang;
    /**
     * Array of columns to be neglected in the context of setting InstructorModel properties.
     *
     * This public property holds an array of column names that should be neglected when set value columns in model object
     * property values of an InstructorModel instance using the `setInstructorColumnsValues` method.
     * The `setInstructorColumnsValues` method iterates through provided values for each column,
     * and if a column name matches any of the elements in this array, the value assignment for that
     * column is skipped.
     *
     * @var array
     */
    public static  array $neglectingColumns = ["edit", "add", "submit", "ConfirmPassword"];
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
     * to get parameters
     * @return array|null
     */
    public function getParams(): ?array
    {
        return $this->params ;
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

    public function setLang(): void
    {
        if (Cookie::get(LANGUAGE_NAME_COLUMNS_DB) == Language::English->value) {
            $this->lang = strtolower(Language::English->name);
        } elseif(Cookie::get(LANGUAGE_NAME_COLUMNS_DB) == Language::Arabic->value) {
            $this->lang = strtolower( Language::Arabic->name);
        }
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
     * Get Controller
     *
     * This method to get the current controller
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

    /**
     * Set a message and add it to the messages' container.
     *
     * This method allows setting a message by providing a message key, optional parameters,
     * and a message type. The message key is used to retrieve the actual message text from
     * the language feed. Optional parameters can be used to customize the message content.
     * The message type is used to categorize the message (e.g., success, error, warning, etc.).
     * The constructed message is then added to the messages container for further processing.
     *
     * @param string $key The message key to retrieve the message text from the language feed.
     * @param string|array|null $params Optional. Parameters to customize the message content.
     *                            It can be a single string or an array of strings.
     * @param string|object $type The message type. Can be one of 'success', 'info', 'warning', or 'danger'.
     *                     This determines the visual style and presentation of the message.
     *
     * @return void This method does not return any value.
     */
    public function setMessage(string $key, string|array|null $params, string|object $type): void
    {
        if ($params == null) $params = '';
        $message = $this->language->feedKey($key,  $params);
        $this->messages->add($message, $type);
    }

    /**
     * Handle authentication-related tasks and render views based on access privilege.
     *
     * This method is used to handle authentication-related tasks in the application. It checks the user's
     * access privilege using the `Auth` class, and based on the privilege level, it either renders the specified
     * view with optional migration information or redirects to an "access denied" page if the user does not have
     * the required privilege to access the specified view.
     *
     * @param string $view The name of the view to be rendered upon successful authentication.
     * @param array $migrationInfo Optional migration (to view) information to be passed to the view (default: []).
     * @return void
     * @throws ErrorException
     */
    public function authentication(string $view, array $migrationInfo=[]): void
    {
        if (Auth::performAuthenticatedAccessCheck(static::$authentication, Auth::privilege())) {
            View::view($view, $this, $migrationInfo);
        } else {
            $this->redirect("/auth/accessDenied");
        }
    }

    /**
     * Set properties of an InstructorModel object with new values.
     *
     * This private method is used to set the properties of an InstructorModel object with new values
     * provided in the $newValues array. The method iterates through the keys (columns) of the $newValues
     * array and assigns the corresponding values to the $instructor object. It ignores the properties
     * specified in the $neglectingColumns array, allowing only certain properties to be updated with new values.
     *
     * @param object $instructor An instance of the InstructorModel object to be updated.
     * @param array $newValues An associative array containing new property values to update the InstructorModel.
     *
     * @return void
     */
    public static  function setProperties(object &$instructor, array $newValues): void
    {
        $editColumns = array_keys($newValues);

        foreach ($editColumns as $column) {
            if (! in_array($column, self::$neglectingColumns)) {
                $instructor->{$column} = $newValues[$column];
            }
        }
    }

    public function saveRecord(&$instance, $messageParams, $redirectPath): void
    {
        if ($instance->save()) {
            $this->setMessage("success", $messageParams, MessagesType::Success->name);
            $this->redirect($redirectPath);
        }  else {
            $this->setMessage("fail", $messageParams, MessagesType::Danger->name);
        }
    }

}