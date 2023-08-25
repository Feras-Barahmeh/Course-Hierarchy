<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Enums\Privilege;
use App\Models\CourseModel;
use App\Models\DepartmentModel;
use App\Models\InstructorModel;
use App\Models\MajorModel;
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
        $this->language->load("index.index");


        $this->authentication("index.index", [
            "user" => Auth::user(),
            "numberStudents" => StudentModel::count(),
            "numberInstructors" => InstructorModel::count(),
            "numberDepartments" => DepartmentModel::count(),
            "numberCourses" => CourseModel::count(),
            "numberMajors" => MajorModel::count(),

        ]);
    }
}