<?php

namespace App\Models;

use App\Helper\HandsHelper;

trait OperationHandler
{
    use HandsHelper;

    /**
     * Increment value column defaukt
     *
     *
     * @param string $model
     * @param string $column
     * @param int|string $id
     * @param int|string $value
     * @return bool
     */
    public static function increment($model, $column, $id, $value='1'): bool
    {
        $class = new $model();
        $sql = "UPDATE " . $class::getTableName() . " SET {$column} = {$column} + {$value} WHERE " . $class::getPK() . " = {$id}";
        $stmt = Model::prepare($sql);
        return $stmt->execute();
    }

    public static function decrement($model, $column, $id, $value='1'): bool
    {
        $class = new $model();
        $sql = "UPDATE " . $class::getTableName() . " SET {$column} = {$column} - {$value} WHERE " . $class::getPK() . " = {$id}";
        $stmt = Model::prepare($sql);
        return $stmt->execute();
    }
}