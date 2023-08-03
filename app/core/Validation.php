<?php

namespace App\Core;

/**
 * Validation Trait
 * The Validation trait is a PHP trait that provides a set of validation methods for various types of data.
 * It is designed to be used within a class that handles form validation or data validation in general.
 * The trait defines several methods for validating different types of data and handling validation errors.
 *
 * Constrains
 * 1) name in Post Number by like key in patterns array
 */
trait Validation
{
    /**
     * array container all dictionary
     * @var array
     */
    private array $words = [];
    /**
     * array contain key error message
     * @var array
     */
    private array $errors = [];
    /**
     * array contain patterns and name pattern
     * @var array|string[]
     */
    private array $patterns = [
        'int'           => "/^[-+]?\d+$/",
        'float'         => "/^[-+]?\d+(\.\d+)?$/",
        'positive'      => "/^[+]?\d+(\.\d+)?$/",
        'numeric'      => "/^[0-9]+$/",
        'alpha'         => "/^[\p{L} ]+$/u",
        'alphaNum'      => '/^[\p{L}0-9 ]+$/u',
        'date'         => "/^\d{4}-\d{2}-\d{2}$/",
        'email'         => "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/",
        'url'           => "/^(https?:\/\/)?([\da-z.-]+)\.([a-z.]{2,6})([\/\w .-]*)*\/?$/",
    ];

    /**
     * push message error to error array
     * @param string $key key message threaded with error
     * @param array|string $values params this message
     * @return void
     */
    private function pushToError(string $key, array|string $values): void
    {
        if (! is_array($values)) $values = [$values];
        $this->errors[] = $this->messages->feedKey($key, $values, $this->words);
    }

    /**
     * check if value empty or not
     * @param mixed $value the value you want check
     * @param string $nameField name column you want set in message
     * @return bool
     */
    public function required(mixed $value, string $nameField): bool
    {
        if ('' != $value || !empty($value)) {
            return  true;
        }

        $this->pushToError("error_required", [$nameField]);
        return false;
    }

    /**
     * not required value
     * @return bool
     */
    public function notRequired(): bool
    {
        return true;
    }

    /**
     * check if number
     * @param mixed $value
     * @param string $nameField  name column you want set in message
     * @return bool
     */
    public function num(mixed $value, string $nameField): bool
    {
        if (preg_match($this->patterns['num'], $value)) {
            return true;
        }
        $this->pushToError("error_num", [$nameField]);
        return  false;
    }

    /**
     * check if integer
     * @param $value
     * @param string $nameField name column you want set in message
     * @return bool
     */
    public function int($value, string $nameField): bool
    {
        if(preg_match($this->patterns['int'], $value)) return true;

        $this->pushToError("error_num", [$nameField]);
        return false;
    }
    /**
     * check if float
     * @param $value
     * @param string $nameField name column you want set in message
     * @return bool
     */
    public function float($value, string $nameField): bool
    {
        if (preg_match($this->patterns['float'], $value)) return true;

        $this->pushToError("error_float", [$nameField]);
        return false;
    }
    /**
     * if contain alpha just
     * @param $value
     * @param string $nameField name column you want set in message
     * @return bool
     */
    public function alpha($value, string $nameField): bool
    {
        if (preg_match($this->patterns['alpha'], $value)) return true;
        $this->pushToError("error_alpha", [$nameField]);
        return false;
    }

    /**
     * if contain alpha numbers
     * @param $value
     * @param string $nameField name column you want set in message
     * @return bool
     */
    public function alphaNum($value, string $nameField): bool
    {
        if (preg_match($this->patterns['alphaNum'], $value)) return true;

        $this->pushToError("error_alphaNum", [$nameField]);
        return false;
    }

    /**
     * if numeric or not
     * @param $value
     * @param string $nameField name column you want set in message
     * @return bool
     */
    public function numeric($value, string $nameField): bool
    {
        if (preg_match($this->patterns['numeric'], $value)) return true;

        $this->pushToError("error_numeric", [$nameField]);
        return false;
    }

    /**
     * if contain positive integer
     * @param $value
     * @param string $nameField name column you want set in message
     * @return bool
     */
    public function posInt($value, string $nameField): bool
    {

        if ($value >= 0 && is_numeric($value)) return true;
        $this->pushToError("error_posInt", [$nameField]);
        return false;
    }
    /**
     * check if value between specific value
     * @param mixed $value the value you want check
     * @param string $nameField  name column you want set in message
     * @param mixed $params min and max value
     * @return bool
     */
    public function between(mixed $value, string $nameField, mixed $params): bool
    {
        $min = $params[0];
        $max = $params[1];

        $flag = false;

        if (is_string($value)) {
            $length = mb_strlen($value);
            $flag = $length >= $min && $length <= $max;
        } elseif (is_numeric($value)) {
            $flag = $value >= $min && $value <= $max;
        }

        if (! $flag) {
            $this->pushToError("error_between", [$nameField, $min, $max]);
            return false;
        }
        
        return true;
    }

    /**
     * check if value has an email structure
     * @param mixed $value the value you want check
     * @return bool
     */
    public function email(string $value): bool
    {
        return preg_match($this->patterns["email"], $value);
    }
    /**
     * check if value has a date structure
     * @param mixed $value the value you want check
     * @return bool
     */
    public function date(string $value): bool
    {
        return preg_match($this->patterns["date"], $value);
    }
    /**
     * method to call method has tow argument
     * @param string $nameMethod name method you want called
     * @param mixed $value value you want check
     * @param string $nameField input filed name
     * @return mixed
     */
    private function callMethodContainOneParam(string $nameMethod, mixed $value, string $nameField): mixed
    {
        return $this->$nameMethod($value, $nameField);
    }

    /**
     * method to call method with many parameter
     * @param string $nameMethod name method you want call
     * @param mixed $value value you want check
     * @param string $nameField  input filed name
     * @param mixed ...$params parameter called method needed
     * @return mixed
     */
    private function callMethodWithParam(string $nameMethod, mixed $value, string $nameField, ...$params): mixed
    {
        return call_user_func_array([$this, $nameMethod], array_merge([$value, $nameField], $params));
    }

    /**
     *
     * @param $patterns
     * @param $post
     * @return bool|array
     */
    public function valid($patterns, $post): bool|array
    {
        $this->language->load("template.errors");
        $this->words = $this->language->getDictionary();

        // the value I want check it
        foreach ($patterns as $value => $methods ) {

            // If method is index this mean the pattern container one param (is param not array)
            foreach ($methods as $method => $param) {

                // TODO: Edit Check another values (until if field not required)
                if (in_array("required", array_values($methods))) {
                    $nameField = $this->convertCamelToSpace($value);
                    if (! is_array($param)) {
                        $this->callMethodContainOneParam($param, $post[$value], $nameField);
                    } else {
                        $this->callMethodWithParam($method, $post[$value], $nameField, $param);
                    }
                }
            }
        }

        if (empty($this->errors)) return true;
        return $this->errors;
    }
}