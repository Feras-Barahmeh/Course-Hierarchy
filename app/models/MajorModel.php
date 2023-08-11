<?php

namespace App\Models;

class MajorModel extends AbstractModel
{

    public $MajorID;
    public  $NumberHoursMajor;
    public  $NumberStudentInMajor;
    public  $CoursesNumber;
    public  $MajorDepartmentID;
    public  $MajorCollegeID;
    public  $MajorName;

    protected static string $tableName = "Majors";

    public static array $tableSchema = [
        "MajorID"   => self::DATA_TYPE_INT,
        "NumberHoursMajor"     => self::DATA_TYPE_INT,
        "CoursesNumber" => self::DATA_TYPE_INT,
        "MajorDepartmentID" => self::DATA_TYPE_INT,
        "MajorCollegeID" => self::DATA_TYPE_INT,
        "MajorName" => self::DATA_TYPE_STR,
    ];
    protected static array $Unique = [
        "DepartmentName",
    ];
    protected static string $primaryKey = "MajorID";

}