<?php

namespace App\Core\Traits;

/**
 * Singleton Pattern.
 * 
 * Modern implementation.
 */
trait Singleton
{
    protected static $instance = null;

    /**
     * Call this method to get singleton
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * Make constructor private, so nobody can call "new Class".
     */
    private function __construct()
    { }

    /**
     * Make clone magic method private, so nobody can clone instance.
     */
    private function __clone()
    { }

    /**
     * Make sleep magic method private, so nobody can serialize instance.
     */
    private function __sleep()
    { }

    /**
     * Make wakeup magic method private, so nobody can unserialize instance.
     */
    private function __wakeup()
    { }
}
