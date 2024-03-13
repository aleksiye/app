<?php
function isPost(){
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}
function authenticated(){
    return isset($_SESSION['user']);
}
function authorized(){
    if(!authenticated()){
        return null;
    }
    $user = getUser();
    if(!isset($user->role)){
        die("Critical authorization error");
    }
    return $user->role;
}
function getUser(){
    if(!authenticated()){
        return null;
    }
    return $_SESSION['user'];
}
function httpBody($key){
    if(!isset($_POST[$key])){
        return null;
    }
    return $_POST[$key];
}
function httpQuery($key){
    if(!isset($_GET[$key])){
        return null;
    }
    return $_GET[$key];
}
function validateInput($value,$key,$response){
    if(empty($value)){
        if($key == 'phone' || $key == 'company'){
            return null;
        }
        return "This field is required";
    }
    switch ($key) {
        case "email":
            if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
                return $response;
            };break;
        case "first_name":
        case "last_name":
            if(!preg_match("/^[A-Z][a-z .]{2,255}$/", $value)){
                return $response;
            };break;
        case 'username':
            if(!preg_match("/^[a-zA-Z_][0-9a-zA-Z_]{1,255}$/", $value)){
                return $response;
            };break;
        case "password":
            if(!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[]#?!@$%^&*()\-_+=|\/<>'\":;,.]).{8,}$/", $value)){
                return $response;
            };break;
        case "phone":
            if(!preg_match("/^(([+]?\d{1,3})?|(0\d{2}))\d{0,12}$/",$value)){
                return $response;
            };break;
        case "company":
            if(!preg_match("/^[a-zA-Z0-9][a-zA-Z0-9 ._,<>'\":;]{2,255}$/", $value)){
                return $response;
            };break;
    }
}
function allreadyTaken($value,$key){
    global $conn;
    $stmt = $conn->prepare(
        "SELECT id FROM user WHERE $key = :value");
    $stmt->bindParam(':value',$value);
    $stmt->execute();
    $result = $stmt->fetch();
    if(!$result){
        return false;
    }
    return $result;
}