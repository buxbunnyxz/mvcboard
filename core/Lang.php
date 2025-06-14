<?php
// core/Lang.php

class Lang
{
    protected static $lang = 'en';
    protected static $strings = [];

    public static function init($default = 'en')
    {
        if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'fr'])) {
            $_SESSION['lang'] = $_GET['lang'];
        }

        self::$lang = $_SESSION['lang'] ?? $default;

        $file = APP . '/lang/' . self::$lang . '.php';
        if (file_exists($file)) {
            self::$strings = require $file;
        }
    }

    public static function get($key)
    {
        return self::$strings[$key] ?? $key;
    }

    public static function current()
    {
        return self::$lang;
    }
}
