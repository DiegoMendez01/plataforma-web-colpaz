<?php
class Session
{
    private static $instance;

    private function __construct()
    {
        session_start();
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function put($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    public function forget($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public function destroy()
    {
        session_unset();
        session_destroy();
    }

    public function has($key)
    {
        return isset($_SESSION[$key]);
    }
}