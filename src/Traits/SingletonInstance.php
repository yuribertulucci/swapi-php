<?php

namespace App\Traits;

trait SingletonInstance
{
    protected static ?self $instance = null;

    private function __construct() {}

    public static function instance(): self
    {
        if (! self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}