<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Validation;
use App\Enums\MessagesType;
use App\Enums\Privilege;
use App\Helper\HandsHelper;
use App\Models\BallotOutcomeModel;
use App\Models\CourseModel;
use App\Models\MajorModel;
use App\Models\Model;
use App\Models\StudentModel;
use App\Models\VoteModel;
use ErrorException;
use const http\Client\Curl\AUTH_ANY;

class StudentController extends AbstractController
{
    use Validation;
    use HandsHelper;
    public static int $authentication = Privilege::Student->value;

    /**
     * GET('/student')
     * @throws ErrorException
     */
    public function index(): void
    {
        $this->language->load("template.common");
        $this->language->load("student.index");

        $student = Model::execute("SELECT * FROM " . StudentModel::getTableName() . " JOIN " .
            " Majors ON StudentMajor = " . MajorModel::getPK() .
            " WHERE StudentID = " . Auth::user()->StudentID
        ,\PDO::FETCH_CLASS)[0];
//
//        $sql = "
//        SELECT *
//            FROM Votes
//        WHERE
//            (ForMajor IS NOT NULL AND ForMajor <> 0 AND ForYear IS NOT NULL AND ForDepartment = {$student->StudentDepartmentID} AND ForMajor = '{$student->StudentYear}')
//        OR
//            (ForMajor IS NULL OR ForMajor = 0) AND ForDepartment = {$student->StudentDepartmentID} ;
//        ";

        $sql = "
        SELECT
	        *
        FROM
            Votes
        WHERE
            ((ForYear = '{$student->StudentYear}' OR ForMajor = '{$student->StudentMajor}' ) AND ForDepartment = {$student->StudentDepartmentID} AND Votes.IsActive = '1' AND TimeExpired > NOW())
            OR
             ForDepartment = {$student->StudentDepartmentID} AND Votes.IsActive = '1' AND TimeExpired > NOW();
        ";

        $votes = Model::execute($sql, \PDO::FETCH_CLASS);

        $this->authentication("student.index", [
            "user" => $student,
            "votes" => $votes,

        ]);
    }

    /**
     * Page vote student
     *
     * Get('student/doVote')
     * @throws ErrorException
     */
    public function ballot(): void
    {
        $this->language->load("template.common");
        $this->language->load("student.ballot");

        $vote = VoteModel::getByPK($this->firstParam());

        if (! $vote) {
            $this->redirect("/student");
        }

        $student = StudentModel::getStudent();

        $courses = CourseModel::get("SELECT * FROM " . CourseModel::getTableName() . " WHERE YEAR = '" . $student->StudentYear . "'");

        $coursesChosen = BallotOutcomeModel::getChosenCourses($student, $this->firstParam());

        $coursesIDs = [];
        foreach ($coursesChosen as $idCourse) {
            $coursesIDs[] =  $idCourse->CourseID;
        }

        if (isset($_POST["vote"])) {

            $coursesChose = $_POST["courses"];
            BallotOutcomeModel::deleteBallotStudent(Auth::user()->{Auth::getPKUser()}, $this->firstParam());
            $flag = true;
            if (isset($_POST["courses"])) {

                for ($i = 0; $i < count($coursesChose); $i++) {
                    $course = $coursesChose[$i];
                    $outcome = new BallotOutcomeModel();
                    $outcome->StudentVoted = Auth::user()->{Auth::getPKUser()};
                    $outcome->VotedID = $this->firstParam();
                    $outcome->CourseID = $course;
                    if (! $outcome->save()) {
                        $flag = false;
                        break;
                    }
                }
            }

            if ($flag) {
                $this->setMessage("success", '', MessagesType::Success);
                $this->redirect("/student/ballot/{$this->firstParam()}");
            } else {
                $this->setMessage("danger", '', MessagesType::Danger);
            }

        }


        
        $this->authentication("student.ballot", [
            "vote" => $vote,
            "user" => $student,
            "courses" => $courses,
            "coursesIDs" => $coursesIDs,
            "coursesChosen" => $coursesChosen,
            "hoursChosen" => BallotOutcomeModel::totalHourChosen($student,  $this->firstParam()),
        ]);
    }
}