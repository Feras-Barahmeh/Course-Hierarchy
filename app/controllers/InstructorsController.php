<?php

namespace App\Controllers;

use App\Core\Session;
use App\Core\Validation;
use App\Core\View;
use App\Enums\MessagesType;
use App\Enums\Privilege;
use App\Helper\HandsHelper;
use App\Models\DepartmentModel;
use App\Models\InstructorModel;
use ErrorException;

class InstructorsController extends AbstractController
{
    use Validation;
    use HandsHelper;
    public static int $authentication = Privilege::Admin->value;
    private array $_rolesAddValid = [
        "FirstName"                     => ["required", "alpha", "between" => [2, 50]],
        "LastName"                      => ["required", "between" => [2, 50]],
        "Department"                    => ["required", "int", "posInt"],
        "Email"                         => ["required", "email", "between" => [LEN_TDL_EMAIL, 100]],
        "PhoneNumber"                   => ["numeric", "between" => [10, 10]],
        "Address"                       => ["between" => [2, 100]],
        "City"                          => ["alpha", "between" => [2, 50]],
        "State"                         => [ "alpha", "between" => [2, 50]],
        "Country"                       => ["alpha", "between" => [2, 50]],
        "DOB"                           => ["date"],
        "HireDate"                      => ["date"],
        "Salary"                        => ["float"],
        "YearsOfExperience"             => ["int", "posInt", "between" => [0, 50]],
        "IfFullTime"                    => ["int", "posInt", "between" => [0, 1]],
        "IsActive"                      => ["int", "posInt", "between" => [0, 1]],
        "Password"                      => ["required", "between" => [2, 200]],
        "NationalIdentificationNumber"  => ["required", "alphaNum"],
    ];
    /**
     * #[GET('/')]
     * @throws ErrorException
     */
    public function index(): void
    {
        $this->language->load("template.common");


        $this->authentication("instructors.index");
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
            if (! in_array($column, $this->neglectingColumns)) {
                $instructor->{$column} = $values[$column];
            }
        }
        $instructor->privilege = Privilege::Instructor->value;
        $instructor->Password = self::encryption($values["Password"]);
    }
    /**
     * Save an InstructorModel instance to the database and handle the response.
     *
     * This private method is used to save an InstructorModel instance to the database. It calls the `save()` method
     * on the provided $instructor object to persist it to the database. Depending on the success or failure of the
     * save operation, the method sets appropriate messages and redirects the user to the appropriate page.
     *
     * @param InstructorModel $instructor A reference to the InstructorModel instance to be saved.
     *
     * @return void
     */
    private function saveInstructor(InstructorModel &$instructor): void
    {
        if ($instructor->save()) {
            $this->setMessage(
                "success",
                ucfirst($instructor->LastName),
                MessagesType::Success->name);

            $this->redirect("/instructors");
        } else {
            $this->setMessage(
                "fail",
                ucfirst($instructor->LastName),
                MessagesType::Danger->name);
        }
    }
    /**
     * Add a new instructor based on the submitted form data.
     *
     * This method is responsible for processing the submitted form data for adding a new instructor.
     * It validates the form data using the validation rules defined in the $_rolesAddValid property.
     * If the form data is valid, it creates a new instance of the InstructorModel class, populates it with
     * the submitted data using the setInstructorColumnsValues() method, and then checks if the email is
     * unique in the database using the existsInTable() method. If the email is not unique or if the passwords
     * do not match, appropriate error messages are set using the setMessage() method. Otherwise, it saves
     * the instructor to the database using the saveInstructor() method.
     *
     * @return void
     */
    private function addNewInstructor(): void
    {
        if (isset($_POST['add'])) {
            $hasError = $this->valid($this->_rolesAddValid, $_POST);
            $flag = true;


            // If it forms Has Error
            if (is_array($hasError)) {
                $this->addErrorsMethodToSession($hasError);
                $flag = false;
            }

            if ($flag) {

                $instructor = new InstructorModel();
                $this->setInstructorColumnsValues($instructor, $_POST);


                if ($instructor::existsInTable($_POST["Email"]) !== true) {
                    $this->setMessage(
                        "fail_email_unique",
                        $_POST["Email"],
                        MessagesType::Danger->name);
                } elseif($_POST["ConfirmPassword"] !== $_POST["Password"]) {
                    $this->setMessage("error_not_match_password", '',type: MessagesType::Danger->name);
                } else {
                    $this->saveInstructor($instructor);
                }


            }
        }
    }
    /**
     * #[GET('/instructors/add')]
     * @throws ErrorException
     */
    public function add(): void
    {

        $this->language->load("template.common");
        $this->language->load("template.errors");
        $this->language->load("instructors.add");

        $this->addNewInstructor();

        $this->authentication("instructors.add", [
            "messages"    => Session::flash("message"),
            "departments" => DepartmentModel::all(),
        ]);
    }
}