<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Cookie;
use App\Core\FilterInput;
use App\Enums\Language;
use App\Enums\Privilege;
use App\Models\Model;

class AjaxController extends AbstractController
{
    public static int $authentication = Privilege::Admin->value;

    /**
     * getAppLanguage() Method
     *
     * This method is responsible for determining the user's preferred language in the application.
     * It considers both user authentication status and language settings stored in cookies.
     * Based on these factors, the method returns a JSON-encoded response containing the name of the preferred language.
     *
     * @return void
     *
     * @link http://precatalog.local/ajax/getAppLanguage
     */
    public function getAppLanguage(): void
    {
        $langName = null;

        if (Auth::isLogged()) {
            if (Auth::user()->{LANGUAGE_NAME_COLUMNS_DB} === Language::Arabic->value) {
                $langName = Language::Arabic->name;
            } else {
                $langName = Language::English->name;
            }
        } elseif(Cookie::get("language")) {
            if (Cookie::get("language") === Language::Arabic->value) {
                $langName = Language::Arabic->name;
            } else {
                $langName = Language::English->name;
            }
        }
        if (self::$authentication === Auth::privilege()) {
            echo json_encode([
                "language" => $langName,
            ]);
        }

    }

    public function getStatisticsVote(): void
    {
        $id = FilterInput::int($_POST["id"]);

        $votesGuider = Model::execute(
            "
                SELECT
                        V.*, C.*, COUNT(BO.CourseID) AS VotedNumber
                FROM
                    BallotOutcome as BO
                INNER JOIN
                    Courses as C on C.CourseID = BO.CourseID
                INNER JOIN
                    Votes as V
                ON
                    V.VoteID = BO.VotedID 
                WHERE 
                    V.VoteID = {$id}
                GROUP BY 
                    BO.CourseID
                ORDER BY
                    VotedNumber;
            "
        , \PDO::FETCH_CLASS);

        echo  json_encode($votesGuider);
    }
}