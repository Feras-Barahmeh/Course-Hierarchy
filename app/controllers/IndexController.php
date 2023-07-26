<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\StudentModel;
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
            "students" =>StudentModel::all(),
        ]);
    }
}