<?php

namespace App\Core;

use ErrorException;
class Template
{
    /**
     * array contain all files frontend name
     * @var array
     */
    private array $pageResources;

    private static array $templateEngines = [
        "extend" => "@extend('dir.file')@",
    ];
    /**
     * Contractor
     * @param array $nameFilesFrontend name files css and js
     */
    public function __construct(array $nameFilesFrontend)
    {
        $this->pageResources = $nameFilesFrontend;
    }

    /**
     * to check if part isset in template parts
     * @param string $nameKey name part
     * @return bool
     */
    private function ifKeyTemplatePartExist(string $nameKey): bool
    {
        return array_key_exists($nameKey, $this->pageResources);
    }

    /**
     * to create link tag
     *
     */
    private function generateLinksTags()
    {
        if ($this->ifKeyTemplatePartExist(NAME_TEMPLATE_HEADER_RESOURCES)) {
            $resources = $this->pageResources[NAME_TEMPLATE_HEADER_RESOURCES];
            if(! empty($resources)) {
                $css = $resources["css"];
                $links = '';
                foreach ($css as $name => $path) {
                    $links .= "<link rel='stylesheet' href=". $path .">";
                }
                return $links;
            }
        }
        else {
            return trigger_error("Name Template Key Not Found ( " . NAME_TEMPLATE_HEADER_RESOURCES . ')', E_USER_WARNING);
        }
    }
    private function generateScriptsTags()
    {
        if ($this->ifKeyTemplatePartExist(NAME_TEMPLATE_FOOTER_RESOURCES)) {
            $resources = $this->pageResources[NAME_TEMPLATE_FOOTER_RESOURCES];

            if(! empty($resources)) {
                $css = $resources["js"];
                $links = '';
                foreach ($css as $name => $path) {
                    $links .= "<script src=' ". $path ." ' ></script>";
                }
                return $links;
            }
        }
        else {
            return trigger_error("Name Template Key Not Found ( " . NAME_TEMPLATE_HEADER_RESOURCES . ')', E_USER_WARNING);
        }
    }

    /**
     * get directory file by get path this file
     * @param string $path path file
     * @return string
     */
    public static function getDirectoryFile(string $path): string
    {
        $chunks = explode(DS, $path);
        array_pop($chunks);
        return end($chunks) ? end($chunks) : false;
    }
    /**
     * method to get name file from path this file
     * for example path = /app/views/index/index.view.php
     * return index.view.php
     * @param string $path path file
     * @param int $count Number of chunk need right to left
     * @return false|array|string name file
     */
    public static function getNameFileFromPath(string $path, int $count=1): false|array|string
    {
        $chunks = explode(DS, $path);
        if ($count == 1 ) return end($chunks);
        $ans =[];
        while ($count) {
            $ans[] = end($chunks);
            array_pop($chunks);
            $count--;
        }
        return implode(DS, array_reverse($ans));
    }

    /**
     * crete backup for view in templates
     *
     * @return string backup file
     */
    private static function backup($nameFile): string
    {
        $directory = self::getDirectoryFile($nameFile);
        $directory = TEMPLATE_PATH . $directory;
        $viewName = self::getNameFileFromPath($nameFile);
        $file = null;
        
        if (! is_dir($directory)) {
            if (mkdir($directory, 0777, true)) {
                $file = $directory . DS . $viewName;
                if (! file_exists($file)) {
                    fopen($file, 'w');
                }
            }
        } else {
            // If Directory is existed
            $file = $directory . DS . $viewName;
            if (! file_exists($file)) {
                fopen($file, 'w');
            }
        }

        file_put_contents($file, file_get_contents($nameFile));
        return $file;
    }
    /**
     * to get extend content
     * @throws ErrorException
     */
    private static function extend($viewPath): void
    {
        $viewPath = self::backup($viewPath);

        $pattern = "/@extend\('(.+?)'\)@/";
     
        $fileContent = file_get_contents($viewPath);
        
        if (preg_match_all($pattern, $fileContent, $matches)) {
            $counter = 0;
           foreach ($matches[1] as $match) {

               $tag = $matches[0][$counter];
               $counter++;

               $extend = $match;
               
               // read inherited file content
               $extend = explode('.', $extend);

               $dir = $extend[0];
               $file = $extend[1];
               $pathInherited = VIEWS_PATH .  $dir . DS . $file . ".php";
               
             
               if (! file_exists($pathInherited)) {
                   throw new ErrorException("File inherited not founded");
               }

               $replacement = file_get_contents($pathInherited);
               $fileContent = file_get_contents($viewPath);
             
               $modifiedContent = str_replace($tag, $replacement, $fileContent);

               if ($modifiedContent) {
                   file_put_contents($viewPath, $modifiedContent);
               } else {
                   echo "error";
               }
           }

        }
    }

    /**
     * to set links in header
     * @return void
     */
    public static function links()
    {

    }
    /**
     * @throws ErrorException
     */
    private static function replaceContent($view): void
    {
        self::extend($view);
        self::links();
    }

    /**
     * @param string $view view you want engin
     * @return void
     * @throws ErrorException
     */
    public static function engin(string $view): void
    {
        self::replaceContent($view);

    }
}