<?php

namespace App\Models;

class VoteModel extends AbstractModel
{
    public $VoteID;
    public  $StudentID;
    public  $CourseID;

    protected static string $tableName = "Votes";

    protected static array $tableSchema = [
        "AdminID"   => self::DATA_TYPE_INT,
        "StudentID" => self::DATA_TYPE_INT,
        "CourseID"  => self::DATA_TYPE_INT,
    ];

    protected static string $primaryKey = "VoteID";
}