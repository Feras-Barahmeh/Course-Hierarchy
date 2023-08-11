<?php

namespace App\Controllers;

use App\Core\FilterInput;
use App\Core\Validation;
use App\Enums\MessagesType;
use App\Enums\Privilege;
use App\Models\CollegeModel;
use App\Models\DepartmentModel;
use App\Models\StudentModel;
use ErrorException;
use JetBrains\PhpStorm\NoReturn;

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
        "CollegeID"       => ["required", "numeric"],
    ];
    private array $rolesEdit = [
        "DepartmentName"         => ["required", "alpha", "between" => [4, 100]],
        "TotalStudents"       => ["numeric", "between" => [0, 65535]],
        "CollegeID"       => ["required", "numeric"],
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

        $extensionQuery = [
            "College" => [
                "on" => [
                    "CollegeID" => CollegeModel::getPK()
                ],
            ]
        ];

        if (isset($_POST["search"])) {
            $extensionQuery["College"]["like"] = FilterInput::str($_POST["value_search"]);
        }

        $departments = DepartmentModel::fetch(false, $extensionQuery);

        $this->authentication("departments.index", [
            "departments" => $departments,
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

                if (! $department->ifExist("DepartmentName", $DepartmentName)) {

                    self::setProperties($department, $_POST);

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
            "colleges" => $colleges,
        ]);
    }


    /**
     * #[GET('/departments/edit')]
     * @throws ErrorException
     */
    public function edit(): void
    {
        $this->language->load("template.common");
        $this->language->load("departments.common");
        $this->language->load("departments.edit");

        if (isset($this->params[0]) && DepartmentModel::ifExist(DepartmentModel::getPK(),$this->params[0])) {
            $pk = $this->params[0];
        } else {
            $this->redirect("/departments");
        }

        $department = DepartmentModel::getByPK($pk);
        $colleges = CollegeModel::all();

        if (isset($_POST["edit"])) {

            $errors = $this->valid($this->rolesEdit, $_POST);
            $flag = true;

            // If it forms Has Error
            if (is_array($errors)) {
                $this->addErrorsMethodToSession($errors);
                $flag = false;
            }

            if ($flag) {
                self::setProperties($department, $_POST);

                $this->saveRecord($department, $department->DepartmentName, "/departments");
           }
        }


        $this->authentication("departments.edit", [
            "department" => $department,
            "colleges" => $colleges,
        ]);
    }
    #[NoReturn] public function delete(): void
    {
        $this->language->load("departments.delete");

        $id = $this->getParams()[0];
        FilterInput::int($id);

        $department = DepartmentModel::getByPK($id);

        if (! $department) {
            $this->setMessage("not_exist", '', MessagesType::Danger->name);
        }

        $name = $department->DepartmentName;

        if ($department->delete()) {
            $this->setMessage("success", $name, MessagesType::Success->name);
        } else {
            $this->setMessage("fail", $name, MessagesType::Danger->name);
        }

        $this->redirect("/departments");
    }
}