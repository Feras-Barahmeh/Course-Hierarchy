<?php

namespace App\Controllers;

use App\Core\Session;
use App\Core\Validation;
use App\Core\View;
use App\Enums\MessagesType;
use App\Models\CollegeModel;
use ErrorException;

class CollegesController extends AbstractController
{
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

        $collegesRecords = null;
        if (isset($_POST["search"])) {
            $collegesRecords = CollegeModel::get(CollegeModel::filterTable($_POST["value_search"]));
        } else if (isset($_POST["resit"])) {
            $records = (new CollegeModel())->allLazy(["ORDER BY " => "TotalStudents DESC"]);
            $this->putLazy($collegesRecords, $records);
        } else {
            $records = (new CollegeModel())->allLazy(["ORDER BY " => "TotalStudents DESC"]);
            $this->putLazy($collegesRecords, $records);
        }

        View::view("colleges.index", $this, [
            "colleges" => $collegesRecords,
        ]);
    }
    private function setProperties(&$collage): void
    {
        $collage->CollegeName = $_POST["CollegeName"];
        $collage->TotalStudents = $_POST["TotalStudents"];
    }

    private function saveCollege($college, $words): void
    {
        if ($college->save()) {
            $message = $this->messages->feedKey("success", $college->CollegeName, $words);
            $this->messages->add($message, MessagesType::Success);

            $this->redirect("/colleges");
        }  else {
            $message = $this->messages->feedKey("fail", $college->CollegeName, $words);
            $this->messages->add($message, MessagesType::Danger);
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

        $words = $this->language->getDictionary();

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

                    $this->saveCollege($college, $words);
                } else {
                    $message = $this->messages->feedKey("already_exits", $CollegeName, $words);
                    $this->messages->add($message, MessagesType::Danger);
                }


            }
        }

        View::view("colleges.add", $this, [
            "messages" => $this->messages->getMessage(),
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

        $words = $this->language->getDictionary();

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
                $this->saveCollege($college, $words);
            }
        }



        View::view("colleges.edit", $this, [
            "messages" => $this->messages->getMessage(),
            "collage" => $college,
        ]);
    }

    public function delete(): void
    {
        $this->language->load("colleges.delete");
        $words = $this->language->getDictionary();

        $id = $this->getParams()[0];

        $college = CollegeModel::getByPK($id);

        if (! $college) {
            $this->messages->add($this->messages->get("not_exist"), MessagesType::Danger);
            $this->redirect("/colleges");
        }

        $name = $college->CollegeName;

        if ($college->delete()) {
            $message = $this->messages->feedKey("success", $name, $words);
            $this->messages->add($message, MessagesType::Success);
            $this->redirect("/colleges");
        }

        $message = $this->messages->feedKey("fail", $name, $words);
        $this->messages->add($message, MessagesType::Danger);

        $this->redirect("/colleges");
    }
}