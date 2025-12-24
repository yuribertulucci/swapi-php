<?php

namespace App\Database;

use PDO;
use PDOStatement;

class Database
{
    private static ?PDO $connection = null;
    private string $table;
    private string $sql;
    private array $params = [];
    private array $whereConditions = [];
    private ?PDOStatement $stmt = null;

    function __construct() {}

    public static function table(string $table): Database
    {
        $instance = new self();
        $instance->table = $table;

        return $instance;
    }

    public function insert(array $data): self
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $this->sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $this->params = array_combine(array_map(fn($key) => ":{$key}", array_keys($data)), $data);

        return $this;
    }

    public function update(array $data): self
    {
        $setClause = implode(', ', array_map(fn($key) => "{$key} = :{$key}", array_keys($data)));
        $this->sql = "UPDATE {$this->table} SET {$setClause}";
        $this->params = array_combine(array_map(fn($key) => "{$key} = :{$key}", array_keys($data)), $data);

        return $this;
    }

    public function where(string $column, string $operator, $value): self
    {
        $this->whereConditions[] = [
            'clause' => "{$column} {$operator} :where_{$column}",
            'param' => ":where_{$column}",
            'value' => $value
        ];

        return $this;
    }

    public function execute(): bool
    {
        $this->sql .= $this->buildWhereClause();
        $this->stmt = self::getConnection()->prepare($this->sql);

        foreach ($this->whereConditions as $condition) {
            $this->stmt->bindValue($condition['param'], $condition['value']);
        }

        foreach ($this->params as $key => $value) {
            $this->stmt->bindValue($key, $value);
        }

        return $this->stmt->execute();
    }

    private function buildWhereClause(): string
    {
        if (empty($this->whereConditions)) {
            return '';
        }

        $clauses = array_map(fn($cond) => $cond['clause'], $this->whereConditions);
        return ' WHERE ' . implode(' AND ', $clauses);
    }

    private static function getConnection(): PDO
    {
        if (self::$connection === null) {
            self::$connection = Connection::getConnection();
        }

        return self::$connection;
    }
}