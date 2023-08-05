<?php

namespace App\Models;

use App\Helper\HandsHelper;

class CollegeModel extends AbstractModel
{
    use HandsHelper;
    public $CollegeID;
    public  $CollegeName;
    public  $TotalStudents;


    protected static string $tableName = "Colleges";

    protected static array $tableSchema = [
        "CollegeID"             => self::DATA_TYPE_INT,
        "CollegeName"    => self::DATA_TYPE_STR,
        "TotalStudents"         => self::DATA_TYPE_INT,
    ];

    protected static string $primaryKey = "CollegeID";

}