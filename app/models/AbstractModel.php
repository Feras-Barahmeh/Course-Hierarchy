<?php
namespace App\Models;


use App\Core\Database\DatabaseHandler;
use App\Helper\HandsHelper;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use PDOException;

class AbstractModel
{
    use HandsHelper;
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

    /**
     * Add JOIN clauses to the database query.
     *
     * This private static method is used to add JOIN clauses to the provided database query object based on the
     * given options array. The method checks if a "join" option is present in the $options array. If the "join"
     * option is found, the method iterates through the specified JOIN tables and conditions and appends the JOIN
     * clauses to the $query string. The "join" option array should be in the following structure:
     *
     * Example of the "join" option array structure:
     * [
     *     "join" => [
     *         "categories" => [
     *             "type" => "INNER", // Use INNER, LEFT, RIGHT, etc. for different join types
     *             "on" => "products.category_id = categories.id"
     *         ],
     *         // Add more join conditions here if needed
     *     ]
     * ]
     *
     * The "join" option allows customizing the database query with different types of joins and specifying the
     * join conditions to link related tables in the query.
     *
     * @param string $query The database query object to which the JOIN clauses will be added. This object is modified
     *                     by reference.
     * @param array $options An associative array containing the options for customizing the database query.
     *
     * @return void
     */
    private static function addJoinOptionToQuery(string &$query, array $options): void
    {
        if (isset($options["join"])) {
            $joins = $options["join"];

            foreach ($joins as $table => $joinCondition) {
                $joinCondition['type'] = $joinCondition['type'] ?? '';
                $query .= " {$joinCondition['type']} JOIN {$table} ON {$joinCondition['on']} ";
            }
        }
    }
    /**
     * Add ordering to the database query.
     *
     * This private static method is used to add ordering to the provided database query object based on the
     * given options array. The method checks if an "order" option is present in the $options array or if the
     * value "order" exists in the array. If either condition is true, the method extracts the "type" and "column"
     * values from the "order" option or uses default values if they are not provided. It then appends the ORDER BY
     * clause to the $query string using the extracted values, ordering the results based on the specified column
     * and type (ASC ending or DESC ending).
     *  Example of the "order" option array structure:
     *  [
     *     "order" => [
     *         "column" => "nameColumn", // Replace "nameColumn" with the desired column name for ordering (default: primary key)
     *         "type" => "DESC" // Use "DESC" for descending order (default), or "ASC" for ascending order
     *     ]
     *  ]
     * @param mixed $query The database query object to which the ordering will be added. This object is modified
     *                     by reference.
     * @param array $options An associative array containing the options for customizing the database query.
     *
     * @return void
     */
    private static function addOrderToQuery(mixed &$query, array $options): void
    {
        if (isset($options["order"]) || in_array( "order", array_values($options))) {
            
            $type = $options["order"]["type"] ?? "DESC";
            $column = $options["order"]["column"] ?? static::getPK();

            $query .= " ORDER BY {$column} {$type} ";
        }
    }
    /**
     * Add options to the database query.
     *
     * This private static method is used to add options to the provided database query object based on the
     * given options array. The method calls other private static methods, such as `addJoinOptionToQuery()` and
     * `addOrderToQuery()`, to handle specific options. These options are typically used to customize the database
     * query, such as adding join clauses or specifying the order of the results.
     *
     * @param mixed $query The database query object to which the options will be added. This object is modified
     *                     by reference.
     * @param array $options An associative array containing the options for customizing the database query.
     *
     * @return void
     */
    private static function addOptionsToQuery(mixed &$query, array $options): void
    {
        self::addJoinOptionToQuery($query, $options);
        self::addOrderToQuery($query, $options);
    }
    public static function get($query, $options=[]): false|\ArrayIterator
    {
        self::addOptionsToQuery($query, $options);
        
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
    /**
     * Execute a database query with options and return the results as objects.
     *
     * This public static method is used to execute a database query with optional customizations
     * based on the provided options. It takes two parameters: `$options` and `$query`. The `$options`
     * parameter is an associative array containing options to customize the database query, such as
     * filtering, ordering, and joining. The `$query` parameter is an optional SQL query string, and if
     * not provided, a default SELECT query for the corresponding table is used. The method then calls
     * `addOptionsToQuery()` to add the specified options to the query and prepares the query using the
     * PDO interface. Finally, the method executes the query and returns the results as an array of objects,
     * where each object represents a row from the result set.
     *
     * @param array $options An associative array containing options for customizing the database query.
     * @param string $query (Optional) The SQL query string to be executed. If not provided, a default
     *                      SELECT query for the corresponding table is used.
     *
     * @return array Returns an array of objects representing the result set of the executed query.
     */
    public static function execute(array $options, string $query=''): array
    {
        $query = ($query == '') ? "SELECT ". static::getTableName(). ".* FROM " . static::getTableName() : $query;
        self::addOptionsToQuery($query, $options);

        $stmt = DatabaseHandler::factory()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS);
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
    public static function getLazy(array $options = null): \Generator
    {
        $query = "SELECT * FROM " . static::$tableName;
        $records = self::get($query, $options);
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

    /**
     * @param $filterValues
     * @param $sql
     * @return mixed|string|void
     * @deprecated new version is search method
     */
    public static function filterTable($filterValues, $sql=null)
    {
        $sql = $sql == null ? "
            SELECT * FROM " . static::$tableName . " WHERE  
        " : $sql;

        if (! is_array($filterValues)) {
            foreach (static::$tableSchema as $column => $type) {
                $sql .= " $column " . " LIKE '%". $filterValues ."%' OR \n " ;
            }

            self::removeLastWord($sql);
            return $sql;
        }
    }

    /**
     * Perform a search query with filter values and optional customizations.
     *
     * This public static method is used to perform a search query on the database table. It takes two parameters:
     * `$filterValues` and `$options`. The `$filterValues` parameter can either be a single string or an array of filter
     * values to search for in the database. The `$options` parameter is an associative array containing options for
     * customizing the search query, such as filtering, ordering, and joining.
     *
     * If `$filterValues` is a single string, the method constructs a search query using the LIKE operator to search for
     * the specified value in all columns of the table. If `$filterValues` is an array, the method will not execute the
     * query but will return the constructed SQL query string that can be executed later.
     *
     * Example of the `$options` array:
     * [
     *     "order" => [
     *         "column" => "nameColumn", // Replace "nameColumn" with the desired column name for ordering (default: primary key)
     *         "type" => "DESC" // Use "DESC" for descending order (default), or "ASC" for ascending order
     *     ],
     *     "join" => [
     *         "table name" => [
     *             "type" => "INNER", // Use INNER, LEFT, RIGHT, etc. for different join types
     *             "on" => "products.category_id = categories.id"
     *         ],
     *         // Add more join conditions here if needed
     *     ]
     *     // Add more options here if needed
     * ]
     *
     * @param mixed $filterValues The value or array of values to search for in the database table
     *
     * @return string|null If `$filterValues` is a single string, the method will not execute the query but will return
     *                      the constructed SQL query string. If `$filterValues` is an array, the method returns null.
     */
    public static function customSearchQuery(mixed $filterValues): ?string
    {
        $sql = '';
        if (! is_array($filterValues)) {
            $sql .= " WHERE ";
            foreach (static::$tableSchema as $column => $type) {
                $sql .= " " . static::getTableName() . ".$column " . " LIKE '%". $filterValues ."%' OR \n " ;
            }

            self::removeLastWord($sql);
            return $sql;
        }
        return  $sql;
    }
}