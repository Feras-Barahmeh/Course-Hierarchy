<?php
namespace App\Core;


class  AutoLoad
{
    
    /**
     * @param $className
     * @return void
     */
    public static function autoLoad($className): void
    {
        $nameClass = explode('\\', $className);


        $className = str_replace("App", '', $className);

        // $className = "\Core\Engine"
        $className = explode('\\', $className);

        $className = DS . strtolower($className[1]) . DS . $className[2] . ".php";


        if (file_exists(APP_PATH . $className)) {
            require APP_PATH . $className;
        }
    }
}

spl_autoload_register( __NAMESPACE__ . "\AutoLoad::autoLoad");