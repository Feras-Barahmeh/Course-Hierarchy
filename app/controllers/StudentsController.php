<?php

namespace App\Controllers;

use App\Core\Validation;
use App\Enums\MessagesType;
use App\Enums\Privilege;
use App\Models\CollegeModel;
use App\Models\StudentModel;
use ErrorException;

class StudentsController extends AbstractController
{
    use Validation;
    public static int $authentication = Privilege::Admin->value;
    /**
     * patterns check forms when add
     * @var array|array[]
     */
    private array $rolesAdd = [
        "NumberHoursSuccess"  => ["required", "numeric", "max" => [165]],
        "FirstName"         => ["required", "max" => [50]],
        "LastName"         => ["required", "max" => [50]],
        "Password"         => ["required"],
        "Gender"         => ["required", "max" => [6]],
        "Email"         => ["required", "email", "max" => [100]],
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

        $records = null;
        if (isset($_POST["search"])) {
            $records = StudentModel::fetch(false, ["College" => [
                "on" => ["StudentCollegeID" => CollegeModel::getPK()],
                "like" => $_POST["value_search"],
            ]] );


        } else if (isset($_POST["resit"])) {
            $records = StudentModel::fetch(false, ["College" => ["on" => ["StudentCollegeID" => CollegeModel::getPK()] ]] );
        } else {
            $records = StudentModel::fetch(false, ["College" => ["on" => ["StudentCollegeID" => CollegeModel::getPK()] ]] );
        }

        $this->authentication("students.index", [
            "students" => $records,
        ]);
    }
    /**
     * Save a StudentModel object and handle success or failure.
     *
     * This private method is used to save a StudentModel object and handle the outcome. The method takes a single parameter,
     * `$student`, which is a reference to the StudentModel object to be saved.
     *
     * The method attempts to save the `$student` object. If the save operation is successful, a success message is set
     * using the `setMessage()` method, indicating the successful operation along with the student's college name. The
     * method then redirects the user to the "/students" page.
     *
     * If the save operation fails, a failure message is set using the `setMessage()` method, indicating the failure
     * along with the student's college name.
     *
     * @param StudentModel $student A reference to the StudentModel object to be saved.
     *
     * @return void
     */
    private function saveStudent(StudentModel &$student): void
    {
        if ($student->save()) {
            $this->setMessage("success", $student->FirstName . ' ' . $student->LastName  , MessagesType::Success);
            $this->redirect("/students");
        }  else {
            $this->setMessage("fail", $student->FirstName . ' ' . $student->LastName, MessagesType::Danger);
        }
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

        $colleges = CollegeModel::all();

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
                if ($_POST["Password"] !== $_POST["ConfirmPassword"]) {
                    $this->setMessage("error_not_match_password", '', MessagesType::Danger);
                }

                if (! $student->countRow("Email", $_POST["Email"])) {
                    $this->setProperties($student, $_POST);
                    $student->Privilege = Privilege::Student->value;
                    $this->saveStudent($student);

                } else {
                    $this->setMessage("already_exits", $_POST["Email"], MessagesType::Danger);
                }


            }
        }


        $this->authentication("students.add", [
            "colleges" => $colleges,
        ]);
    }
}