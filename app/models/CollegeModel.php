<?php

namespace App\Models;

class CollegeModel extends AbstractModel
{
    public $CollegeID;
    public  $CollegeName;
    public  $TotalStudentsInCollege;

    protected static string $tableName = "Colleges";

    protected static array $tableSchema = [
        "CollegeID"             => self::DATA_TYPE_INT,
        "CollegeName"    => self::DATA_TYPE_STR,
        "TotalStudentsInCollege"         => self::DATA_TYPE_INT,
    ];

    protected static string $primaryKey = "CollegeID";

    public static function increasingStudent($idCollege): bool
    {
        $sql = "UPDATE " . self::$tableName . " SET TotalStudentsInCollege = TotalStudentsInCollege + 1 WHERE " . self::$primaryKey . " = {$idCollege}";
        $stmt = self::prepare($sql);
        return $stmt->execute();
    }
    public static function decreasingStudent($idCollege): bool
    {
        $sql = "UPDATE " . self::$tableName . " SET TotalStudentsInCollege = TotalStudentsInCollege - 1 WHERE " . self::$primaryKey . " = {$idCollege}";
        $stmt = self::prepare($sql);
        return $stmt->execute();
    }
}