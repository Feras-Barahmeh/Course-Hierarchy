<?php

namespace App\Controllers;

use App\Core\View;

class NotFoundController extends AbstractController
{
    /**
     * [GET]  http://newspaper.local/NotFound/controller.view.php
     * @return void
     */
    public function controllerNotFount(): void
    {
        View::view("NotFound.controller");
    }
    /**
     * [GET]  http://newspaper.local/NotFound/action.view.php
     * @return void
     */
    public function actionNotFound(): void
    {
        View::view("NotFound.action");
    }
}