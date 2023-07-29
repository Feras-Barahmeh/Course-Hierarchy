<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\View;
use App\Enums\Privilege;
use App\Models\StudentModel;
use ErrorException;

class IndexController extends AbstractController
{

    public static int $authentication = Privilege::Admin->value;
    /**
     * #[GET('/')]
     * @throws ErrorException
     */
    public function index(): void
    {

        $this->language->load("template.common");


        $this->authentication("index.index");
    }
}