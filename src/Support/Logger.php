<?php

namespace App\Support;

use App\Database\Connection;
use App\Model\ApiLogModel;
use PDO;
use PDOException;

class Logger
{
    public static function logApi(string $level, array $context = []): void
    {
        $log = new ApiLogModel([
            'level' => $level,
            'endpoint' => $context['endpoint'] ?? '',
            'method' => $context['method'] ?? '',
            'status_code' => $context['status_code'] ?? 0,
            'created_at' => time(),
        ]);

        try {
            $log->save();
        } catch (PDOException $e) {
            error_log('Failed to log API request: ' . $e->getMessage());
        } catch (\Exception $e) {
            error_log('An unexpected error occurred while logging API request: ' . $e->getMessage());
        }
    }
}