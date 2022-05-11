<?php

session_start();

function setSession($name, $val){
    $_SESSION[$name] = $val;
    return true;
}

function getSession($name){

    if(isset($_SESSION[$name])) {
        return $_SESSION[$name];
    }
    return false;
}

function deleteSession($name){
    if(isset($_SESSION[$name])) {
        unset($_SESSION[$name]);
        return true;
    }
    return false;
}

function existSession($name){
    return isset($_SESSION[$name]);
}


function flashSession($name){
    $temp = null;
    if(existSession($name)){
        $temp = getSession($name);
        deleteSession($name);
    } else {
        $temp = false;
    }
    return $temp;
}