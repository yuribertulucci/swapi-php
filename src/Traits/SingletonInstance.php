<?php

namespace App\Traits;

trait SingletonInstance
{
    protected static ?self $instance = null;

    private function __construct() {}

    public static function instance(...$params): self
    {
        if (! self::$instance) {
            self::$instance = new self(...$params);
        }

        return self::$instance;
    }
}