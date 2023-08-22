<?php

namespace App\Models;

class VoteModel extends AbstractModel
{
    public $VoteID;
    public  $Title;
    public  $ForYear;
    public  $ForMajor;
    public  $ForDepartment;
    public  $IsActive;
    public  $AddedBy;
    public  $TimeShare;

    protected static string $tableName = "Votes";

    protected static array $tableSchema = [
        "VoteID"   => self::DATA_TYPE_INT,
        "Title"     => self::DATA_TYPE_STR,
        "ForYear"   => self::DATA_TYPE_STR,
        "ForMajor"  => self::DATA_TYPE_INT,
        "ForDepartment"  => self::DATA_TYPE_INT,
        "AddedBy"  => self::DATA_TYPE_INT,
    ];

    protected static string $primaryKey = "VoteID";
}