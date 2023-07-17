<?php

namespace App\Core;

class Template
{
    /**
     * array contain all files frontend name
     * @var array
     */
    private array $pageResources;

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

}