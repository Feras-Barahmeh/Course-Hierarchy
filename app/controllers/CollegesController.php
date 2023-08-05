<?php

namespace App\Controllers;

use App\Core\Session;
use App\Core\Validation;
use App\Core\View;
use App\Enums\MessagesType;
use App\Enums\Privilege;
use App\Models\CollegeModel;
use ErrorException;
use http\Message;
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

        $collegesRecords = null;
        if (isset($_POST["search"])) {
            $collegesRecords = CollegeModel::get(CollegeModel::filterTable($_POST["value_search"]));
        } else if (isset($_POST["resit"])) {
            $records = CollegeModel::getLazy(["ORDER BY " => "TotalStudents DESC"]);
            $this->putLazy($collegesRecords, $records);
        } else {
            $records = CollegeModel::getLazy(["ORDER BY " => "TotalStudents DESC"]);
            $this->putLazy($collegesRecords, $records);
        }

        $this->authentication("colleges.index", [
            "colleges" => $collegesRecords,
        ]);
    }
    private function setProperties(&$collage): void
    {
        $collage->CollegeName = $_POST["CollegeName"];
        $collage->TotalStudents = $_POST["TotalStudents"];
    }

    private function saveCollege($college): void
    {
        if ($college->save()) {
            $this->setMessage("success", $college->CollegeName, MessagesType::Success->value);
            $this->redirect("/colleges");
        }  else {
            $this->setMessage("fail", $college->CollegeName, MessagesType::Danger->value);
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
                if (! $college->countRow("CollegeName", $CollegeName)) {
                    $this->setProperties($college);
                    $this->saveCollege($college);
                } else {
                    $this->setMessage("already_exits", $CollegeName, MessagesType::Danger->value);
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
                $this->setProperties($college);
                $this->saveCollege($college);
            }
        }



        $this->authentication("colleges.edit", [
            "messages" => Session::flash("message"),
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