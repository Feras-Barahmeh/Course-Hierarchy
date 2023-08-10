<?php
namespace App\Models;


use App\Core\Database\DatabaseHandler;
use App\Helper\HandsHelper;
use ArrayIterator;
use PDOStatement;

class AbstractModel
{
    use HandsHelper;
    const DATA_TYPE_BOOL = \PDO::PARAM_BOOL;
    const DATA_TYPE_INT = \PDO::PARAM_INT;
    const DATA_TYPE_STR = \PDO::PARAM_STR;
    const DATA_TYPE_DECIMAL = 4;
    const DATA_TYPE_DATE = 5;

    private function bindParams(PDOStatement &$stmt): void
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
    public static function lastRecord()
    {
        $sql = "SELECT LAST_INSERT_ID()";
        $stmt = self::prepare($sql);
        $stmt->execute();
        return $stmt->fetch()[0];
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
            $this->{static::$primaryKey} = self::lastRecord();
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
    /**
     * Prepare an SQL query for execution using the database handler.
     *
     * This private static method is used to prepare an SQL query for execution using the database handler from the
     * DatabaseHandler class. The method takes a single parameter: `$sql` (a reference to the SQL query).
     *
     * The method returns a prepared statement that can be executed to interact with the database.
     *
     * @param string $sql A reference to the SQL query to be prepared for execution.
     *
     * @return PDOStatement|false Returns a prepared statement for the SQL query, or false on failure.
     */
    protected static function prepare(string &$sql): mixed
    {
        return DatabaseHandler::factory()->prepare($sql);
    }

    public static function all(): bool|ArrayIterator
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
            return new ArrayIterator($results);
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
     * Append columns with aliases for selection in an SQL query based on provided options.
     *
     * This private static method is used to append columns with aliases for selection in an SQL query based on the provided
     * `$columns` array or string, and the main table name. The method takes three parameters: `$sql` (a reference to the SQL query),
     * `$table` (the name of the main table), and `$columns` (the columns to be selected with aliases).
     *
     * The method handles both string and array formats for specifying columns. If a string is provided, the method appends the column
     * with the specified alias to the SQL query. If an array of columns is provided, the method iterates through each column and
     * appends them to the SQL query with their respective aliases.
     *
     * The resulting SQL query includes the specified columns for selection, each with its assigned alias.
     *
     * @param string $sql A reference to the SQL query to which columns with aliases are appended for selection.
     * @param string $table The name of the main table.
     * @param string|array $columns The columns to be selected with aliases.
     *
     * @return void
     */
    private static function appendColumnsWithAliases(string &$sql, string $table, array|string $columns): void
    {

        if (is_string($columns)) {
            $sql .= $table . '.' . $columns . " AS {$columns}, ";
        }

        if (is_array($columns)) {
            foreach ($columns as $column) {
                $sql .= $table . '.' . $column . " AS {$column}, ";
            }
        }
        self::removeLastChar($sql);
    }

    /**
     * Set columns for selection in an SQL query based on provided options.
     *
     * This private static method is used to set columns for selection in an SQL query based on the provided `$options`
     * array, main table name, and joint table model. The method takes three parameters: `$sql` (a reference to the SQL query),
     * `$table` (the name of the main table), and `$JointModel` (the class representing the joint table model).
     *
     * The method checks if "columns" are specified in the `$options` array. If no columns are specified, it retrieves the columns
     * from the joint table's schema using the `$JointModel::getTableSchema()` method and adds them to the SQL query.
     *
     * If specific columns are provided in the "columns" option, the method adds those columns to the SQL query for selection.
     *
     * The resulting SQL query includes the specified columns for selection.
     *
     * @param string $sql A reference to the SQL query to which columns are added for selection.
     * @param string $table The name of the main table.
     * @param $JointModel
     * @return void
     */
    private static function setColumns(string &$sql, string $table, $JointModel): void
    {
        if (! isset($options["columns"])) {
            $columns = $JointModel::getTableSchema();
            self::appendColumnsWithAliases($sql, $table, $columns);
        } else {
            self::appendColumnsWithAliases($sql, $table, $options["columns"]);
        }
        $sql .= ' ';
    }
    /**
     * Set the join type and target joint table in an SQL query based on provided options.
     *
     * This private static method is used to set the join type and target joint table in an SQL query based on the provided `$options`
     * array and the class representing the joint table. The method takes three parameters: `$sql` (a reference to the SQL query),
     * `$options` (the array of join options), and `$jointTable` (the class representing the joint table).
     *
     * The method checks if a join type is specified in the `$options` array. If a join type is provided, it sets the specified join
     * type (INNER, LEFT, RIGHT, etc.) for the SQL query. If no join type is provided, the method sets the default join type to INNER.
     *
     * The method then appends the join type and the target joint table to the SQL query, completing the join clause for the specified table.
     *
     * @param string $sql A reference to the SQL query to which the join type and target joint table are added.
     * @param array $options An array of join options for constructing the SQL query.
     * @param string $jointTable The class representing the joint table.
     *
     * @return void
     */
    private static function setTypeJoin(string &$sql, array $options, string $jointTable): void
    {
        $type = $options["type"] ?? "INNER ";
        $sql .= " {$type} JOIN {$jointTable}s ";
    }
    /**
     * Set join conditions for a table in an SQL query based on provided options.
     *
     * This private static method is used to set join conditions for a table in an SQL query based on the provided `$condition`
     * array and the target joint table. The method takes three parameters: `$sql` (a reference to the SQL query), `$condition`
     * (the array of join conditions), and `$jointTable` (the class representing the joint table).
     *
     * The method checks if "on" conditions are specified in the `$condition` array. If "on" conditions are provided, the method
     * constructs the join conditions by iterating through each entry in the "on" array and generating equality conditions between
     * columns from the main table and the joint table.
     *
     * If no "on" conditions are provided, the method sets a default join condition based on the primary keys of both the main
     * table and the joint table.
     *
     * The resulting join conditions are appended to the SQL query, completing the join clause for the specified table.
     *
     * @param string $sql A reference to the SQL query to which join conditions are added.
     * @param array $condition An array of join conditions for constructing the SQL query.
     * @param string $jointTable The class representing the joint table.
     *
     * @return void
     */
    private static function setConditionJoin(string &$sql, array $condition, string $jointTable): void
    {
      
        $on = ' ';
        if (isset($condition["on"])) {

            $conditions = $condition["on"];
            foreach ($conditions as $leftColumn => $rightColumn) {
                $on .= static::getTableName() . ".{$leftColumn} = {$jointTable::getTableName()}.{$rightColumn} ";
            }
        } else {
            $on = static::getTableName() . '.' . $jointTable::getPK() . ' = ' . $jointTable::getTableName() . '.'. $jointTable::getPK();
        }

        $sql .= " ON {$on}";
    }
    /**
     * Add custom "WHERE" conditions to an SQL query based on provided options.
     *
     * This private static method is used to add custom "WHERE" conditions to an SQL query based on the provided `$where` array,
     * which contains user-defined conditions. The method takes two parameters: `$sql` (a reference to the SQL query) and
     * `$where` (the array of custom "WHERE" conditions).
     *
     * The method checks if there are "where" conditions specified in the `$where` array. If such conditions are present,
     * the method appends the provided custom "WHERE" conditions directly to the SQL query.
     *
     * @param string $sql A reference to the SQL query to which custom "WHERE" conditions are added.
     * @param array $where An array of user-defined "WHERE" conditions for constructing the SQL query.
     *
     * @return void
     */
    private static function addWhere(string &$sql, array $where): void
    {
        if (isset($where["where"])) {
            $sql .= $where["where"];
        }
        
    }
    /**
     * Add "LIKE" conditions to an SQL query based on provided table options.
     *
     * This private static method is used to add "LIKE" conditions to an SQL query based on the provided `$tables` array,
     * which contains join and filter options. The method takes two parameters: `$sql` (a reference to the SQL query) and
     * `$tables` (the array of table options).
     *
     * The method iterates through each entry in the `$tables` array and checks if there are "like" conditions specified for
     * any of the tables. If a "like" condition is found, the method appends "LIKE" conditions for each column in the table's
     * schema to the SQL query.
     *
     * If the SQL query does not end with the "WHERE" keyword, the method adds it before appending the "LIKE" conditions.
     *
     * @param string $sql A reference to the SQL query to which "LIKE" conditions are added.
     * @param array $tables An array of join and filter options for constructing the SQL query.
     *
     * @return void
     */
    private static function like(string &$sql, array $tables): void
    {
        $last = self::getLastWord($sql);
        if (strtolower($last) != "where" ) $sql .= " where ";

        foreach ($tables as $table => $options) {
            if (isset($options["like"])) {
                $value = $options["like"];
                foreach (static::$tableSchema as $column => $type) {
                    $sql .= " " . static::getTableName() . ".$column " . " LIKE '%". $value ."%' OR \n " ;
                }
            }
        }
        self::removeLastWord($sql);
    }
    /**
     * Create a custom SQL query with join clauses based on provided join options.
     *
     * This method generates a custom SQL query with join clauses based on the provided `$joins` array. The method takes one parameter:
     * `$joins`, which is an array containing join and filter options for constructing the query.
     *
     * The method starts by initializing an SQL string with the "SELECT" keyword and columns from the main table of the model.
     * It then iterates through each entry in the `$joins` array, adding join clauses, join type, and condition clauses based on the
     * options provided for each table.
     *
     * For each table to be joined, the method sets the appropriate columns for the joined table and adds the table to the SQL query.
     * It also sets the join type (INNER, LEFT, RIGHT, etc.) based on the provided options and adds the join condition clause.
     *
     * The resulting SQL query includes join clauses for multiple tables, each with its join type and condition.
     *
     * @param array $joins An array of join and filter options for constructing the custom SQL query.
     *
     * @return string The generated SQL query string with join clauses based on the provided join options.
     */
    public static function createJoin(array $joins): string
    {
        $sql = "SELECT ";

        self::setColumns($sql, static::$tableName, static::class);
        $sql .= ', ';

        foreach ($joins as $table => $options) {

            $table = is_string($options) ? $options : $table;

            $model =  "App\Models\\".$table . "Model";

            self::setColumns($sql, $table.'s', $model);

            $sql .= " FROM " . static::getTableName() . ' ';
            self::setTypeJoin($sql, $options, $table);

            self::setConditionJoin($sql, $options, $model);
        
        }
        
        return $sql;
    }

    /**
     * Fetch records from the main table without joins based on provided options.
     *
     * This private static method is used to fetch records from the main table of the model when no join options are provided.
     * The method takes one parameter: `$joins`, which is an array of options for constructing the fetch query.
     *
     * If no `$joins` array is provided, the method uses the `all()` method to fetch all records from the main table.
     * If the `$joins` array is provided and contains a "like" key, the method constructs a custom SQL query with a "LIKE"
     * condition for each column in the main table. This allows fetching records based on a search value using the "LIKE" operation.
     *
     * @param array|null $joins An array of options for constructing the fetch query. If provided and contains a "like" key,
     *                          a custom SQL query will be constructed for performing a search operation.
     *
     * @return bool|array|ArrayIterator An array of objects representing the fetched records from the main table of the model.
     */
    private static function fetchWithoutJoin(?array $joins): bool|array|ArrayIterator
    {

        if (isset($joins["like"])) {
            $sql = "SELECT * FROM " . static::getTableName() . " WHERE ";
            $value = $joins["like"];

            foreach (static::$tableSchema as $column => $type) {
                $sql .= " " . static::getTableName() . ".$column " . " LIKE '%". $value ."%' OR \n " ;
            }

            self::removeLastWord($sql);
            return static::get($sql);
        }
        return  !$joins ?? static::all();
    }

    /**
     * Fetch records from the database based on provided options.
     *
     * This method allows fetching records from the database based on the given options. The method takes two parameters:
     * `$pure` and `$joins`. The `$pure` parameter controls whether the fetch operation should be purely based on the main table
     * or include joins. If `$pure` is true, the method calls `fetchWithoutJoin()` to fetch records without joins. If `$pure` is false,
     * the method uses the provided `$joins` array to create a customized SQL query with joins, conditions, and search filters.
     *
     * If `$joins` is provided, the method constructs a SQL query using the `createJoin()`, `addWhere()`, and `like()` methods
     * based on the provided join and filter information. The query is then executed, and the fetched records are returned as an array
     * of objects with the class represented by the current model.
     *
     * If `$joins` is not provided, the method fetches all records from the main table using the `all()` method.
     *
     * @param bool $pure If true, fetch records without joins. If false, use provided join and filter options.
     * @param array|null $joins An array of join and filter options for constructing a customized SQL query.
     *
     * @return bool|array|ArrayIterator|null An array of objects representing the fetched records from the database.
     */
    public static function fetch(bool $pure=false, array $joins=null): bool|array|ArrayIterator|null
    {
        if ($pure) {
            return self::fetchWithoutJoin($joins);
        }

        if ($joins) {
            $sql = self::createJoin($joins);
            self::addWhere($sql, $joins);

            self::like($sql, $joins);
            $stmt = self::prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_CLASS);
        }
        return  static::all();

    }
    public static function get($query, $options=[]): false|ArrayIterator
    {
        
        $stmt = DatabaseHandler::factory()->prepare($query);
        $stmt->execute();
        if(method_exists(get_called_class(), '__construct')) {
            $results = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class(), array_keys(static::$tableSchema));
        } else {
            $results = $stmt->fetchAll(\PDO::FETCH_CLASS, get_called_class());
        }

