<?php 
namespace Facades;

class Session{
    public static function read($var){
        return $_SESSION[$var] ?? null;
    }

    public static function readOnce($var){
        $buffer = $_SESSION[$var] ?? null;
        $_SESSION[$var] = null;
        return $buffer;
    }

    public static function set($var, $value = null){
        $_SESSION[$var] = $value;
    }

    public static function saveOlds(){
        self::set('olds', $_POST);
    }
}