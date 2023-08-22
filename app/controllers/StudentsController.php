<?php

namespace App\Controllers;

use App\Core\FilterInput;
use App\Core\Validation;
use App\Enums\MessagesType;
use App\Enums\Privilege;
use App\Helper\Handel;
use App\Helper\HandsHelper;
use App\Models\CollegeModel;
use App\Models\DepartmentModel;
use App\Models\MajorModel;
use App\Models\OperationHandler;
use App\Models\StudentModel;
use ErrorException;
use JetBrains\PhpStorm\NoReturn;

class StudentsController extends AbstractController
{
    use Validation;
    use HandsHelper;
    use OperationHandler;
    public static int $authentication = Privilege::Admin->value;
    /**
     * patterns check forms when add
     * @var array|array[]
     */
    private array $rolesAdd = [
        "StudentYear"  => ["required", "alpha","max" => [10]],
        "FirstName"         => ["required", "max" => [50]],
        "LastName"         => ["required", "max" => [50]],
        "Password"         => ["required"],
        "Gender"         => ["required", "max" => [6]],
        "Email"         => ["required", "email", "between" => [LEN_TDL_STUDENT_EMAIL, 100]],
        "MajorID"         => ["required"],
    ];
    private array $rolesEdit = [
        "StudentYear"    => ["required", "alpha", "max" => [10]],
        "FirstName"             => ["required", "required", "max" => [50]],
        "LastName"              => ["required", "required", "max" => [50]],
        "MajorID"               => ["required"]
    ];
    /**
     * #[GET('/students')]
     * @throws ErrorException
     */
    public function index(): void
    {

        $this->language->load("template.common");
        $this->language->load("students.common");
        $this->language->load("students.index");

        $extensionQuery = [
            "Department" => [
                "on" => [
                    "StudentDepartmentID" => DepartmentModel::getPK()
                ],
            ],
            "Major" => [
              "on" => [
                  "StudentMajor" => MajorModel::getPK(),
              ]
            ],
            "College" => [
                "on" => [
                    "StudentCollegeID" => CollegeModel::getPK(),
                ]
            ],
        ];

        if (isset($_POST["search"])) {
            $extensionQuery["College"]["like"] = FilterInput::str($_POST["value_search"]);
        }
        $students = StudentModel::fetch(false, $extensionQuery);

        $this->authentication("students.index", [
            "students" => $students,
        ]);
    }

