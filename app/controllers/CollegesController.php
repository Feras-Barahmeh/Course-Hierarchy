<?php

namespace App\Controllers;

use App\Core\Session;
use App\Core\Validation;
use App\Enums\MessagesType;
use App\Enums\Privilege;
use App\Models\CollegeModel;
use App\Models\StudentModel;
use ErrorException;
use JetBrains\PhpStorm\NoReturn;

class CollegesController extends AbstractController
{
    public static int $authentication = Privilege::Admin->value;
    use Validation;
    /**
     * patterns check forms when add
     * @var array|array[]
     */
    private array $rolesAdd = [
        "CollegeName"         => ["required", "alpha", "between" => [4, 100]],
        "TotalStudents"       => ["numeric", "between" => [0, 65535]],
    ];
    /**
     * patterns check forms when edit
     * @var array|array[]
     */
    private array $rolesEdit = [
        "CollegeName"         => ["required", "alpha", "between" => [4, 100]],
        "TotalStudents"       => ["numeric", "between" => [0, 65535]],
    ];
    /**
     * #[GET('/colleges')]
     * @throws ErrorException
     */
    public function index(): void
    {
        $this->language->load("template.common");
        $this->language->load("colleges.common");
        $this->language->load("colleges.index");

        $records = null;
        if (isset($_POST["search"])) {
            $table = CollegeModel::getTableName();
            self::removeLastChar($table);
            $records = CollegeModel::fetch(true,  ["like" => $_POST["value_search"]]);

        } else if (isset($_POST["resit"])) {
            $records = CollegeModel::fetch();
        } else {
            $records = CollegeModel::fetch();
        }

        $this->authentication("colleges.index", [
            "colleges" => $records,
        ]);
    }

    private function saveCollege($college): void
    {
        if ($college->save()) {
            $this->setMessage("success", $college->CollegeName, MessagesType::Success);
            $this->redirect("/colleges");
        }  else {
            $this->setMessage("fail", $college->CollegeName, MessagesType::Danger);
        }
    }
    /**
     * #[GET('/colleges/add')]
     * @throws ErrorException
     */
    public function add(): void
    {
        $this->language->load("template.common");
        $this->language->load("colleges.add");
        $this->language->load("colleges.common");


        if (isset($_POST["add"])) {
            $errors = $this->valid($this->rolesAdd, $_POST);
            $flag = true;


            // If it forms Has Error
            if (is_array($errors)) {
                $this->addErrorsMethodToSession($errors);
                $flag = false;
            }

            if ($flag) {
                $college = new CollegeModel();

                // Check College Name is unique
                $CollegeName = $_POST["CollegeName"];
                if (! $college->ifExist("CollegeName", $CollegeName)) {
                    $this->setProperties($college, $_POST);
                    $college->TotalStudentsInCollege = StudentModel::count("StudentID", ["StudentCollegeID" => CollegeModel::lastRecord()]);
                    $this->saveCollege($college);
                } else {
                    $this->setMessage("already_exits", $CollegeName, MessagesType::Danger->name);
                }
            }
        }

        $this->authentication("colleges.add", [
            "messages" => Session::flash("messages"),
        ]);
    }

    /**
     * #[GET('/colleges/edit')]
     * @throws ErrorException
     */
    public function edit(): void
    {
        $this->language->load("template.common");
        $this->language->load("colleges.common");
        $this->language->load("colleges.edit");
        $college = CollegeModel::getByPK($this->params[0]);

        if (isset($_POST["edit"])) {
            $errors = $this->valid($this->rolesEdit, $_POST);
            $flag = true;

            // If it forms Has Error
            if (is_array($errors)) {
                $this->addErrorsMethodToSession($errors);
                $flag = false;
            }

            if ($flag) {
                $this->setProperties($college, $_POST);
                $this->saveCollege($college);
            }
        }



        $this->authentication("colleges.edit", [
            "collage" => $college,
        ]);
    }
    /**
     * Delete a college record from the database.
     *
     * This method is used to delete a college record from the database based on the provided
     * identifier. It first loads the language file for messages related to college deletion.
     * The method fetches the college ID from the request parameters, retrieves the corresponding
     * college record using the `CollegeModel::getByPK()` method, and checks if the college
     * exists. If the college is found and successfully deleted, a success message is set.
     * Otherwise, a failure message is set. Finally, the method redirects the user to the "/colleges" page.
     *
     * @return void
     */
    #[NoReturn] public function delete(): void
    {
        $this->language->load("colleges.delete");

        $id = $this->getParams()[0];

        $college = CollegeModel::getByPK($id);

        if (! $college) {
            $this->setMessage("not_exist", '', MessagesType::Danger->name);
        }

        $name = $college->CollegeName;

        if ($college->delete()) {
            $this->setMessage("success", $name, MessagesType::Success->name);
        } else {
            $this->setMessage("fail", $name, MessagesType::Danger->name);
        }

        $this->redirect("/colleges");
    }
}