<?php

namespace App\Core\Traits;

/**
 * Singleton Pattern.
 *
 * Modern implementation.
 */
trait Singleton
{
    private static $instance = null;

    /**
     * Call this method to get singleton
     */
    public static function getInstance()
    {
        if (is_null(self::$instance) && !self::$instance instanceof self) {
            self::$instance = new self;
        }

        return static::$instance;
    }

    /**
     * Make constructor private, so nobody can call "new Class".
     */
    private function __construct()
    {
        return "You have been created a new instance of " . self::class . " class.";
    }

    /**
     * Make clone magic method private, so nobody can clone instance.
     */
    private function __clone()
    {
        trigger_error("Invalid operation: You don't to create a instance of " . self::class . " class.", E_USER_ERROR);
    }

    /**
     * Make sleep magic method private, so nobody can serialize instance.
     */
    private function __sleep()
    {
    }

    /**
     * Make wakeup magic method private, so nobody can unserialize instance.
     */
    private function __wakeup()
    {
        trigger_error("Invalid operation: You don't to unserialize a instance of " . self::class . " class.");
    }

    public function __toString()
    {
        return "Class " . self::class;
    }
}
