<?php

namespace App\Controllers;

use App\Core\Validation;
use App\Core\View;
use ErrorException;

class InstructorsController extends AbstractController
{
    use Validation;
    private array $_rolesAddValid = [
        "FirstName"         => ["required", "int", "between" => [20, 60]],
    ];
    /**
     * #[GET('/')]
     * @throws ErrorException
     */
    public function index(): void
    {
        $this->language->load("template.common");
        
        View::view("instructors.index", $this, [
        ]);
    }

    
    /**
     * #[GET('/instructors/add')]
     * @throws ErrorException
     */
    public function add(): void
    {

        $this->language->load("template.common");
        $this->language->load("template.errors");

        if (isset($_POST['add'])) {
            $hasError = $this->valid($this->_rolesAddValid, $_POST);
            $flag = true;
            

            // If it forms Has Error
            if (is_array($hasError)) {
                $this->addErrorsMethodToSession($hasError);
                $flag = false;
            }

            if ($flag) {

            }

        }

        View::view("instructors.add", $this, [
            "messages" => $this->messages->getMessage(),
        ]);
    }
}