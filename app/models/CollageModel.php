<?php

namespace App\Models;

class CollageModel extends AbstractModel
{
    public $CollageID;
    public  $CollegeName;
    public  $TotalStudents;


    protected static string $tableName = "Collages";

    protected static array $tableSchema = [
        "CollageID"             => self::DATA_TYPE_INT,
        "CollegeName"    => self::DATA_TYPE_STR,
        "TotalStudents"         => self::DATA_TYPE_INT,
    ];

    protected static string $primaryKey = "CollageID";
}