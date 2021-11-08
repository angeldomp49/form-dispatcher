<?php 
session_start();

use Facades\Session;

function session($var, $value = null){
    if(empty($value)){
        return Session::readOnce($var);
    }

    Session::set($var, $value);
}

function old($input){
    return Session::read('olds')[$input] ?? null;
}

function dold($input){
    echo( old($input) );
}

function back(){
    $previousURL = $_SERVER['HTTP_REFERER'];
    header('Location: ' . $previousURL);
}