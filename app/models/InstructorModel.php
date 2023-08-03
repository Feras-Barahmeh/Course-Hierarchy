<?php

namespace App\Models;



class InstructorModel extends AbstractModel
{

        public $InstructorID;
    public  $FirstName;
    public  $LastName;
    public  $Department;
    public  $Email;
    public  $PhoneNumber;
    public  $Address;
    public  $City;
    public  $State;
    public  $Country;
    public  $DOB;
    public  $HireDate;
    public  $Salary;
    public  $YearsOfExperience;
    public  $IfFullTime;
    public  $IsActive;
    public  $privilege;
    public  $Password;
    public  $NationalIdentificationNumber;


    protected static string $tableName = "Instructors";

    protected static array $tableSchema = [
        "InstructorID"                  => self::DATA_TYPE_INT,
        "FirstName"                     => self::DATA_TYPE_STR,
        "LastName"                      => self::DATA_TYPE_STR,
        "Department"                    => self::DATA_TYPE_INT,
        "Email"                         => self::DATA_TYPE_STR,
        "PhoneNumber"                   => self::DATA_TYPE_STR,
        "City"                          => self::DATA_TYPE_STR,
        "State"                         => self::DATA_TYPE_STR,
        "Country"                       => self::DATA_TYPE_STR,
        "DOB"                           => self::DATA_TYPE_DATE,
        "HireDate"                      => self::DATA_TYPE_DATE,
        "Salary"                        => self::DATA_TYPE_DECIMAL,
        "YearsOfExperience"             => self::DATA_TYPE_INT,
        "IfFullTime"                    => self::DATA_TYPE_INT,
        "IsActive"                      => self::DATA_TYPE_INT,
        "privilege"                     => self::DATA_TYPE_INT,
        "Password"                      => self::DATA_TYPE_STR,
        "NationalIdentificationNumber"  => self::DATA_TYPE_INT,
    ];
    protected static array $Unique = [
        "Email",
    ];
    protected static string $primaryKey = "InstructorID";

}