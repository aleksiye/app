<?php
include 'config.php';
include 'functions.php';
if(isPost()){
    $error = null;
    global $conn;   
    $identifier = httpBody('identifier');

    $password = httpBody('auth-pass');
    $error['password'] = validateInput($password,'password',"Password must contain at least one of each: capital letter, lowercase letter, number, special character");
    $stmt = $conn->prepare(
    "SELECT u.*, r.role as role, i.path as `profile`, c.name as `country`, a.city as `city`, a.street as `street`, a.zip as `zip`, a.apartment as `apartment` 
    FROM user as u INNER JOIN role as r ON u.role_id = r.id LEFT OUTER JOIN img as i ON u.id = i.user_id 
    LEFT OUTER JOIN address as a ON u.address_id = a.id LEFT OUTER JOIN country as c ON a.country_id = c.id
    WHERE username = :identifier OR email = :identifier OR phone = :identifier");
    $stmt->bindParam(':identifier',$identifier);
    $stmt->execute();
    $result = $stmt->fetch();
    if(!$result){
        unset($result);
        $_SESSION['loginError'] = "Bad creditials.";
        header('Location:../index.php');
    }
    $passCheck = password_verify($password, $result->password);
    if(!$passCheck){
        unset($result);
        $_SESSION['loginError'] = "Bad creditials.";
        header('Location:../index.php');
    }
    unset($result->password);
    $_SESSION['user'] = $result;
    unset($result);
    header('Location:../index.php');
}
