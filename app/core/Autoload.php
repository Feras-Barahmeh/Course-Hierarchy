<?php

class AutoLoad
{
    private static array $config = [
        'App' => APP_PATH,
        'App\Helper' => APP_PATH . DS . "helpers",
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
