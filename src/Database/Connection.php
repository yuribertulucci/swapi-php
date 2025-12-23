<?php

namespace App\Database;

use App\Traits\SingletonInstance;
use PDO;

class Connection
{
    use SingletonInstance;

    private ?string $driver;
    private ?string $host;
    private ?string $port;
    private ?string $database;
    private ?PDO $connection;

    private function __construct() {}

    public function connect(string $driver, string $host, string $port, string $username, string $password, string $database): Connection
    {
        $this->driver = $driver;
        $this->host = $host;
        $this->port = $port;
        $this->database = $database;

        $pdo = new PDO("{$this->driver}:host={$this->host};port={$this->port};dbname={$this->database}", $username, $password);
        $this->connection = $pdo;

        return $this;
    }

    public static function getConnection(): PDO
    {
        $instance = self::instance();
        return $instance->connection;
    }

    public function getDriver(): string
    {
        return $this->driver;
    }

    public function getDatabase(): string
    {
        return $this->database;
    }
}