    /**
     * Validate student data from form submission.
     *
     * This method is used to validate student data submitted via a form. It performs multiple checks on the submitted data,
     * including checking for the existence of an email address in the database, validating the email address's top-level domain (TLD),
     * and checking if the password and confirmation password match.
     *
     * If any of the validation checks fail, the method sets appropriate error message details and sets the `$flag` variable to false,
     * indicating a validation failure.
     *
     * The method then returns the value of the `$flag` variable, which indicates whether the validation passed (true) or failed (false).
     *
     * @param StudentModel $student
     * @param string $keyMessage key message you want set for error
     * @param string|array $paramMessage if message has parameter
     * @return bool Returns true if the student data passes all validation checks, and false otherwise.
     */
    private function checkStudentErrors(StudentModel &$student,  string &$keyMessage, string|array &$paramMessage): bool
    {
        $flag = true;
        if (isset($_POST["Email"]) && $student::ifExist("Email", $_POST["Email"])) {
            $keyMessage = "already_exits";
            $paramMessage = $_POST["Email"];
            $flag =false;
        } elseif( isset($_POST["Email"]) && ! self::checkTDLEmail($_POST["Email"], TLD_STUDENT_EMAIL) ) {
            $keyMessage = "error_TDL_email";
            $paramMessage = TLD_STUDENT_EMAIL;
            $flag =false;
        } elseif(isset($_POST["ConfirmPassword"] ) && isset($_POST["Password"]) && $_POST["ConfirmPassword"] !== $_POST["Password"]) {
            $keyMessage = "error_not_match_password";
            $flag =false;
        }

        return $flag;
    }
    /**
     * #[GET('/students/add')]
     * @throws ErrorException
     */
    public function add(): void
    {
        $this->language->load("template.common");
        $this->language->load("students.common");
        $this->language->load("students.add");


        if (isset($_POST["add"])) {
            $errors = $this->valid($this->rolesAdd, $_POST);
            $flag = true;

            // If it forms Has Error
            if (is_array($errors)) {
                $this->addErrorsMethodToSession($errors);
                $flag = false;
            }

            if ($flag) {
                $student = new StudentModel();

                $keyMessage = '';
                $paramMessage = '';

                $flag = $this->checkStudentErrors($student, $keyMessage, $paramMessage);


                if ($flag) {
                    $this->setProperties($student, $_POST);
                    $student->Password = self::encryption($_POST["Password"]);
                    $student->Privilege = Privilege::Student->value;
                    $student->StudentMajor = FilterInput::int($_POST["MajorID"]);


                    $major = MajorModel::getByPK($student->StudentMajor);

                    $student->StudentDepartmentID = $major->MajorDepartmentID;
                    $student->StudentCollegeID = $major->MajorCollegeID;

                    self::increment(MajorModel::class, "NumberStudentInMajor", $student->StudentMajor);
                    self::increment(CollegeModel::class, "TotalStudentsInCollege", $major->MajorCollegeID);
                    self::increment(DepartmentModel::class, "TotalStudentsInDepartment", $major->MajorDepartmentID);

                    $this->saveAndHandleOutcome(
                        $student,
                        $student->FirstName . ' ' . $student->LastName,
                        "/students"
                    );

                } else {
                    $this->setMessage($keyMessage, $paramMessage, MessagesType::Danger);
                }

            }
        }

        $this->authentication("students.add", [
            "majors" => MajorModel::all(),
            "years"     => Handel::prepareAcademicYears(),
        ]);
    }

    /**
     * #[GET('/students/edit')]
     * @throws ErrorException
     */
    public function edit(): void
    {
        $this->language->load("template.common");
        $this->language->load("students.common");
        $this->language->load("students.edit");
        $student = StudentModel::getByPK($this->firstParam());

        if (! $student) {
            $this->redirect("/students");
        }
        if (isset($_POST["edit"])) {


            $errors = $this->valid($this->rolesEdit, $_POST);
            $flag = true;

            // If it forms Has Error
            if (is_array($errors)) {
                $this->addErrorsMethodToSession($errors);
                $flag = false;
            }

            if ($flag) {
                
                $this->setProperties($student, $_POST);
                $major = MajorModel::getByPK($student->StudentMajor);
                $student->StudentDepartmentID = $major->MajorDepartmentID;
                $student->StudentCollegeID = $major->MajorCollegeID;
                $this->saveAndHandleOutcome(
                    $student,
                    $student->FirstName . ' ' . $student->LastName ,
                    "/students"
                );
            }
        }

        $this->authentication("students.edit", [
            "student" => $student,
            "majors" => MajorModel::all(),
            "years"     => Handel::prepareAcademicYears(),
        ]);
    }
    #[NoReturn] public function delete(): void
    {
        $this->language->load("students.delete");

        $id = $this->getParams()[0];

        $student = StudentModel::getByPK($id);

        if (! $student) {
            $this->setMessage("not_exist", '', MessagesType::Danger);
        }

        $name = $student->FirstName . ' ' . $student->LastName;

        $idCollege = $student->StudentDepartmentID;
        $idMajor = $student->StudentMajor;

        $major = CollegeModel::row("SELECT * FROM " . MajorModel::getTableName() . " Where  " . MajorModel::getPK() . " = '{$idMajor}'");

        if ($student->delete()) {
            self::decrement(CollegeModel::class, "TotalStudentsInCollege", $idCollege);
            self::decrement(MajorModel::class, "NumberStudentInMajor", $idMajor);
            self::decrement(DepartmentModel::class, "TotalStudentsInDepartment", $major->MajorDepartmentID);

            $this->setMessage("success", $name, MessagesType::Success);
        } else {
            $this->setMessage("fail", $name, MessagesType::Danger);
        }

        $this->redirect("/students");
    }
}