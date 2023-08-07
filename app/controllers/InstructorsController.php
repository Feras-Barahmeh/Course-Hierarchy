<?php

namespace App\Controllers;

use App\Core\Session;
use App\Core\Validation;
use App\Core\View;
use App\Enums\Language;
use App\Enums\MessagesType;
use App\Enums\Privilege;
use App\Helper\HandsHelper;
use App\Models\CollegeModel;
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
        "Department"                    => ["required", "int", "posInt"],
        "Email"                         => ["required", "email", "between" => [LEN_TDL_EMAIL, 100]],
        "Salary"                        => ["required", "float"],
        "Password"                      => ["required", "between" => [2, 200]],
        "NationalIdentificationNumber"  => ["required", "alphaNum", "equal" => [11]],
        "IfFullTime"                    => ["required"],
        "IsActive"                      => ["required"],
    ];

    private array $rolesEdit = [
        "PhoneNumber"                   => ["numeric", "between" => [10, 10]],
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


        $instructorsRecords = null;
        if (isset($_POST["search"])) {
            $instructorsRecords = InstructorModel::get(InstructorModel::filterTable($_POST["value_search"]));
        } else if (isset($_POST["resit"])) {
            $records = InstructorModel::getLazy(["ORDER BY " => "InstructorID DESC"]);
            $this->putLazy($instructorsRecords, $records);
        } else {
            $records = InstructorModel::getLazy(["ORDER BY " => "InstructorID DESC"]);
            $this->putLazy($instructorsRecords, $records);
        }

        $this->authentication("instructors.index", [
            "messages"    => Session::flash("message"),
            "instructors" => $instructorsRecords,
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
            if (! in_array($column, self::neglectingColumns)) {
                $instructor->{$column} = $values[$column];
            }
        }
        $instructor->Privilege = Privilege::Instructor->value;
        $instructor->Password = self::encryption($values["Password"]);
        $instructor->language = Language::English->value;
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


                if ($instructor::existsInTable($_POST["Email"]) !== true) {
                    $this->setMessage(
                        "fail_email_unique",
                        $_POST["Email"],
                        MessagesType::Danger->name);
                } elseif($_POST["ConfirmPassword"] !== $_POST["Password"]) {
                    $this->setMessage("error_not_match_password", '', MessagesType::Danger->name);
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
        $this->language->load("instructors.common");
        $this->language->load("instructors.add");


        $this->addNewInstructor();

        $this->authentication("instructors.add", [
            "messages"    => Session::flash("message"),
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

        if (isset($_POST["edit"])) {
            $errors = $this->valid($this->rolesEdit, $_POST);
            $flag = true;

            // If it forms Has Error
            if (is_array($errors)) {
                $this->addErrorsMethodToSession($errors);
                $flag = false;
            }

            if ($flag) {
               $this->setProperties($instructor, $_POST);
               if ($instructor->save())  {
                   $this->setMessage("success", ucfirst($instructor->FirstName) . ' ' . ucfirst($instructor->LastName), MessagesType::Success->name );
                   $this->redirect("/instructors");
               } else {
                   $this->setMessage("fail", ucfirst($instructor->FirstName) . ' ' . ucfirst($instructor->LastName), MessagesType::Danger->name );
               }
            }
        }


        $this->authentication("instructors.edit", [
            "messages"    => Session::flash("message"),
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

        $instructor = InstructorModel::getByPK($id);

        if (! $instructor) {
            $this->setMessage("not_exist", '', MessagesType::Danger->name);
        }

        $name = $instructor->FirstName . ' ' . $instructor->LastName;

        if ($instructor->delete()) {
            $this->setMessage("success", $name, MessagesType::Success->name);
        } else {
            $this->setMessage("fail", $name, MessagesType::Danger->name);
        }

        $this->redirect("/instructors");
    }
}