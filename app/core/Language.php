<?php

namespace App\Core;

use http\Exception;
use JetBrains\PhpStorm\ExpectedValues;

class Language
{
    /**
     * name directory and file (leaf path)
     *
     * @var array|string
     */
    private array|string $nameLeaf;
    /**
     * array contain all words
     * @var array
     */
    private array $dictionary = [];
    /**
     * language user in this session
     * @var string
     */
    private string $language;

    private function setSessionLanguage(): void
    {
        if (Session::has("lang")|| Cookie::has("lang")) {
            $this->language = Session::get("lang");
        }
    }

    /**
     * set name directory and  file language 
     * @param array|string $nameLeaf name file  directory 
     * @return void
     */
    private function setPath(array|string $nameLeaf): void
    {
        $this->nameLeaf = $nameLeaf;
    }

    /**
     * to marge directory lang file language with path languages directory
     * @throws \Exception
     * @return string path file we want load
     */
    public function margeLeafWithPath(): string
    {
        if (! is_array($this->nameLeaf)) {
            return str_replace('.', DS, $this->nameLeaf) . ".lang.php";
        } else {
            if (count($this->nameLeaf ) > 2) {
                throw new \Exception("Expected name directory and name file");
            } else {
                return $this->nameLeaf[0] . DS . $this->nameLeaf;
            }

        }
    }

    /**
     * check if directory you want load is existed
     * @return bool
     * @throws \Exception
     */
    public function leafExist(): bool
    {
        $this->setPath(LANGUAGES_PATH . $this->language . DS . $this->margeLeafWithPath());
        return file_exists($this->nameLeaf);
    }

    /**
     * set words in dictionary
     * @param $content
     * @return void
     */
    private function setContent($content): void
    {
        foreach ($content as $key => $value) {
            $this->dictionary[$key] = $value;
        }
    }
    /**
     * load file language
     * @param array|string $target directory and file you want load
     * @return void
     * @throws \Exception
     */
    public function load(array|string $target): void
    {
        $this->setSessionLanguage();
        $this->setPath($target);

        if ($this->leafExist()) {
            require $this->nameLeaf;
            if (isset($_) && is_array($_))
                $this->setContent($_);
        } else {
            trigger_error("File Language Not Exist {$this->nameLeaf}", E_USER_WARNING);
        }
    }

    /**
     * get dictionary
     * @return array
     */
    public function getDictionary( ): array
    {
        return $this->dictionary;
    }

    /**
     * get current language
     * @return string
     */
    public function getLang(): string
    {
        return $this->language;
    }
}