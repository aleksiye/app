<?php
include './config.php';
include './functions.php';
if(isPost()){
    $error = null;
    global $conn; # odavde se vidi da je sve otislo u k**** 
    $username = httpBody('username');
    $email = httpBody('email');
    $fname  = httpBody('first-name');
    $lname = httpBody('last-name');
    $password = httpBody('password');
    $error['password'] = validateInput($password,'password',"Password must contain at least one of each: capital letter, lowercase letter, number, special character");
    $password = password_hash($password, PASSWORD_DEFAULT);
    $phone = httpBody('phone');
    $phone = str_replace(array('-',' '),'',$phone);
    $company = httpBody('company');
    $error['username'] = validateInput($username,'username',"Invalid username");
    $error['email'] = validateInput($email,'email',"Invalid email");
    $error['first-name'] = validateInput($fname,'first_name',"Invalid first name");
    $error['last-name'] = validateInput($lname,'last_name',"Invalid last name");
    $error['phone'] = validateInput($phone,'phone',"Invalid phone format");
    $error['company'] = validateInput($company,'company',"Invalid company name");
    if($_POST['phone'] ==''){
        $phone = null;
    }
    if($_POST['company'] == ''){
        $company = null;
    }
    if(!isset($error['username'])){
        $error['email'] = allreadyTaken($username, 'username') == false ? null : 'That username is not available.';
    }
    if(!isset($error['email'])){
        $error['email'] = allreadyTaken($email, 'email') == false ? null : 'That email is allready taken';
    }
    if(!isset($error['phone'])){
       $error['phone'] = allreadyTaken($phone, 'phone') == false ? null : 'Phone number is allready taken';
    }
    
    $validateOk = true;
    foreach($error as $key => $errMsg){
        if($errMsg != null){
            $validateOk = false;
        }
    }


    if($validateOk){
        unset($_SESSION['registerError']);
        unset($_SESSION['old_register_data']);
        $stmt = $conn->prepare("INSERT INTO `user` (`username`, `email`, `password`,`first_name`,`last_name`, `phone`, `company`) 
             VALUES (:username, :email, :password,:first_name,:last_name, :phone, :company );");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':first_name', $fname);
        $stmt->bindParam(':last_name', $lname);
        $stmt->bindParam(':phone',$phone);
        $stmt->bindParam(':company',$company);
        $db_resp = $stmt->execute();
        if($db_resp){
            echo "Successful registration";
            header("Location:../index.php");
        }
    }
    else{
        $_SESSION['registerError'] = $error;
        $_SESSION['old_register_data'] = $_POST;
        header("Location:../index.php");
    }
}