        if ((is_array($results) && !empty($results))) {
            return new ArrayIterator($results);
        }
        return false;
    }

    public static function row($sql)
    {
        $row = static::get($sql);
        return ! $row ? 0 : $row->current();
    }

    /**
     * Get table name for model
     * @return mixed
     */
    public static function getTableName(): mixed
    {
        return static::$tableName;
    }

    /**
     * Get primary key model
     * @return mixed
     */
    public static function getPK(): mixed
    {
        return static::$primaryKey;
    }

    /**
     * Get the column names of the table associated with the current model.
     *
     * This method retrieves and returns an array containing the column names of the database table
     * associated with the current model. The table schema is determined based on the static property
     * $tableSchema, which should be defined in the derived class.
     *
     * @return array Returns an array of strings representing the column names of the associated table,
     *              return associative array (type each column) if withType be true
     */
    public static function getTableSchema(bool $withType=false): array
    {
        if ($withType) {
            return static::$tableSchema;            
        }
        return array_keys(static::$tableSchema);

    }

    /**
     * Method to check if value exist in db or not get column and value this column
     * @param string|null $column select the column you want count
     * @param string $value value column you want search it
     * @return false|ArrayIterator false if value not exist and values to this column otherwise
     *
     *@version 1.0.0
     *
     * @author Feras Barahmeh
     */
    public static function ifExist(string|null $column, string $value): false|ArrayIterator
    {
        $calledClass = get_called_class();
        return (new $calledClass)->get("SELECT " . $column . " FROM " . static::$tableName . " WHERE " . $column . " = '$value'");

    }

    public static function count($column='*', $where=[])
    {
        $sql = "SELECT COUNT({$column}) AS NumberRows FROM  " . static::getTableName();
        
        if ($where) {
            $sql .= " WHERE ";
            foreach ($where as $column => $value) {
                $sql .= " {$column} = '{$value}'";
            }
        }

        $stmt = self::prepare($sql);
        if ($stmt->execute()) {
            return $stmt->fetch()["NumberRows"];
        }
        return false;
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
}