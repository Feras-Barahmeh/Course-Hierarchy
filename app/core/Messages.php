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
        $temp[] = [$messages, $this->setClassStyle($type)];

        Session::set("message", $temp);
        unset($temp);
    }

    public function getMessage()
    {
        if ($this->messagesExist()) {
            $messages = Session::get("message");
            Session::remove("message");
            return $messages;
        }
        return [];
    }
}