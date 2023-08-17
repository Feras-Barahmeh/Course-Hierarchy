<?php

namespace App\Models;

class CourseModel extends AbstractModel
{

    public $CourseID;
    public  $CourseName;
    public  $Year;
    public  $CourseMajorID;


    protected static string $tableName = "Courses";

    protected static array $tableSchema = [
        "CourseID"              => self::DATA_TYPE_INT,
        "CourseName"            => self::DATA_TYPE_STR,
        "Year"                  => self::DATA_TYPE_STR,
        "CourseMajorID"         => self::DATA_TYPE_INT,
    ];

    protected static string $primaryKey = "CourseID";
}