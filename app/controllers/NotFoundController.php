<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\View;
use ErrorException;

class NotFoundController extends AbstractController
{
    /**
     * [GET]  http://newspaper.local/NotFound/controller.view.php
     * @return void
     * @throws ErrorException
     */
    public function controllerNotFount(): void
    {
        $this->language->load("notfound.controller");
        View::view("NotFound.controller", $this, ["file_css" => "notfound", "file_js" => "notfound"]);
    }

    /**
     * [GET]  http://newspaper.local/NotFound/action.view.php
     * @return void
     * @throws ErrorException
     */
    public function actionNotFound(): void
    {
        $this->language->load("notfound.action");
        View::view("NotFound.action", $this, ["file_css" => "notfound", "file_js" => "notfound"]);
    }
}