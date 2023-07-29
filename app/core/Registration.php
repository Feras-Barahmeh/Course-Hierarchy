<?php

namespace App\Core;

class Registration
{
    /**
     * unique instance for this class
     * @var
     */
    private static $_instance;

    private function __construct() {}

    private function __clone() {}

    public static function getInstance(): Registration
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    /**
     * add new property
     * @param string $name name property
     * @param mixed $value value property
     * @return void
     */
    public function __set( string $name, mixed $value): void
    {
        $this->$name = $value;
    }

    /**
     * get value property by name
     * @param string $name name property
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->$name;
    }
}