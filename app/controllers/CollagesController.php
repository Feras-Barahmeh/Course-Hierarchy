<?php

namespace App\Controllers;

use App\Core\Session;
use App\Core\Validation;
use App\Core\View;
use App\Enums\MessagesType;
use App\Models\CollageModel;
use ErrorException;

class CollagesController extends AbstractController
{
    use Validation;
    /**
     * patterns check forms
     * @var array|array[]
     */
    private array $rolesAdd = [
        "CollegeName"         => ["required", "alpha", "between" => [4, 100]],
        "TotalStudents"       => ["numeric", "between" => [0, 65535]],
    ];
    /**
     * #[GET('/collages')]
     * @throws ErrorException
     */
    public function index(): void
    {
        $this->language->load("template.common");

        $collagesRecords = null;
        if (isset($_POST["search"])) {
            $collagesRecords = CollageModel::get(CollageModel::filterTable($_POST["value_search"]));
        } else {
            $records = (new CollageModel())->allLazy(["ORDER BY " => "TotalStudents DESC"]);
            $this->putLazy($collagesRecords, $records);
        }

        View::view("collages.index", $this, [
            "collages" => $collagesRecords,
        ]);
    }
    private function setProperties(CollageModel &$collage): void
    {
        $collage->CollegeName = $_POST["CollegeName"];
        $collage->TotalStudents = $_POST["TotalStudents"];
    }

    /**
     * #[GET('/collages/add')]
     * @throws ErrorException
     */
    public function add(): void
    {
        $this->language->load("template.common");
        $this->language->load("collages.add");
        $this->language->load("collages.common");

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
                $collage = new CollageModel();

                // Check College Name is unique
                $CollegeName = $_POST["CollegeName"];
                if (! $collage->countRow("CollegeName", $CollegeName)) {

                    $this->setProperties($collage);

                    if ($collage->save()) {
                        $message = $this->messages->feedKey("success_add_collage", $CollegeName, $words);
                        $this->messages->add($message, MessagesType::Success);

                        $this->redirect("/collages");
                    }  else {
                        $message = $this->messages->feedKey("fail_add_collage", $CollegeName, $words);
                        $this->messages->add($message, MessagesType::Danger);
                    }
                }

                $message = $this->messages->feedKey("already_exits", $CollegeName, $words);
                $this->messages->add($message, MessagesType::Danger);
            }
        }

        View::view("collages.add", $this, [
            "messages" => $this->messages->getMessage(),
        ]);
    }
}