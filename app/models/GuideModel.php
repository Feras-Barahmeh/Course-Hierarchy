<?php

namespace App\Models;

class GuideModel extends AbstractModel
{
    public $GuideID;
    public  $GuideName;
    public  $Email;
    public  $PhoneNumber;
    public  $Privilege;
    public  $Password;
    public  $YearsOfExperience;
    public  $OfficeHours;
    public  $GuideDepartmentID;
    public  $language;

    protected static string $tableName = "Guides";

    protected static array $tableSchema = [
        "GuideID"               => self::DATA_TYPE_INT,
        "GuideName"             => self::DATA_TYPE_STR,
        "Email"                 => self::DATA_TYPE_STR,
        "PhoneNumber"           => self::DATA_TYPE_STR,
        "Password"              => self::DATA_TYPE_STR,
        "Privilege"             => self::DATA_TYPE_INT,
        "YearsOfExperience"     => self::DATA_TYPE_INT,
        "OfficeHours"           => self::DATA_TYPE_STR,
        "GuideDepartmentID"     => self::DATA_TYPE_INT,
    ];

    protected static string $primaryKey = "GuideID";
}