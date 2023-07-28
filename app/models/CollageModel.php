<?php

namespace App\Models;

use App\Helper\HandsHelper;

class CollageModel extends AbstractModel
{
    use HandsHelper;
    public $CollageID;
    public  $CollegeName;
    public  $TotalStudents;


    protected static string $tableName = "Collages";

    protected static array $tableSchema = [
        "CollageID"             => self::DATA_TYPE_INT,
        "CollegeName"    => self::DATA_TYPE_STR,
        "TotalStudents"         => self::DATA_TYPE_INT,
    ];

    protected static string $primaryKey = "CollageID";

    public static function filterTable($filterValues)
    {
        $sql = "
            SELECT * FROM " . static::$tableName . " WHERE  
        ";

        if (! is_array($filterValues)) {
            foreach (static::$tableSchema as $column => $type) {
                $sql .= " $column " . " LIKE '%". $filterValues ."%' OR \n " ;
            }

            (new CollageModel())->removeLastWord($sql);
            return $sql;
        }

    }
}