<?php
namespace App\Models;


use App\Core\Database\DatabaseHandler;
use Exception;
use PDOException;

class AbstractModel
{
    const DATA_TYPE_BOOL = \PDO::PARAM_BOOL;
    const DATA_TYPE_INT = \PDO::PARAM_INT;
    const DATA_TYPE_STR = \PDO::PARAM_STR;
    const DATA_TYPE_DECIMAL = 4;
    const DATA_TYPE_DATE = 5;

    private function bindParams(\PDOStatement &$stmt): void
    {
        foreach (static::$tableSchema as $columnName => $type)
        {
            if ($type != 4)
            {
                $stmt->bindValue(":{$columnName}", $this->$columnName, $type);
            }
            else
            {
                $sanitize = filter_var($this->$columnName, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $stmt->bindValue(":{$columnName}", $sanitize);
            }
        }
    }

    private static function buildNameParamSQL(): string
    {
        $query  = '';
        foreach (static::$tableSchema as $columnName => $type) {
            $query .= $columnName . " = :" . $columnName .  ", ";
        }

        return trim($query, ", ");
    }
    private function insert(): bool
    {
        $query = "INSERT INTO " . static::$tableName . " SET " . self::buildNameParamSQL() ;
        $stmt = DatabaseHandler::factory()->prepare($query);
        $this->bindParams($stmt);

        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        if ($stmt->execute()) {
            $this->{static::$primaryKey} = DatabaseHandler::lastRecord();
            return true;
        }

        return false;
    }
    private function update()
    {
        $query = "UPDATE " . static::$tableName . " SET " . self::buildNameParamSQL() . " WHERE " . static::$primaryKey . " = " . $this->{static::$primaryKey} ;
        $stmt = DatabaseHandler::factory()->prepare($query);
        $this->bindParams($stmt);
        return $stmt->execute();
    }
    public function delete()
    {
        $query = "DELETE FROM " . static::$tableName . " WHERE " . static::$primaryKey . " = " . $this->{static::$primaryKey} ;
        $stmt = DatabaseHandler::factory()->prepare($query);
        return $stmt->execute();
    }

    /**
     * Save the current model instance to the database.
     *
     * This method is used to save the current model instance to the database. By default, it performs an
     * insert operation, but it can also be used to update an existing record in the database if the model
     * already has a primary key set.
     *
     * @param bool $isSubProcess (optional) Set this parameter to true if you want to use the 'save' method
     *                          to save a subset of data from another model (e.g., User Model and Subset Info user Model).
     *                          Make sure to manually set the primary key in such cases. Default is true.
     *
     * @return bool Returns true on successful save, false otherwise.
     */
    public function save(bool $isSubProcess=true): bool
    {
        if (! $isSubProcess) {
            return $this->insert();
        }
        if ($this->{static::$primaryKey} === null) {
            return $this->insert();
        } else {
            return $this->update();
        }
    }


    public static function all(): bool|\ArrayIterator
    {
        $query = "SELECT * FROM " . static::$tableName;
        $stmt = DatabaseHandler::factory()->prepare($query);
        $stmt->execute();


        if (method_exists(get_called_class(), "__construct")) {
            $results = $stmt->fetchAll(
                \PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE,
                get_called_class(),
                array_keys(static::$tableSchema)
            );
        }
        else {
            $results = $stmt->fetchAll(\PDO::FETCH_CLASS , get_called_class());
        }


        if ((is_array($results) && !empty($results)))  {
            return new \ArrayIterator($results);
        }

        return false;
    }

    /**
     * get record by ket Primary key
     * @param $pk
     * @return AbstractModel|bool
     */
    public static function getByPK($pk): static|bool
    {
        $query = "SELECT * FROM " . static::$tableName . " WHERE " . static::$primaryKey . " = '" . $pk . "'";

        $stmt = DatabaseHandler::factory()->prepare($query);

        if ($stmt->execute() === true)
        {
            if (method_exists(get_called_class(), "__construct")) {
                $results = $stmt->fetchAll(
                    \PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE,
                    get_called_class(),
                    array_keys(static::$tableSchema)
                );
            }
            else {
                $results = $stmt->fetchAll(\PDO::FETCH_CLASS , get_called_class());
            }

            return !empty($results) ? array_shift($results) : false ;
        }
        return false;
    }

    public static function get($query, $options=[]): false|\ArrayIterator
    {
        $stmt = DatabaseHandler::factory()->prepare($query);
        $stmt->execute();
        if(method_exists(get_called_class(), '__construct')) {
            $results = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class(), array_keys(static::$tableSchema));
        } else {
            $results = $stmt->fetchAll(\PDO::FETCH_CLASS, get_called_class());
        }

        if ((is_array($results) && !empty($results))) {
            return new \ArrayIterator($results);
        }
        return false;
    }

