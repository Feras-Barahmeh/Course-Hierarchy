<?php

namespace App\Models;



class AdminModel extends AbstractModel
{

    public $AdminID;
    public  $Email;
    public  $Password;
    public  $Privilege;
    public  $Name;


    protected static string $tableName = "Admin";

    protected static array $tableSchema = [
        "AdminID"   => self::DATA_TYPE_INT,
        "Email"     => self::DATA_TYPE_STR,
        "Name"      => self::DATA_TYPE_STR,
        "Password"  => self::DATA_TYPE_STR,
        "Privilege" => self::DATA_TYPE_INT,
    ];

    protected static string $primaryKey = "AdminID";
}