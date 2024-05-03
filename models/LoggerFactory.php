<?php

namespace app\models;

class LoggerFactory
{
    public static function createLogger(string $type): LogInterface
    {
        switch ($type) {
            case 'email':
                return new EmailLog();
            case 'database':
                return new DatabaseLog();
            case 'file':
                return new FileLog();
            default:
                throw new \InvalidArgumentException('Invalid logger type');
        }
    }
}
