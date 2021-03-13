<?php

class Session {
    public static function init() {
        session_start();
    }

    public static function get($cle){
        if (isset($_SESSION[$cle])) return $_SESSION[$cle];
        else return null;
    }

    public static function set($cle, $val){
        $_SESSION[$cle] = $val;
    }

    public static function unset($cle) {
        unset($_SESSION[$cle]);
    }

    public static function destroy() {
        unset($_SESSION);
        session_destroy();
    }
}