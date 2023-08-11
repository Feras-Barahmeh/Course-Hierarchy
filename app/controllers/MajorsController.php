<?php

namespace App\Controllers;

use App\Core\FilterInput;
use App\Core\Validation;
use App\Enums\MessagesType;
use App\Enums\Privilege;
use App\Models\CollegeModel;
use App\Models\DepartmentModel;
use App\Models\MajorModel;
use ErrorException;
use JetBrains\PhpStorm\NoReturn;

class MajorsController extends AbstractController
{
    use Validation;

    public static int $authentication = Privilege::Admin->value;
    private array $rolesAdd = [
        "NumberHoursMajor"      => ["required", "posInt", "between" => [130, 257]],
        "CoursesNumber"         => ["required", "int", "posInt","between" => [40, 85]],
        "MajorName"             => ["required", "alpha", "max" => [100]],
        "MajorDepartmentID"     => ["required", "posInt", "numeric"],
    ];
    private array $rolesEdit = [
        "NumberHoursMajor"      => ["required", "posInt", "between" => [130, 257]],
        "CoursesNumber"         => ["required", "int", "posInt", "between" => [40, 85]],
        "MajorName"             => ["required", "alpha", "max" => [100]],
        "MajorDepartmentID"     => ["required", "posInt", "numeric"],
    ];

    /**
     * #[GET('/majors')]
     * @throws ErrorException
     */
    public function index(): void
    {

        $this->language->load("template.common");
        $this->language->load("majors.common");
        $this->language->load("majors.index");

        $extensionQuery = [
            "Department" => [
                "on" => [
                    "MajorDepartmentID" => DepartmentModel::getPK(),
                ],
            ],
            "College" => [
                "on" => [
                    "MajorCollegeID" => CollegeModel::getPK(),
                ],
            ],
        ];

        if (isset($_POST["search"])) {
            $extensionQuery["Department"]["like"] = FilterInput::str($_POST["value_search"]);
        }

        $majors = MajorModel::fetch(false, $extensionQuery);

        $this->authentication("majors.index", [
            "majors" => $majors,
        ]);
    }

    /**
     * Save MajorModel instance in DB
     *
     * @param MajorModel $major a reference instance to be saved
     * @return void
 e     */
    private function saveMajor(MajorModel &$major): void
    {
        if ($major->save()) {
            $this->setMessage(
                "success",
                $major->MajorName,
                MessagesType::Success);

            $this->redirect("/majors");
        } else {
            $this->setMessage(
                "fail",
                $major->MajorName,
                MessagesType::Danger);
        }
    }

    /**
     * #[GET('/majors/add')]
     * @throws ErrorException
     */
    public function add(): void
    {

        $this->language->load("template.common");
        $this->language->load("majors.common");
        $this->language->load("majors.add");


        if (isset($_POST["add"])) {
            $errors = $this->valid($this->rolesAdd, $_POST);
            $flag = true;

            // If it forms Has Error
            if (is_array($errors)) {
                $this->addErrorsMethodToSession($errors);
                $flag = false;
            }

            if ($flag) {
                $majorName = FilterInput::str($_POST["MajorName"]);
                if (! MajorModel::ifExist("MajorName", $majorName)) {
                    $major = new MajorModel();
                    self::setProperties($major, $_POST);
                    $college = DepartmentModel::row("Select CollegeID FROM Departments Where DepartmentID = {$_POST['MajorDepartmentID']}" )->CollegeID;
                    $major->MajorCollegeID = $college;
                    $this->saveMajor($major);

                } else {
                    $this->setMessage("exist", $majorName, MessagesType::Danger);
                }
            }


        }

        $this->authentication("majors.add", [
            "departments" => DepartmentModel::all(),
        ]);
    }

    /**
     * Edit major
     * @throws ErrorException
     */
    public function edit(): void
    {

        $this->language->load("template.common");
        $this->language->load("template.errors");
        $this->language->load("majors.common");
        $this->language->load("majors.edit");

        $major = MajorModel::getByPK($this->params[0]);

        if(! $major) $this->redirect("/majors");


        if (isset($_POST["edit"])) {
            $errors = $this->valid($this->rolesEdit, $_POST);
            $flag = true;

            // If it forms Has Error
            if (is_array($errors)) {
                $this->addErrorsMethodToSession($errors);
                $flag = false;
            }

            if ($flag) {
                $this->setProperties($major, $_POST);
                $this->saveMajor($major);
            }
        }


        $this->authentication("majors.edit", [
            "departments" => DepartmentModel::all(),
            "major" => $major,
        ]);
    }


    #[NoReturn] public function delete(): void
    {
        $this->language->load("majors.delete");

        $id = $this->getParams()[0];
        FilterInput::int($id);

        $major = MajorModel::getByPK($id);

        if (! $major) {
            $this->setMessage("not_exist", '', MessagesType::Danger);
            $this->redirect("/majors");
        }

        $name = $major->MajorName;

        if ($major->delete()) {
            $this->setMessage("success", $name, MessagesType::Success);
        } else {
            $this->setMessage("fail", $name, MessagesType::Danger);
        }

        $this->redirect("/majors");
    }
}