<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Validation;
use App\Enums\Privilege;
use App\Helper\HandsHelper;
use App\Models\MajorModel;
use App\Models\Model;
use App\Models\StudentModel;
use ErrorException;
use const http\Client\Curl\AUTH_ANY;

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

        $user = Model::execute("SELECT * FROM " . StudentModel::getTableName() . " JOIN " .
            " Majors ON StudentMajor = " . MajorModel::getPK() .
            " WHERE StudentID = " . Auth::user()->StudentID
        ,\PDO::FETCH_CLASS)[0];

        $this->authentication("student.index", [
            "user" => $user,
        ]);
    }
}