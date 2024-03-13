<?php
require_once './config.php';
require_once './functions.php';

if(isPost() && isset($_SESSION['user'])){
    $errors=[];
    global $conn;
    foreach($_POST as $key => $val){
        if($_POST[$key] == ''){
            $_POST[$key] = null;
        }
    }
    $user_id = $_SESSION['user']->id;
    var_dump($_POST);
    $db_resp = $conn->query("SELECT `password` FROM user WHERE id = $user_id");
    $password = $db_resp->fetch()->password;
    $authenticated =  password_verify($_POST['password'], $password);
    if(!$authenticated){
        $_SESSION['updateError'] = "Wrong password";
        #header('Location:../profile.php');
        die();
    }
    unset($_POST['password']);
    if(isset($_POST['country'])){
        $_POST['country'] = $_POST['country'] == 0 ? null: $_POST['country'];
    }
    if($_SESSION['user']->address_id == null && isset($_POST['country']) && isset($_POST['city']) && isset($_POST['Street'])){
        $stmt = $conn->prepare("INSERT INTO `address` (`country_id`, `city`, `street`, `zip`, `apartment`) VALUES (':country', ':city', ':street', ':zip', ':apartment');");
        $stmt->bindParam(':country', $_POST['country']);
        $stmt->bindParam(':city', $_POST['city']);
        $stmt->bindParam(':street', $_POST['Street']);
        $stmt->bindParam(':zip', $_POST['zip']);
        $stmt->bindParam(':apartment', $_POST['apartment']);
        $db_resp = $stmt->execute();
        if($db_resp){
            $_SESSION['user']->address_id = $conn->lastInsertId();
            $db_response = $conn->query("UPDATE user SET adress_id = $conn->lastInsertId() WHERE id = $user_id")->fetch();
            if(!$db_response){
                $errors['update_address'] = "Failed to update address";
            }
        }
        else{
            $errors['insert_address'] = "Could not create address";
        }
    }
    if(isset($_POST['country']) && isset($_POST['city']) && isset($_POST['Street'])){
        $stmt = $conn->prepare("UPDATE address SET country_id = :country, city = :city, street = :street, zip = :zip, apartment = :apartment
        WHERE id = :address_id" );
        $stmt->bindParam(':country', $_POST['country']);
        $stmt->bindParam(':city',$_POST['city']);
        $stmt->bindParam(':street',$_POST['street']);
        $stmt->bindParam(':zip',$_POST['zip']);
        $stmt->bindParam(':apartment',$_POST['apartment']);
        $stmt->bindParam(':address_id',$_SESSION['user']->address_id);
    }

    if($_FILES['profile']['error'] == UPLOAD_ERR_OK){
        $file_mime_type = $_FILES['profile']['type'];
        $allowed_mime_types = array('image/jpeg', 'image/png', 'image/avif');
        if(!in_array($file_mime_type, $allowed_mime_types)){
            $errors['uploadImg'] ="Only JPG, PNG, and AVIF files are supported.";
            $_SESSION['updateUserError'] = $errors;
            header('Location: ./profile.php');
        }
        $unique_filename = uniqid() . '_' . $_SESSION['user']->id . '_' . $_FILES['profile']['name'];
        
        $absolute_file_path = $_SERVER['DOCUMENT_ROOT'] . '/app/private/uploads/profile/'.$unique_filename;
        $relative_file_path = './private/uploads/profile/'.$unique_filename;
        $is_moved = move_uploaded_file($_FILES['profile']['tmp_name'], $absolute_file_path);
        if($is_moved){
            $_SESSION['uploadOK'] = true;
            if(!isset($_SESSION['user']->profile)){
                $db_response = $conn->query("INSERT INTO img (alt, user_id, `path`) VALUES ('profile picture', $user_id, '$relative_file_path')");
                $_SESSION['user']->profile = $conn->lastInsertId();
            }
            else{
                var_dump($relative_file_path);
                $db_response = $conn->query("UPDATE img SET `path` = '$relative_file_path' WHERE user_id = $user_id");
            }
             
        }
        else{
            $errors['uploadImg'] = "Could not upload image";
            #header('Location:./profile.php');
        }
    }
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
    $errors['username'] = validateInput($username,'username',"Invalid username");
    $errors['email'] = validateInput($email,'email',"Invalid email");
    $errors['first-name'] = validateInput($fname,'first_name',"Invalid first name");
    $errors['last-name'] = validateInput($lname,'last_name',"Invalid last name");
    $errors['phone'] = validateInput($phone,'phone',"Invalid phone format");
    $errors['company'] = validateInput($company,'company',"Invalid company name");
    if(!isset($error['username'])){
        $isTaken = allreadyTaken($username, 'username');
        if (!($isTaken == false || $isTaken->id == $_SESSION['user']->id)){
            $errors['username'] = "Username already taken";
        }
    }
    if(!isset($error['email'])){
        $isTaken = allreadyTaken($username, 'email');
        if (!($isTaken == false || $isTaken->id == $_SESSION['user']->id)){
            $errors['email'] = "Email already taken";
        }
    }
    if(!isset($error['phone'])){
        $isTaken = allreadyTaken($username, 'phone');
        if (!($isTaken == false || $isTaken->id == $_SESSION['user']->id)){
            $errors['username'] = "Username already taken";
        }
    }
    echo '<br>';
    var_dump($errors);
    $validateOk = true;
    foreach($errors as $key => $errMsg){
        if($errMsg != null){
            $validateOk = false;
        }
    }
    if($validateOk){
        echo "Validate PASSED";
        $stmt = $conn->prepare("UPDATE user SET username = :username, email = :email, first_name = :first_name, last_name = :last_name, phone = :phone, company = :company WHERE id = :id");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':first_name', $fname);
        $stmt->bindParam(':last_name', $lname);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':company', $company);
        $stmt->bindParam(':id', $_SESSION['user']->id);
        $db_response = $stmt->execute();
        if(!$db_response){
            $errors['update_user'] = "Failed to update user";
        }
        $_SESSION['user'] = $conn->query("SELECT u.*, r.role as role, i.path as `profile`, c.name as `country`, a.city as `city`, a.street as `street`, a.zip as `zip`, a.apartment as `apartment` 
        FROM user as u INNER JOIN role as r ON u.role_id = r.id LEFT OUTER JOIN img as i ON u.id = i.user_id 
        LEFT OUTER JOIN address as a ON u.address_id = a.id LEFT OUTER JOIN country as c ON a.country_id = c.id
        WHERE u.id = $user_id")->fetch();
        #header('Location:../profile.php');
    }

}