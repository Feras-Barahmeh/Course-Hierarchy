<?php

namespace App\Models;

use Cassandra\Date;

class StudentModel extends AbstractModel
{
    public $StudentID;
    public  $NumberHoursSuccess;
    public  $AdmissionYear;
    public  $FirstName;
    public  $LastName;
    public  $DOB;
    public  $Gender;
    public  $Address;
    public  $Email;
    public  $PhoneNumber;
    public  $Privilege;
    public  $Password;
    public  $language;

    protected static string $tableName = "Students";

    protected static array $tableSchema = [
        "StudentID"             => self::DATA_TYPE_INT,
        "NumberHoursSuccess"    => self::DATA_TYPE_INT,
        "AdmissionYear"         => self::DATA_TYPE_INT,
        "FirstName"             => self::DATA_TYPE_STR,
        "LastName"              => self::DATA_TYPE_STR,
        "DOB"                   => self::DATA_TYPE_DATE,
        "Gender"                => self::DATA_TYPE_STR,
        "Address"               => self::DATA_TYPE_STR,
        "Email"                 => self::DATA_TYPE_STR,
        "PhoneNumber"           => self::DATA_TYPE_STR,
        "Privilege"             => self::DATA_TYPE_INT,
        "Password"             => self::DATA_TYPE_STR,
        "language"             => self::DATA_TYPE_INT,
    ];

    protected static string $primaryKey = "StudentID";
}