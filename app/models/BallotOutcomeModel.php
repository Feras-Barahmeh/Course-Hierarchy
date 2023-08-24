<?php

namespace App\Models;

class BallotOutcomeModel extends AbstractModel
{
    public $BallotID;
    public  $StudentVoted;
    public  $VotedID;
    public  $CourseID;

    protected static string $tableName = "BallotOutcome";

    protected static array $tableSchema = [
        "BallotID"      => self::DATA_TYPE_INT,
        "StudentVoted"  => self::DATA_TYPE_INT,
        "VotedID"       => self::DATA_TYPE_INT,
        "CourseID"       => self::DATA_TYPE_INT,

    ];

    protected static string $primaryKey = "BallotID";

    public static function getChosenCourses($student): false|array
    {
        return Model::execute(
            "
                SELECT * FROM " . BallotOutcomeModel::getTableName() . "
              JOIN " . CourseModel::getTableName() . " ON " . BallotOutcomeModel::getTableName() . ".CourseID = " . CourseModel::getTableName() . "." . CourseModel::getPK() . "
                  WHERE StudentVoted = " . $student->StudentID, \PDO::FETCH_CLASS);
    }

    public static function totalHourChosen($student): string|int|null
    {
        return Model::execute(
            "
                SELECT Sum(NumberHourCourse) as hoursChosen FROM " . BallotOutcomeModel::getTableName() . "
                  JOIN " . CourseModel::getTableName() . " ON " . BallotOutcomeModel::getTableName() . ".CourseID = " . CourseModel::getTableName() . "." . CourseModel::getPK() . "
                  WHERE StudentVoted = " . $student->StudentID, \PDO::FETCH_CLASS)[0]->hoursChosen;
    }
    public static function deleteBallotStudent($studentID, $votedID): bool
    {
        $sql = "DELETE FROM " . BallotOutcomeModel::getTableName() . " WHERE " . "StudentVoted" . " = " . $studentID . " AND VotedID = '$votedID'";

        $stmt = self::prepare($sql);
        return $stmt->execute();
    }
}