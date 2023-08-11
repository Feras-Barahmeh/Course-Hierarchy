<?php

namespace App\Models;

class DepartmentModel extends AbstractModel
{

    public $DepartmentID;
    public  $DepartmentName;
    public  $TotalStudentsInDepartment;
    public  $CollegeID;

    protected static string $tableName = "Departments";

    public static array $tableSchema = [
        "DepartmentID"   => self::DATA_TYPE_INT,
        "DepartmentName"     => self::DATA_TYPE_STR,
        "CollegeID" => self::DATA_TYPE_INT,
    ];
    protected static array $Unique = [
        "DepartmentName",
    ];
    protected static string $primaryKey = "DepartmentID";

}