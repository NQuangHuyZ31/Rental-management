<?php

/*
	Author: Huy Nguyen
	Date: 2025-08-29
	Purpose: Build SQL queries
*/

namespace Core;
use Core\Database;

class QueryBuilder {

    protected $connection;
	// Query builder properties
    protected $table = '';
    protected $select = '*';
    protected $where = [];
    protected $whereOr = [];
    protected $orderBy = '';
    protected $limit = '';
    protected $offset = '';
    protected $join = [];
    protected $groupBy = '';
    protected $having = '';
    
    // Logging properties
    protected $logsql = false;	
    protected $logsql_file = 'sql.log';
    protected $logsql_folder = ROOT_PATH . '/Logs';

	public function __construct() {
        $this->connection = Database::getInstance()->getConnection();
	}

// ==================== QUERY BUILDER METHODS ====================

    /**
     * Set table name
     */
    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * Select columns
     */
    public function select($columns = '*')
    {
        if (is_array($columns)) {
            $this->select = implode(', ', $columns);
        } else {
            $this->select = $columns;
        }
        return $this;
    }

    /**
     * Where clause
     */
    public function where($column, $operator, $value = null)
    {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }
        
        $this->where[] = [
            'column' => $column,
            'operator' => $operator,
            'value' => $value,
            'logic' => 'AND'
        ];
        
