<?php

namespace App\Models;

use App\Core\Database\DatabaseHandler;

/**
 * Model Class Contain static method help you do action whit DB
 */
class Model
{
    /**
     * prepare sql query
     * @param $sql
     * @return mixed
     */
    private static function prepare(&$sql): mixed
    {
        return DatabaseHandler::factory()->prepare($sql);
    }
    /**
     * @param $query string the query you want execute
     * @return
     */
    public static function execute(string $query)
    {
        $stmt = self::prepare($query);
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        }
        return false;
    }

    /**
     * return count column from table
     * @param string $column name column you want count
     * @param string $table name table contain this column
     * @return false|int return count columns
     * @version 1.0
     * @author Feras Barahemeh
     */
    public static function enumerate(string $column, string $table): false|int
    {
        $sql = "
            SELECT 
                COUNT(" . $colum . ") AS count
            FROM 
                " . $table ."
        ";

        $stmt = self::prepare($sql);
        if ($stmt->execute()) {
            return $stmt->fetch()["count"];
        }
        return false;
    }


    /**
     * return count column from table
     * @param string $table name table contain this column
     * @param string $column name column you want count
     * @param $value
     * @return bool return true if equal false otherwise
     * @version 1.0
     * @author Feras Barahemeh
     */
    public static function equal(string $table, string $column, $value): bool
    {
        $sql = "
            SELECT 
                *
            FROM 
                " . $table ."
            WHERE
                $column = '$value'
        ";


        $stmt = self::prepare($sql);
        if ($stmt->execute()) {
            return  $stmt->rowCount();
        }
        return false;
    }
}