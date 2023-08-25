<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\FilterInput;
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
use ReflectionException;

class GuiderController extends AbstractController
{
    use Validation;
    use HandsHelper;
    public static int $authentication = Privilege::Guide->value;

    private array $rolesAdd = [
        "Title"    => ["required", "max" => [255]],
    ];
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
        $this->language->load("guider.index");

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
     * @throws \Exception
     */
    private function checkErrorVote(): bool
    {
        $flag = true;

        if (isset($_POST["TimeExpired"])) {
            $dateTime = new DateTime($_POST["TimeExpired"]);
            $formattedDatetime = $dateTime->format('Y-m-d H:i:s');

            if ($formattedDatetime <= date("Y-m-d H:i:s")) {
                $this->setMessage("time_expired_false", '', MessagesType::Danger);
                $flag = false;
            }
        }
        return $flag;
    }

    /**
     * Add vote
     *
     * Get(/guider/vote)
     * @throws ErrorException
     * @throws \Exception
     */
    public function add(): void
    {
        $this->language->load("template.common");
        $this->language->load("guider.common");
        $this->language->load("guider.add");

        if (isset($_POST["share"])) {
            $errors = $this->valid($this->rolesAdd, $_POST);
            $flag = true;
            
            if (is_array($errors)) { // If it forms has error
                $this->addErrorsMethodToSession($errors);
                $flag = false;
            }


            
            if ($flag) {
                $flag = $this->checkErrorVote();
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
        }
        
        $this->authentication("guider.add", [
            "user"  => Auth::user(),
            "years" => Handel::prepareAcademicYears(),
            "majors"=> MajorModel::all(),
        ]);
    }

    /**
     * Page to show all votes for his guider
     *
     * Get(/guider/votes)
     * @return void
     * @throws ErrorException
     */
    public function votes(): void
    {
        $this->language->load("template.common");
        $this->language->load("guider.common");
        $this->language->load("guider.votes");

        $votesGuider = VoteModel::get("
                SELECT * FROM " . VoteModel::getTableName() .

            " WHERE ForDepartment = " . Auth::user()->GuideDepartmentID);


        $this->authentication("guider.votes", [
            "votesGuider" => $votesGuider,
            "user" => Auth::user()
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

    /**
     *
     * @return void
     * @throws ErrorException
     * @throws ReflectionException
     * @throws \Exception
     */
    public function edit(): void
    {
        $this->language->load("template.common");
        $this->language->load("guider.common");
        $this->language->load("guider.edit");

        $vote = VoteModel::getByPK($this->firstParam());
        if (! $vote) $this->redirect("/guider");

        if (isset($_POST["edit"])) {
            $errors = $this->valid($this->rolesEdit, $_POST);
            $flag = true;

            if (is_array($errors)) { // If it forms has error
                $this->addErrorsMethodToSession($errors);
                $flag = false;
            }

            if ($flag && $this->checkErrorVote()) {

                self::setProperties($vote, $_POST);
                $vote->ForDepartment = Auth::user()->GuideDepartmentID;
                $vote->AddedBy = Auth::user()->GuideID;

                $dateTime = new DateTime($_POST["TimeExpired"]);
                $formattedDatetime = $dateTime->format('Y-m-d H:i:s');
                $vote->TimeExpired = $formattedDatetime;

                self::saveAndHandleOutcome($vote, "$vote->Title", "/guider");
            }
        }

        $this->authentication("guider.edit", [
            "user" => Auth::user(),
            "vote" => $vote,
            "years" => Handel::prepareAcademicYears(),
            "majors"=> MajorModel::all(),
        ]);
    }

}