<?php

namespace App\Controllers;

use App\Core\Cookie;
use App\Core\FilterInput;
use App\Core\Session;
use App\Core\Validation;
use App\Enums\AcademicYear;
use App\Enums\AcademicYearArabic;
use App\Enums\Language;
use App\Enums\MessagesType;
use App\Enums\Privilege;
use App\Models\CourseModel;
use App\Models\DepartmentModel;
use App\Models\MajorModel;
use ErrorException;
use JetBrains\PhpStorm\NoReturn;
use ReflectionException;

class CoursesController extends AbstractController
{
    use Validation;

    public static int $authentication = Privilege::Admin->value;
    private array $rolesAdd = [
        "CourseName"    => ["required", "max" => [50]],
        "CourseMajorID" => ["required", "posInt", "pos", "numeric"],
    ];
    private array $rolesEdit = [
        "CourseName"    => ["required", "max" => [50]],
        "CourseMajorID" => ["required", "posInt", "pos", "numeric"],
    ];

    /**
     * #[GET('/courses')]
     * @throws ErrorException
     */
    public function index(): void
    {

        $this->language->load("template.common");
        $this->language->load("courses.common");
        $this->language->load("courses.index");

        $extensionQuery = [
            "Major" => [
                "on" => [
                    "CourseMajorID" => MajorModel::getPK(),
                ],
            ],
        ];

        if (isset($_POST["search"])) {
            $extensionQuery["Major"]["like"] = FilterInput::str($_POST["value_search"]);
        }

        $courses = CourseModel::fetch(false, $extensionQuery);

        $this->authentication("courses.index", [
            "courses" => $courses,
        ]);
    }

    /**
     * @throws ReflectionException
     */
    private function checkErrorCourse(&$keyMessage, &$paramMessage): bool
    {
        $flag = true;
        $name = $_POST["CourseName"];
        FilterInput::str($name);
        $name = trim($name);
        $ifExist = CourseModel::ifExist("CourseName", $name);
        if (isset($_POST["CourseName"]) && $ifExist && $name != $ifExist[0]->CourseName) {
            $keyMessage = "course_exist";
            $paramMessage = $name;
            $flag = false;
        } elseif (isset($_POST["Year"])) {
            $year = FilterInput::str($_POST["Year"]);
            if (! in_array($year, self::getPropertyEnum(AcademicYear::class))) {
                $keyMessage = "year_not_exist";
                $flag = false;
            }
        }
        return $flag;
    }

    /**
     * Method to prepare academic years depend language
     *
     * @return array associative array key name value in database the value year for user
     * @throws ReflectionException
     */
    private static function prepareAcademicYears(): array
    {
        $years = CourseModel::getEnumColumns("Year");
        $new = [];
        $language = Cookie::get("language") ?? Session::get("language");

        if ($language == Language::English->value) {
            foreach ($years as $year) {
                $new[$year] = self::convertCamelToSpace($year);
            }
        } else {
            $yearsAr = self::getPropertyEnum(AcademicYearArabic::class);
            
            for ($i = 0; $i < count($years); $i++) {
                $new[$years[$i]] = $yearsAr[$i];
            }
        }
        return $new;
    }
    /**
     * GET('/courses/add')
     * @throws ErrorException|ReflectionException
     */
    public function add(): void
    {
        $this->language->load("template.common");
        $this->language->load("courses.common");
        $this->language->load("courses.add");


        if (isset($_POST["add"])) {
            $errors = $this->valid($this->rolesAdd, $_POST);
            $flag = true;

            // If it forms has error
            if (is_array($errors)) {
                $this->addErrorsMethodToSession($errors);
                $flag = false;
            }

            $keyMessage = '';
            $paramMessage = '';
            $flag = $this->checkErrorCourse($keyMessage, $paramMessage);

            if ($flag) {
                $course = new CourseModel();
                self::setProperties($course, $_POST);
                $this->saveAndHandleOutcome($course, $course->CourseName, "/courses");

            } else {
                $this->setMessage("$keyMessage", "$paramMessage", MessagesType::Danger);
            }
            
        }
        $extensionQuery = [
            "Major" => [
                "on" => [
                    "CourseMajorID" => MajorModel::getPK(),
                ],
            ],
        ];

        $course = CourseModel::fetch(false, $extensionQuery);


        $this->authentication("courses.add", [
            "majors"    => MajorModel::all(),
            "courses"   => $course,
            "years"     =>self::prepareAcademicYears(),
        ]);
    }

    /**
     * Edit major
     * @throws ErrorException
     * @throws ReflectionException
     */
    public function edit(): void
    {

        $this->language->load("template.common");
        $this->language->load("template.errors");
        $this->language->load("courses.common");
        $this->language->load("courses.edit");

        $id = $this->params[0];
        $id = FilterInput::int($id);
        $course = CourseModel::getByPK($id);

        if(! $course) $this->redirect("/courses");


        if (isset($_POST["edit"])) {
            $errors = $this->valid($this->rolesEdit, $_POST);
            $flag = true;
            
            // If it forms has error
            if (is_array($errors)) {
                $this->addErrorsMethodToSession($errors);
                $flag = false;
            }

            $keyMessage = '';
            $paramMessage = '';
            $flag = $this->checkErrorCourse($keyMessage, $paramMessage);

            if ($flag) {
                $this->setProperties($course, $_POST);
                $this->saveAndHandleOutcome($course, $course->CourseName, '/courses');
            }
        }


        $this->authentication("courses.edit", [
            "years"     =>self::prepareAcademicYears(),
            "course" => $course,
            "majors"    => MajorModel::all(),
        ]);
    }


    #[NoReturn] public function delete(): void
    {
        $this->language->load("courses.delete");

        $id = $this->firstParam();

        $course = CourseModel::getByPK($id);

        if (! $course) {
            $this->setMessage("not_exist", '', MessagesType::Danger);
            $this->redirect("/courses");
        }

        if ($course->delete()) {
            $this->setMessage("success", $course->CourseName, MessagesType::Success);
        } else {
            $this->setMessage("fail", $course->CourseName, MessagesType::Danger);
        }

        unset($course);
        $this->redirect("/courses");
    }
}