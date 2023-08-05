<?php

namespace App\Controllers;

use App\Core\Session;
use App\Core\Validation;
use App\Enums\MessagesType;
use App\Enums\Privilege;
use App\Models\CollegeModel;
use App\Models\DepartmentModel;
use ErrorException;

class DepartmentsController extends AbstractController
{
    use Validation;
    public static int $authentication = Privilege::Admin->value;


    /**
     * patterns check forms when add
     * @var array|array[]
     */
    private array $rolesAdd = [
        "DepartmentName"         => ["required", "alpha", "between" => [4, 100]],
        "TotalStudents"       => ["numeric", "between" => [0, 65535]],
    ];

    /**
     * #[GET('/departments')]
     * @throws ErrorException
     */
    public function index(): void
    {

        $this->language->load("template.common");
        $this->language->load("departments.common");
        $this->language->load("departments.index");

        $departmentsRecords = null;
        if (isset($_POST["search"])) {

            $departmentsRecords = DepartmentModel::get(DepartmentModel::filterTable($_POST["value_search"]));
        } else if (isset($_POST["resit"])) {
            $records = DepartmentModel::getLazy(["order"]);
            $this->putLazy($departmentsRecords, $records);
        } else {
            $records = DepartmentModel::getLazy(["order"]);

            $this->putLazy($departmentsRecords, $records);
        }

        $this->authentication("departments.index", [
            "departments" => $departmentsRecords,
        ]);
    }

    /**
     * #[GET('/departments/add')]
     * @throws ErrorException
     */
    public function add(): void
    {

        $this->language->load("template.common");
        $this->language->load("departments.add");
        $this->language->load("departments.common");

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
                $department = new DepartmentModel();

                // Check College Name is unique
                $DepartmentName = $_POST["DepartmentName"];

                if (! $department->countRow("DepartmentName", $DepartmentName)) {
                    $department->DepartmentName = $_POST["DepartmentName"];
                    $department->TotalStudents = $_POST["TotalStudents"];
                    $department->CollegeID = $_POST["CollegeID"];

                    if ($department->save()) {
                        $this->setMessage("success", $department->DepartmentName, MessagesType::Success->name);
                        $this->redirect("/departments");
                    }  else {
                        $this->setMessage("fail", $department->DepartmentName, MessagesType::Danger->name);
                    }

                } else {
                    $this->setMessage("already_exits", $DepartmentName, MessagesType::Danger->name);
                }
            }
        }

        $this->authentication("departments.add", [
            "messages" => Session::flash("message"),
            "colleges" => $colleges,
        ]);
    }
}