<?php

namespace App\Controllers;

use App\Core\View;

class IndexController extends AbstractController
{
    public function index(): void
    {
        $this->language->load("template.common");

        View::view("index.index", $this);
    }
}