<?php

namespace App\Support;

use App\Database\Connection;
use PDO;

class Logger
{
    public static function logApi(string $level, array $context = []): void
    {
        $connection = Connection::instance()->getConnection();
        $request = request();
        $stmt = $connection->prepare("INSERT INTO api_logs (level, endpoint, method, status_code) VALUES (:level, :endpoint, :method, :status_code)");
        $stmt->execute([
            ':level' => $level,
            ':endpoint' => $context['endpoint'] ?? $request->getUri(),
            ':method' => $context['method'] ?? $request->getMethod(),
            ':status_code' => $context['status_code'] ?? 0,
        ]);
    }
}