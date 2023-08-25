<?php

namespace App\Controllers;

use App\Core\FilterInput;
use App\Core\Validation;
use App\Enums\Language;
use App\Enums\MessagesType;
use App\Enums\Privilege;
use App\Helper\HandsHelper;
use App\Models\DepartmentModel;
use App\Models\InstructorModel;
use ErrorException;
use JetBrains\PhpStorm\NoReturn;

class InstructorsController extends AbstractController
{
    use Validation;
    use HandsHelper;
    public static int $authentication = Privilege::Admin->value;
    private array $rolesAdd = [
        "FirstName"                     => ["required", "alpha", "between" => [2, 50]],
        "LastName"                      => ["required", "between" => [2, 50]],
        "InstructorDepartmentID"        => ["required", "int", "posInt"],
        "Email"                         => ["required", "email", "between" => [LEN_TDL_STUDENT_EMAIL, 100]],
        "Salary"                        => ["required", "float", "pos", "min" => [300]],
        "Password"                      => ["required", "alphaNum"],
        "NationalIdentificationNumber"  => ["required", "alphaNum", "equal" => [11]],
        "IfFullTime"                    => ["required"],
        "IsActive"                      => ["required"],
    ];

    private array $rolesEdit = [
        "PhoneNumber"                   => ["numeric", "equal" => [10]],
        "Address"                       => ["between" => [2, 100]],
        "City"                          => ["alpha", "between" => [2, 50]],
        "State"                         => ["alpha", "between" => [2, 50]],
        "Country"                       => ["alpha", "between" => [2, 50]],
        "DOB"                           => ["date"],
        "HireDate"                      => ["date"],
        "YearsOfExperience"             => ["int", "posInt", "between" => [0, 50]],
    ];
    /**
     * #[GET('/')]
     * @throws ErrorException
     */
    public function index(): void
    {
        $this->language->load("template.common");
        $this->language->load("template.errors");
        $this->language->load("instructors.common");
        $this->language->load("instructors.index");

        $extensionQuery = [
            "Department" => [
                "on" => ["InstructorDepartmentID" => DepartmentModel::getPK()],
            ]
        ];

        if (isset($_POST["search"])) {
            $valueSearch = trim($_POST["value_search"]);
            $extensionQuery["Department"]["like"] = FilterInput::str($valueSearch);
        }

        $instructors = InstructorModel::fetch(false, $extensionQuery);

        $this->authentication("instructors.index", [
            "instructors" => $instructors,
        ]);
    }
    /**
     * Set values of columns for an InstructorModel instance.
     *
     * This method populates the columns of an InstructorModel instance with provided values.
     * It sets the privilege column to the value corresponding to the 'Instructor' privilege type.
     * The method then iterates through the provided $values array and assigns each column's value
     * to the corresponding property of the $instructor object, excluding certain columns listed
     * in the $neglectingColumns array.
     *
     * @param InstructorModel $instructor A reference to the InstructorModel instance to be populated.
     * @param array $values An associative array containing the values to be set for each column.
     *                      The keys of the array represent column names, and the values represent
     *                      the new values for those columns.
     *
     * @return void
     */
    private function setInstructorColumnsValues(InstructorModel &$instructor, array $values): void
    {
        $columns = array_keys($values);
        foreach ($columns as $column) {
            if (! in_array($column, self::$neglectingColumns)) {
                $instructor->{$column} = $values[$column];
            }
        }
        $instructor->Privilege = Privilege::Instructor->value;
        $instructor->Password = self::encryption($values["Password"]);
        $instructor->language = Language::English->value;
    }
    /**
     * Validate instructor data from form submission.
     *
     * This method is used to validate instructor data submitted via a form. It performs multiple checks on the submitted data,
     * including checking for the existence of an email address in the database, validating the email address's top-level domain (TLD),
     * and checking if the password and confirmation password match.
     *
     * If any of the validation checks fail, the method sets appropriate error message details and sets the `$flag` variable to false,
     * indicating a validation failure.
     *
     * The method then returns the value of the `$flag` variable, which indicates whether the validation passed (true) or failed (false).
     *
     * @return bool Returns true if the student data passes all validation checks, and false otherwise.
     */
    private function checkInstructorErrors(InstructorModel &$instructor, string &$keyMessage, string|array &$paramMessage): bool
    {

        $flag = true;
        if (isset($_POST["Email"]) && $instructor::existsInTable($_POST["Email"]) !== true) {
            $keyMessage = "fail_email_unique";
            $paramMessage = $_POST["Email"];
            $flag =false;

        } elseif (isset($_POST["NationalIdentificationNumber"]) && $instructor::ifExist("NationalIdentificationNumber", $_POST["NationalIdentificationNumber"]) ) {
            $keyMessage = "fail_national_id_number_unique";
            $flag =false;

        } elseif( isset($_POST["Email"]) && ! self::checkTDLEmail($_POST["Email"], TLD_INSTRUCTOR_EMAIL) ) {
            $keyMessage = "error_TDL_email";
            $paramMessage = TLD_INSTRUCTOR_EMAIL;
            $flag =false;

        } elseif(isset($_POST["ConfirmPassword"] ) && isset($_POST["Password"]) && $_POST["ConfirmPassword"] !== $_POST["Password"]) {
            $keyMessage = "error_not_match_password";
            $flag =false;
        }
        return $flag;
    }

