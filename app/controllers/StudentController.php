<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Validation;
use App\Enums\Privilege;
use App\Helper\HandsHelper;
use ErrorException;

class StudentController extends AbstractController
{
    use Validation;
    use HandsHelper;
    public static int $authentication = Privilege::Student->value;

    /**
     * GET('/student')
     * @throws ErrorException
     */
    public function index(): void
    {
        $this->language->load("template.common");

        $this->authentication("student.index", [
            "user" => Auth::user(),
        ]);
    }
}