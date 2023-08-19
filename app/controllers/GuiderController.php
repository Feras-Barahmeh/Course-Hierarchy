<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Validation;
use App\Enums\Privilege;
use App\Helper\Handel;
use App\Helper\HandsHelper;
use App\Models\DepartmentModel;
use App\Models\MajorModel;
use App\Models\VoteModel;
use ErrorException;

class GuiderController extends AbstractController
{
    use Validation;
    use HandsHelper;
    public static int $authentication = Privilege::Guide->value;

    private array $rolesEdit = [
        "Title"    => ["required", "max" => [255]],
    ];

    /**
     * GET('/guider')
     * @throws ErrorException
     */
    public function index(): void
    {
        $this->language->load("template.common");

        $this->authentication("guider.index", [
            "user" => Auth::user(),
        ]);
    }

    /**
     * Add vote
     *
     * Get(/guider/vote)
     * @throws ErrorException
     */
    public function vote(): void
    {
        $this->language->load("template.common");
        $this->language->load("guider.common");
        $this->language->load("guider.vote");

        if (isset($_POST["share"])) {
            $errors = $this->valid($this->rolesEdit, $_POST);
            $flag = true;
            
            if (is_array($errors)) { // If it forms has error
                $this->addErrorsMethodToSession($errors);
                $flag = false;
            }
            
            if ($flag) {
                $vote = new VoteModel();
                self::setProperties($vote, $_POST);
                $vote->ForDepartment = Auth::user()->GuideDepartmentID;

                self::saveAndHandleOutcome($vote, "$vote->Title", "/guider");
            }
        }
        
        $this->authentication("guider.vote", [
            "user"  => Auth::user(),
            "years" => Handel::prepareAcademicYears(),
            "majors"=> MajorModel::all(),
            "departments" => DepartmentModel::all(),
        ]);
    }
}