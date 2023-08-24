<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Validation;
use App\Enums\MessagesType;
use App\Enums\Privilege;
use App\Helper\Handel;
use App\Helper\HandsHelper;
use App\Models\DepartmentModel;
use App\Models\MajorModel;
use App\Models\VoteModel;
use DateTime;
use ErrorException;
use JetBrains\PhpStorm\NoReturn;

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
        $this->language->load("votes.common");

        $extensionQuery = [
            "Major" => [
                "on" => [
                    "ForMajor" => MajorModel::getPK(),
                ],
                "type" => "LEFT",

            ],
            "Department" => [
                "on" => [
                    "ForDepartment" => DepartmentModel::getPK(),
                ],
                "type" => "LEFT",
            ],
        ];
        
        $votes = VoteModel::fetch(false, $extensionQuery);

        $this->authentication("guider.index", [
            "user" => Auth::user(),
            "votes" => $votes,
        ]);
    }

    /**
     * Add vote
     *
     * Get(/guider/vote)
     * @throws ErrorException
     * @throws \Exception
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
                $vote->AddedBy = Auth::user()->GuideID;

                $dateTime = new DateTime($_POST["TimeExpired"]);
                $formattedDatetime = $dateTime->format('Y-m-d H:i:s');
                $vote->TimeExpired = $formattedDatetime;

                self::saveAndHandleOutcome($vote, "$vote->Title", "/guider");
            }
        }
        
        $this->authentication("guider.vote", [
            "user"  => Auth::user(),
            "years" => Handel::prepareAcademicYears(),
            "majors"=> MajorModel::all(),
        ]);
    }

    /**
     * Delete Vote
     *
     * Get("/guider/delete/{id vote}"
     *
     * @return void
     */
    #[NoReturn] public function delete(): void
    {
        $this->language->load("votes.delete");

        $id = $this->firstParam();

        $vote = VoteModel::getByPK($id);

        if (! $vote) {
            $this->setMessage("not_exist", '', MessagesType::Danger);
            $this->redirect("/guider");
        }


        if ($vote->delete()) {
            $this->setMessage("success", $vote->Title, MessagesType::Success);
        } else {
            $this->setMessage("fail", $vote->Title, MessagesType::Danger);
        }

        unset($vote);
        $this->redirect("/guider");
    }
}