    public static function row($sql)
    {
        $row = static::get($sql);
        return ! $row ? 0 : $row->current();
    }

    /**
     * @return mixed
     */
    public static function getTableName(): mixed
    {
        return static::$tableName;
    }

    /**
     * @return mixed
     */
    public static function getPK(): mixed
    {
        return static::$primaryKey;
    }
    /**
     * @return mixed
     */
    public static function getTableSchema(): mixed
    {
        return static::$tableSchema;
    }

    /**
     * Method to check if value exist in db or not get column and value this column
     * @author Feras Barahmeh
     * @version 1.0.0
     *
     * @param string|null $column select the column you want count
     * @param string $value value column you want search it
     * @return false|\ArrayIterator false if value not exist and values to this column otherwise
     *
     */
    public static function countRow(string|null $column, string $value): false|\ArrayIterator
    {
        $calledClass = get_called_class();
        return (new $calledClass)->get("SELECT " . $column . " FROM " . static::$tableName . " WHERE " . $column . " = '$value'");

    }
    public function allLazy(array $options = null): \Generator
    {
        $query = "SELECT * FROM " . static::$tableName;
        if ($options != null) {
            foreach ($options as $key => $val) {
                $query .= " " . $key . " " . $val;
            }
        }

        $records = $this->get($query);
        if ($records) {
            foreach ($records as $record) {
                yield $record;
            }
        }

    }
    /**
     * Count the number of records in the database table associated with the current model.
     *
     * This static method is used to count the number of records in the database table associated
     * with the current model. It executes a SQL query to fetch the count and returns the result.
     * The table name and primary key column are obtained from the static properties $tableName and
     * $primaryKey defined in the derived class.
     *
     * @return mixed Returns the count of records as an integer, or null if the query fails.
     * @version 1.0
     * @author Feras Barahemeh
     */
    public static function enumerate(): mixed
    {
        $sql = "
            SELECT 
                COUNT(" . static::$primaryKey . ") AS count
            FROM 
                " . static::$tableName ."
        ";

        return (new AbstractModel)->row($sql)->count;
    }
    /**
     * Check if a value exists in any of the specified columns of the database table associated with the current model.
     *
     * This static method checks whether a given value exists in any of the specified columns of the database table
     * associated with the current model. It executes a series of SQL queries for each column defined in the static
     * property $Unique to determine if the value is present in any of those columns. The table name is obtained from
     * the static property $tableName defined in the derived class.
     *
     * @param mixed $value The value to be checked for existence in the specified columns.
     *                     If the $Unique property has multiple columns, the value should be an array with the same
     *                     number of elements, or a single value if $Unique has only one column.
     *
     * @return bool|string Returns false if the value is not found in any of the specified columns. If the value is
     *                     found in a specific column, the name of that column (string) is returned. If the value is
     *                     found in multiple columns, the method will return the name of the first column where the
     *                     value is found. If the query fails, it returns true.
     */
    public static function existsInTable(mixed $value ): bool|string
    {
        if (! is_array($value) && count(static::$Unique) > 1) $value = [$value];

       foreach (static::$Unique as $column) {
           $sql = "
                SELECT 
                    COUNT(".$column.") AS count
                FROM 
                    " . static::$tableName ."
                WHERE
                    {$column} = '$value'
           ";

           if (Model::execute($sql)[0]["count"] >= 1) {
               return  $column;
           }
       }
        
        return  true;
    }

    /**
     * Get the column names of the table associated with the current model.
     *
     * This method retrieves and returns an array containing the column names of the database table
     * associated with the current model. The table schema is determined based on the static property
     * $tableSchema, which should be defined in the derived class.
     *
     * @return array Returns an array of strings representing the column names of the associated table.
     */
    public function getColumns(): array
    {
        return array_keys(static::$tableSchema);
    }

}