<?php
//namespace App\Core;
//
//
//class  AutoLoad
//{
//
//    /**
//     * @param $className
//     * @return void
//     */
//    public static function autoLoad($className): void
//    {
//        $nameClass = explode('\\', $className);
//
//
//        $className = str_replace("App", '', $className);
//
//
//
//        $className = explode('\\', $className);
//
//        $className = DS . strtolower($className[1]) . DS . $className[2] . ".php";
//
////        /core/Session.php
////         "/opt/lampp/htdocs/CoursesNewspaper/app/core/Session.php"
//
//        if (file_exists(APP_PATH . $className)) {
//            require APP_PATH . $className;
//
//        }
//    }
//}
//
//spl_autoload_register( __NAMESPACE__ . "\AutoLoad::autoLoad");
class AutoLoad
{
    private static array $config = [
        'App' => APP_PATH,
    ];

    /**
     * convert first character to lower case in directories
     * @param string $path path file
     * @return string
     */
    private static function loweCaseDirectoryName(string $path): string
    {
        $path = explode(DS, $path);
        $fileName = end($path);
        $newPath = '';
        for ($i = 0; $i < count($path) -1; $i++) {
            $path[$i] = lcfirst($path[$i]);
            $newPath .= $path[$i] . DS;
        }

        return $newPath . $fileName;
    }

    /**
     * @param string $className
     * @return void
     */
    public static function autoLoad(string $className): void
    {
        $className = ltrim($className, '\\');
        
        foreach (self::$config as $namespace => $baseDir) {

            $namespacePrefix = $namespace . '\\';


            if (str_starts_with($className, $namespacePrefix)) {
                $relativeClassName = substr($className, strlen($namespacePrefix));

                $filePath = str_replace('\\', DS, $relativeClassName) . '.php';
                $filePath = self::loweCaseDirectoryName($filePath);
                $fullPath = $baseDir . DS . $filePath;

                if (file_exists($fullPath)) {
                    require $fullPath;
                }
            }
        }
    }
}

spl_autoload_register('\AutoLoad::autoLoad');
