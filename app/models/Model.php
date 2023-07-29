<?php

namespace App\Models;

use App\Core\Database\DatabaseHandler;

/**
 * Model Class Contain static method help you do action whit DB
 */
class Model
{
    /**
     * @param $query string the query you want execute
     * @return mixed
     */
    public static function execute(string $query): mixed
    {
        $stmt = DatabaseHandler::factory()->prepare($query);
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        }
        return false;
    }
}