        return $this;
    }

    /**
     * Where OR clause
     */
    public function whereOr($column, $operator, $value = null)
    {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }
        
        $this->whereOr[] = [
            'column' => $column,
            'operator' => $operator,
            'value' => $value,
            'logic' => 'OR'
        ];
        
        return $this;
    }

    /**
     * Where IN clause
     */
    public function whereIn($column, $values)
    {
        $this->where[] = [
            'column' => $column,
            'operator' => 'IN',
            'value' => $values,
            'logic' => 'AND'
        ];
        
        return $this;
    }

    /**
     * Where NOT IN clause
     */
    public function whereNotIn($column, $values)
    {
        $this->where[] = [
            'column' => $column,
            'operator' => 'NOT IN',
            'value' => $values,
            'logic' => 'AND'
        ];
        
        return $this;
    }

    /**
     * Where NULL clause
     */
    public function whereNull($column)
    {
        $this->where[] = [
            'column' => $column,
            'operator' => 'IS NULL',
            'value' => null,
            'logic' => 'AND'
        ];
        
        return $this;
    }

    /**
     * Where NOT NULL clause
     */
    public function whereNotNull($column)
    {
        $this->where[] = [
            'column' => $column,
            'operator' => 'IS NOT NULL',
            'value' => null,
            'logic' => 'AND'
        ];
        
        return $this;
    }

    /**
     * Order by clause
     */
    public function orderBy($column, $direction = 'ASC')
    {
        $this->orderBy = "ORDER BY {$column} {$direction}";
        return $this;
    }

    /**
     * Limit clause
     */
    public function limit($limit)
    {
        $this->limit = "LIMIT {$limit}";
        return $this;
    }

    /**
     * Offset clause
     */
    public function offset($offset)
    {
        $this->offset = "OFFSET {$offset}";
        return $this;
    }

    /**
     * Join clause
     */
    public function join($table, $first, $operator, $second, $type = 'INNER')
    {
        $this->join[] = [
            'table' => $table,
            'first' => $first,
            'operator' => $operator,
            'second' => $second,
            'type' => $type
        ];
        
        return $this;
    }

    /**
     * Left join
     */
    public function leftJoin($table, $first, $operator, $second)
    {
        return $this->join($table, $first, $operator, $second, 'LEFT');
    }

    /**
     * Right join
     */
    public function rightJoin($table, $first, $operator, $second)
    {
        return $this->join($table, $first, $operator, $second, 'RIGHT');
    }

    /**
     * Group by clause
     */
    public function groupBy($columns)
    {
        if (is_array($columns)) {
            $this->groupBy = 'GROUP BY ' . implode(', ', $columns);
        } else {
            $this->groupBy = 'GROUP BY ' . $columns;
        }
        return $this;
    }

    /**
     * Having clause
     */
    public function having($column, $operator, $value)
    {
        $this->having = "HAVING {$column} {$operator} ?";
        return $this;
    }

    // ==================== EXECUTION METHODS ====================

    /**
     * Execute SELECT query
     */
    public function get()
    {
        $sql = $this->buildSelectQuery();
        $params = $this->getWhereParameters();
        
        $this->logQuery($sql, $params, 'SELECT');
        
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            $this->logQuery($sql, $params, 'INSERT');
            throw $e;
        }
    }

    /**
     * Execute SELECT query and return first result
     */
    public function first()
    {
        $this->limit(1);
        $results = $this->get();
        return !empty($results) ? $results[0] : null;
    }

    /**
     * Execute SELECT query and return single value
     */
    public function value($column)
    {
        $this->select($column);
        $this->limit(1);
        $result = $this->first();
        return $result ? $result[$column] : null;
    }

    /**
     * Count records
     */
    public function count()
    {
        $this->select('COUNT(*) as count');
        $result = $this->first();
        return $result ? (int)$result['count'] : 0;
    }

    /**
     * Check if record exists
     */
    public function exists()
    {
        return $this->count() > 0;
    }

    /**
     * Execute INSERT query
     */
    public function insert($data)
    {
        $columns = array_keys($data);
        $placeholders = ':' . implode(', :', $columns);
        $columnList = implode(', ', $columns);
        
        $sql = "INSERT INTO {$this->table} ({$columnList}) VALUES ({$placeholders})";
        
        $this->logQuery($sql, $data, 'INSERT');
        
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($data);
            return $this->connection->lastInsertId();
        } catch (\PDOException $e) {
            $this->logQuery($sql, $data, 'INSERT');
            throw $e;
        }
    }

    /**
     * Execute UPDATE query
     */
    public function update($data)
    {
        $setClause = [];
        foreach (array_keys($data) as $column) {
            $setClause[] = "{$column} = :{$column}";
        }
        $setClause = implode(', ', $setClause);
        
        $sql = "UPDATE {$this->table} SET {$setClause}";
        $whereClause = $this->buildWhereClause();
        if ($whereClause) {
            $sql .= " WHERE {$whereClause}";
        }
        
        $params = array_merge($data, $this->getWhereParameters());
        
        $this->logQuery($sql, $params, 'UPDATE');
        
        try {
            $stmt = $this->connection->prepare($sql);
            return $stmt->execute($params);
        } catch (\PDOException $e) {
            $this->logQuery($sql, $params, 'UPDATE');
            throw $e;
        }
    }

    /**
     * Execute DELETE query
     */
    public function delete()
    {
        $sql = "DELETE FROM {$this->table}";
        $whereClause = $this->buildWhereClause();
        if ($whereClause) {
            $sql .= " WHERE {$whereClause}";
        }
        
        $params = $this->getWhereParameters();
        
        $this->logQuery($sql, $params, 'DELETE');
        
        try {
            $stmt = $this->connection->prepare($sql);
            return $stmt->execute($params);
        } catch (\PDOException $e) {
            $this->logQuery($sql, $params, 'DELETE');
            throw $e;
        }
    }

    // ==================== RAW QUERY METHODS ====================

    /**
     * Execute raw SQL query
     */
    public function query($sql, $params = [])
    {
        $this->logQuery($sql, $params, 'RAW');
        
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (\PDOException $e) {
            $this->logQuery($sql, $params, 'RAW');
            throw $e;
        }
    }

    /**
     * Execute raw SQL query and fetch all
     */
    public function queryAll($sql, $params = [])
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    /**
     * Execute raw SQL query and fetch first
     */
    public function queryFirst($sql, $params = [])
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch();
    }

    // ==================== TRANSACTION METHODS ====================

    /**
     * Begin transaction
     */
    public function beginTransaction()
    {
        return $this->connection->beginTransaction();
    }

    /**
     * Commit transaction
     */
    public function commit()
    {
        return $this->connection->commit();
    }

    /**
     * Rollback transaction
     */
    public function rollback()
    {
        return $this->connection->rollback();
    }

    // ==================== QUERY BUILDING METHODS ====================

    /**
     * Build SELECT query
     */
    private function buildSelectQuery()
    {
        $sql = "SELECT {$this->select} FROM {$this->table}";
        
        // Add joins
        foreach ($this->join as $join) {
            $sql .= " {$join['type']} JOIN {$join['table']} ON {$join['first']} {$join['operator']} {$join['second']}";
        }
        
        // Add where clauses
        $whereClause = $this->buildWhereClause();
        if ($whereClause) {
            $sql .= " WHERE {$whereClause}";
        }
        
        // Add group by
        if ($this->groupBy) {
            $sql .= " {$this->groupBy}";
        }
        
        // Add having
        if ($this->having) {
            $sql .= " {$this->having}";
        }
        
        // Add order by
        if ($this->orderBy) {
            $sql .= " {$this->orderBy}";
        }
        
        // Add limit and offset
        if ($this->limit) {
            $sql .= " {$this->limit}";
            if ($this->offset) {
                $sql .= " {$this->offset}";
            }
        }
        
        return $sql;
    }

    /**
     * Build WHERE clause
     */
    private function buildWhereClause()
    {
        $conditions = [];
        
        // Add AND conditions
        foreach ($this->where as $condition) {
            $column = $condition['column'];
            $operator = $condition['operator'];
            $value = $condition['value'];
            
            if ($operator === 'IN' || $operator === 'NOT IN') {
                if (is_array($value)) {
                    $placeholders = str_repeat('?,', count($value) - 1) . '?';
                    $conditions[] = "{$column} {$operator} ({$placeholders})";
                }
            } elseif ($operator === 'IS NULL' || $operator === 'IS NOT NULL') {
                $conditions[] = "{$column} {$operator}";
            } else {
                $conditions[] = "{$column} {$operator} ?";
            }
        }
        
        // Add OR conditions
        if (!empty($this->whereOr)) {
            $orConditions = [];
            foreach ($this->whereOr as $condition) {
                $column = $condition['column'];
                $operator = $condition['operator'];
                $value = $condition['value'];
                
                if ($operator === 'IN' || $operator === 'NOT IN') {
                    if (is_array($value)) {
                        $placeholders = str_repeat('?,', count($value) - 1) . '?';
                        $orConditions[] = "{$column} {$operator} ({$placeholders})";
                    }
                } elseif ($operator === 'IS NULL' || $operator === 'IS NOT NULL') {
                    $orConditions[] = "{$column} {$operator}";
                } else {
                    $orConditions[] = "{$column} {$operator} ?";
                }
            }
            
            if (!empty($orConditions)) {
                $conditions[] = '(' . implode(' OR ', $orConditions) . ')';
            }
        }
        
        return implode(' AND ', $conditions);
    }

    /**
     * Get WHERE parameters
     */
    private function getWhereParameters()
    {
        $params = [];
        
        // Add AND condition parameters
        foreach ($this->where as $condition) {
            $operator = $condition['operator'];
            $value = $condition['value'];
            
            if ($operator === 'IN' || $operator === 'NOT IN') {
                if (is_array($value)) {
                    $params = array_merge($params, $value);
                }
            } elseif ($operator !== 'IS NULL' && $operator !== 'IS NOT NULL') {
                $params[] = $value;
            }
        }
        
        // Add OR condition parameters
        foreach ($this->whereOr as $condition) {
            $operator = $condition['operator'];
            $value = $condition['value'];
            
            if ($operator === 'IN' || $operator === 'NOT IN') {
                if (is_array($value)) {
                    $params = array_merge($params, $value);
                }
            } elseif ($operator !== 'IS NULL' && $operator !== 'IS NOT NULL') {
                $params[] = $value;
            }
        }
        
        return $params;
    }

    // ==================== LOGGING METHODS ====================

    /**
     * Log query execution
     */
    private function logQuery($sql, $params, $type)
    {
        if (!$this->logsql) {
            return;
        }

        try {
            $logData = [
                'sql'        => $sql,
                'params'     => json_encode($params, JSON_UNESCAPED_UNICODE),
                'type'       => $type,
                'table'      => $this->table ?? null,
                'executed_at'=> date('Y-m-d H:i:s'),
                'user_id'    => $this->getCurrentUserId(),
                'ip_address' => $this->getClientIp(),
                'user_agent' => $this->getUserAgent()
            ];

            $filePath = $this->logsql_folder . '/' . $this->logsql_file;
            file_put_contents($filePath, "{" . date('Y-m-d H:i:s') . "}" . json_encode($logData) . PHP_EOL, FILE_APPEND);
        } catch (\Exception $e) {
            $errFile = $this->logsql_folder . '/error_' . $this->logsql_file;
            file_put_contents($errFile, "Failed to log query: " . $e->getMessage() . PHP_EOL, FILE_APPEND);
        }
    }


    // ==================== UTILITY METHODS ====================

    /**
     * Get current user ID (from session or auth)
     */
    private function getCurrentUserId()
    {
        if (isset($_SESSION['user_id'])) {
            return $_SESSION['user_id'];
        }
        return null;
    }

    /**
     * Get client IP address
     */
    private function getClientIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        }
    }

    /**
     * Get user agent
     */
    private function getUserAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
    }

    /**
     * Reset query builder
     */
    public function reset()
    {
        $this->table = '';
        $this->select = '*';
        $this->where = [];
        $this->whereOr = [];
        $this->orderBy = '';
        $this->limit = '';
        $this->offset = '';
        $this->join = [];
        $this->groupBy = '';
        $this->having = '';
        
        return $this;
    }

    /**
     * Get last executed SQL
     */
    public function getLastSql()
    {
        return $this->buildSelectQuery();
    }

    /**
     * Get last query parameters
     */
    public function getLastParams()
    {
        return $this->getWhereParameters();
    }
}