<?php

namespace App\Models;



use App\Core\Auth;

class StudentModel extends AbstractModel
{
    public $StudentID;
    public  $StudentYear;
    public  $FirstName;
    public  $LastName;
    public  $Gender;
    public  $Address;
    public  $Email;
    public  $PhoneNumber;
    public  $Privilege;
    public  $Password;
    public  $language;
    public  $StudentDepartmentID;
    public  $StudentMajor;
    public  $StudentCollegeID;
    protected static string $tableName = "Students";

    protected static array $tableSchema = [
        "StudentID"            => self::DATA_TYPE_INT,
        "StudentYear"          => self::DATA_TYPE_STR,
        "FirstName"            => self::DATA_TYPE_STR,
        "LastName"             => self::DATA_TYPE_STR,
        "Gender"               => self::DATA_TYPE_STR,
        "Address"              => self::DATA_TYPE_STR,
        "Email"                => self::DATA_TYPE_STR,
        "PhoneNumber"          => self::DATA_TYPE_STR,
        "Privilege"            => self::DATA_TYPE_INT,
        "Password"             => self::DATA_TYPE_STR,
        "StudentDepartmentID"  => self::DATA_TYPE_INT,
        "StudentMajor"         => self::DATA_TYPE_INT,
        "StudentCollegeID"         => self::DATA_TYPE_INT,
    ];

    protected static string $primaryKey = "StudentID";

    public static function getStudent()
    {
        return Model::execute("SELECT * FROM " . StudentModel::getTableName() . " JOIN " .
            " Majors ON StudentMajor = " . MajorModel::getPK() .
            " WHERE StudentID = " . Auth::user()->StudentID
            ,\PDO::FETCH_CLASS)[0];
    }
}