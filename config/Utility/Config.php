<?php
class Config {
    
    private static $_config = [];
    public static function get($key) {
        if (empty(self::$_config)) {
            self::$_config = require_once "configbase.php";
        }
        return(array_key_exists($key, self::$_config) ? self::$_config[$key] : null);
    }

}
