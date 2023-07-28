<?php

namespace App\Core;

use App\Enums\MessagesType;

class Messages
{
    /**
     * unique instance for this class
     * @var
     */
    private static $_instance;

    /**
     * construct
     */
    private function __construct() {}
    private function __clone() {}

    public static function getInstance(): Messages
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * check if message exist in session
     * @return bool
     */
    private function messagesExist(): bool
    {
        return Session::has("message");
    }

    private function setClassStyle($number)
    {
        if ($number === MessagesType::Success->value)  return MessagesType::Success->name;
        if ($number === MessagesType::Danger->value)   return MessagesType::Danger->name;
        if ($number === MessagesType::Warning->value)  return MessagesType::Warning->name;
        if ($number === MessagesType::Info->value)    return MessagesType::Info->name;

    }
    public function add($messages, $type = MessagesType::Success->value): void
    {
        if (! $this->messagesExist()) {
            Session::set("message", []);
        }

        $temp = Session::get("message");
        $temp[] = [$messages, $type];

        Session::set("message", $temp);
        unset($temp);
    }

    /**
     * return all messages in session
     * @return array|null
     */
    public function getMessage(): array|null
    {
        if ($this->messagesExist()) {
            $messages = Session::get("message");
            Session::remove("message");
            return $messages;
        }
        return [];
    }

    /**
     * method to do dynamic message
     * example the message is 'my name is %' replace %s whit value
     * @param string $key name message
     * @param array|string $params array contain all parameter message(number %s values)
     * @param object|array $words dictionary words
     * @return mixed
     */
    public function feedKey (string $key, array|string $params, object|array $words): mixed
    {
        if (! is_array($params)) $params = [$params];
        array_unshift($params, $words[$key]);
        return call_user_func_array('sprintf', $params);
    }
}