    /**
     * #[GET('/instructors/add')]
     * @throws ErrorException
     */
    public function add(): void
    {

        $this->language->load("template.common");
        $this->language->load("template.errors");
        $this->language->load("instructors.common");
        $this->language->load("instructors.add");

        if (isset($_POST['add'])) {
            $hasError = $this->valid($this->rolesAdd, $_POST);
            $flag = true;

            // If it forms Has Error
            if (is_array($hasError)) {
                $this->addErrorsMethodToSession($hasError);
                $flag = false;
            }

            if ($flag) {

                $instructor = new InstructorModel();
                $this->setInstructorColumnsValues($instructor, $_POST);

                $paramMessage = '';
                $keyMessage = '';

                $flag = $this->checkInstructorErrors($instructor, $keyMessage, $paramMessage);

                if ($flag) {
                    $name = ucfirst($instructor->FirstName) . ' ' . ucfirst($instructor->LastName);
                    $this->saveAndHandleOutcome($instructor, $name, "/instructors");
                } else {
                    $this->setMessage($keyMessage, $paramMessage, MessagesType::Danger);
                }

            }
        }

        $this->authentication("instructors.add", [
            "departments" => DepartmentModel::all(),
        ]);
    }

    /**
     * Edit an existing instructor's information.
     *
     * This method is used to edit an existing instructor's information based on the provided
     * identifier. It loads necessary language files for messages and labels used in the editing
     * process. The method retrieves the instructor data by fetching the corresponding record
     * from the database using the identifier from the request parameters. If the HTTP POST request
     * contains valid form data, it performs validation using the `$rolesEdit` rules and updates the
     * instructor's properties with the new values using the `setProperties()` method. If the
     * validation and property updates are successful, the method saves the instructor data in the
     * database using the `save()` method. Appropriate success or failure messages are set based on
     * the outcome, and the user is redirected accordingly. The method also ensures authentication
     * for accessing the edit page, providing relevant data such as flash messages, departments, and
     * the instructor instance to the view for rendering.
     *
     * @return void
     *
     * @throws ErrorException
     * @link /instructors/edit/{PK}
     */
    public function edit(): void
    {

        $this->language->load("template.common");
        $this->language->load("template.errors");
        $this->language->load("instructors.common");
        $this->language->load("instructors.edit");

        $instructor = InstructorModel::getByPK($this->params[0]);
        if (! $instructor) $this->redirect("/instructors");

        if (isset($_POST["edit"])) {
            $errors = $this->valid($this->rolesEdit, $_POST);
            $flag = true;

            // If it forms Has Error
            if (is_array($errors)) {
                $this->addErrorsMethodToSession($errors);
                $flag = false;
            }

            $keyMessage = '';
            $paramMessage = '';

            $flag = $this->checkInstructorErrors($instructor, $keyMessage, $paramMessage);

            if ($flag) {
               $this->setProperties($instructor, $_POST);
               $this->saveAndHandleOutcome(
                   $instructor,
                   ucfirst($instructor->FirstName) . ' ' . ucfirst($instructor->LastName),
                   "/instructors"
               );
            } else {
                $this->setMessage($keyMessage, $paramMessage, MessagesType::Danger );
            }
        }


        $this->authentication("instructors.edit", [
            "departments" => DepartmentModel::all(),
            "instructor" => $instructor,
        ]);
    }
    /**
     * Delete an instructor record from the database.
     *
     * This method is used to delete an instructor record from the database based on the provided
     * identifier. It first loads the language file for messages related to instructor deletion.
     * The method fetches the instructor ID from the request parameters, retrieves the corresponding
     * instructor record using the `InstructorModel::getByPK()` method, and checks if the instructor
     * exists. If the instructor is found and successfully deleted, a success message is set. Otherwise,
     * a failure message is set. Finally, the method redirects the user to the "/instructors" page.
     *
     * @return void
     */
    #[NoReturn] public function delete(): void
    {
        $this->language->load("instructors.delete");

        $id = $this->getParams()[0];
        FilterInput::int($id);

        $instructor = InstructorModel::getByPK($id);

        if (! $instructor) {
            $this->setMessage("not_exist", '', MessagesType::Danger);
        }

        $name = $instructor->FirstName . ' ' . $instructor->LastName;

        if ($instructor->delete()) {
            $this->setMessage("success", $name, MessagesType::Success);
        } else {
            $this->setMessage("fail", $name, MessagesType::Danger);
        }

        unset($instructor);
        $this->redirect("/instructors");
    }
}