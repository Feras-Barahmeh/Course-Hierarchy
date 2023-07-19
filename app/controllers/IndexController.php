<?php

namespace App\Controllers;

use App\Core\View;
use ErrorException;

class IndexController extends AbstractController
{
    /**
     * #[GET('/')]
     * @throws ErrorException
     */
    public function index(): void
    {
        $this->language->load("template.common");

        View::view("index.index", $this, [
            "lang" => $this->lang,
            "file_css" => "index",
            "file_js"   => "index",
        ]);
    }
}