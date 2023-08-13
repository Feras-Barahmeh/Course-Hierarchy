<?php

namespace App\Controllers;

use App\Core\FilterInput;
use App\Core\Validation;
use App\Enums\MessagesType;
use App\Enums\Privilege;
use App\Helper\HandsHelper;
use App\Models\DepartmentModel;
use App\Models\GuideModel;
use ErrorException;
use JetBrains\PhpStorm\NoReturn;

class GuidesController extends AbstractController
{
    use Validation;
    use HandsHelper;
    public static int $authentication = Privilege::Admin->value;

    private array $rolesAdd = [
        "GuideName"         => ["required", "alpha", "between" => [3, 100]],
        "Email"             => ["required", "email",],
        "GuideDepartmentID" => ["required", "posInt"],
    ];
    private array $rolesEdit = [
        "GuideName"         => ["alpha", "between" => [3, 100]],
        "GuideDepartmentID" => ["posInt"],
        "PhoneNumber"       => ["posInt"],
        "YearsOfExperience" => ["posInt", "max" => [30]],
    ];
    /**
     * GET('/guides')
     * @throws ErrorException
     */
    public function index(): void
    {

        $this->language->load("template.common");
        $this->language->load("guides.index");
        $this->language->load("guides.common");

        $extensionQuery = [
            "Department" => [
                "on" => [
                    "GuideDepartmentID" => DepartmentModel::getPK(),
                ]
            ],
        ];

        if (isset($_POST["search"])) {
            $extensionQuery["Department"]["like"] = FilterInput::str($_POST["value_search"]);
        }
        $guides = GuideModel::fetch(false, $extensionQuery);

        $this->authentication("guides.index", [
            "guides"=> $guides,
        ]);
    }

    /**
     * Save guide in DB object and handle success or failure.
     *
     * @param GuideModel $guide A reference to the GuideModel object to be saved.
     * @return void
     */
    private function saveGuide(GuideModel &$guide): void
    {
        if ($guide->save()) {
            $this->setMessage("success", $guide->GuideName, MessagesType::Success);
            $this->redirect("/guides");
        }  else {
            $this->setMessage("fail", $guide->GuideName, MessagesType::Danger);
        }
    }


    /**
     * GET('/guides/add')
     * @throws ErrorException
     */
    public function add(): void
    {

        $this->language->load("template.common");
        $this->language->load("guides.add");
        $this->language->load("guides.common");

        if (isset($_POST['add'])) {
            $errors = $this->valid($this->rolesAdd, $_POST);
            $flag = true;

            // If it forms Has Error
            if (is_array($errors)) {
                $this->addErrorsMethodToSession($errors);
                $flag = false;
            }

            if ($_POST["Password"] !== $_POST["ConfirmPassword"]) {
                $this->setMessage("error_not_match_password", '', MessagesType::Danger);
                $flag = false;
            }

            $name = FilterInput::str($_POST["GuideName"]);
            if (GuideModel::ifExist("GuideName", $name)) {
                $this->setMessage("error_guide_name_exist", $name,  MessagesType::Danger);
                $flag = false;
            }
            if (GuideModel::ifExist("Email", $_POST["Email"])) {
                $this->setMessage("error_guide_email_exist", $_POST["Email"],  MessagesType::Danger);
                $flag = false;
            }

            if ($flag) {

                $guide = new GuideModel();

                $this->setProperties($guide, $_POST);

                $guide->Password = self::encryption($_POST["Password"]);
                $guide->Privilege = Privilege::Guide->value;

                self::saveGuide($guide);

            }
            
        }
        

        $this->authentication("guides.add", [
            "departments" => DepartmentModel::all(),
        ]);
    }


    /**
     * GET('/guides/edit')
     * @throws ErrorException
     */
    public function edit(): void
    {

        $this->language->load("template.common");
        $this->language->load("guides.edit");
        $this->language->load("guides.common");

        $id = $this->getParams()[0];
        FilterInput::int($id);

        $guide = GuideModel::getByPK($id);


        if (! $guide) {
            $this->setMessage("error_edit_none_exist", '', MessagesType::Danger);
            $this->redirect("/guides");
        }
        

        if (isset($_POST['edit'])) {
            $errors = $this->valid($this->rolesEdit, $_POST);
            $flag = true;

            // If it forms Has Error
            if (is_array($errors)) {
                $this->addErrorsMethodToSession($errors);
                $flag = false;
            }


            $name = FilterInput::str($_POST["GuideName"]);

            if (GuideModel::ifExist("GuideName", $name) && $guide->GuideName != $name) {
                $this->setMessage("error_guide_name_exist", $name,  MessagesType::Danger);
                $flag = false;
            }
            $email = $_POST["Email"] ?? '';
            if ($email != '') {
                if (GuideModel::ifExist("Email", $email) && $guide->Email != $email) {
                    $this->setMessage("error_guide_email_exist", $_POST["Email"],  MessagesType::Danger);
                    $flag = false;
                }
            }



            if ($flag) {
                FilterInput::str($_POST["OfficeHours"]);
                $this->setProperties($guide, $_POST);

                self::saveGuide($guide);
            }

        }

        $this->authentication("guides.edit", [
            "departments" => DepartmentModel::all(),
            "guide" => $guide,
        ]);
    }

    /**
     * GET('/guides/delete')
     * @return void
     */
    #[NoReturn] public function delete(): void
    {
        $this->language->load("guides.delete");

        $id = $this->getParams()[0];
        FilterInput::int($id);

        $guide = GuideModel::getByPK($id);

        if (! $guide) {
            $this->setMessage("not_exist", '', MessagesType::Danger);
            $this->redirect("/guides");
        }

        if ($guide->delete()) {
            $this->setMessage("success", $guide->GuideName, MessagesType::Success);
        } else {
            $this->setMessage("fail", $guide->GuideName, MessagesType::Danger);
        }

        unset($guide);
        $this->redirect("/guides");
    }
}