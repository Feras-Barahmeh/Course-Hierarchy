<?php

namespace App\Models;

class VoteModel extends AbstractModel
{
    public $VoteID;
    public  $Title;
    public  $ForYear;
    public  $ForMajor;
    public  $ForDepartment;

    protected static string $tableName = "Votes";

    protected static array $tableSchema = [
        "VoteID"   => self::DATA_TYPE_INT,
        "Title"     => self::DATA_TYPE_STR,
        "ForYear"   => self::DATA_TYPE_STR,
        "ForMajor"  => self::DATA_TYPE_INT,
        "ForDepartment"  => self::DATA_TYPE_INT,
    ];

    protected static string $primaryKey = "VoteID";
}