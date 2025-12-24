<?php

namespace App\Model;

use App\Database\Database;

class ApiLogModel extends BaseModel
{
    protected string $table = 'api_logs';
    protected string $idColumn = 'id';
    protected ?string $identifier;

    // Model properties
    public string $level;
    public string $endpoint;
    public string $method;
    public int $statusCode;
    public string $createdAt;

    public function __construct(array $data = [])
    {
        $this->identifier = $data['identifier'] ?? null;
        $this->level = $data['level'] ?? 'info';
        $this->endpoint = $data['endpoint'] ?? '';
        $this->method = $data['method'] ?? '';
        $this->statusCode = $data['status_code'] ?? 0;
        $this->createdAt = $data['created_at'] ?? date('Y-m-d H:i:s');
    }

    public function save(): bool
    {
        $data = [
            'level' => $this->level,
            'endpoint' => $this->endpoint,
            'method' => $this->method,
            'status_code' => $this->statusCode,
            'created_at' => $this->createdAt,
        ];

        if ($this->identifier) {
            return Database::table($this->table)
                ->update($data)
                ->where($this->idColumn, '=', $this->identifier)
                ->execute();
        } else {
            return Database::table($this->table)
                ->insert($data)
                ->execute();
        }
    }

}