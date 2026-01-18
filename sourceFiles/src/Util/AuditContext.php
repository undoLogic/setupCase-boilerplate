<?php
// src/Util/AuditContext.php

namespace App\Util;

final class AuditContext
{
    protected static ?int $userId = null;
    protected static ?string $ipAddress = null;

    public static function set(?int $userId, ?string $ipAddress = null): void
    {
        self::$userId = $userId;
        self::$ipAddress = $ipAddress;
    }

    public static function userId(): ?int
    {
        return self::$userId;
    }

    public static function ip(): ?string
    {
        return self::$ipAddress;
    }

    public static function clear(): void
    {
        self::$userId = null;
        self::$ipAddress = null;
    }
}
