<?php
include './private/config.php';
include './templates/header.php';
include './templates/nav.php';
include './private/functions.php';
if(isPost()){
    $error = null;
    global $conn;  
    $username = httpBody('username');
    $email = httpBody('email');
    $fname  = httpBody('first_name');
    $lname = httpBody('last_name');
    $password = httpBody('password');
    $error['password'] = validateInput($password,'password',"Password must contain at least one of each: capital letter, lowercase letter, number, special character");
    $password = password_hash($password, PASSWORD_DEFAULT);
    $phone = httpBody('phone');
    $phone = str_replace(array('-',' '),'',$phone);
    $company = httpBody('company');
    $error['username'] = validateInput($username,'username',"Invalid username");
    $error['email'] = validateInput($email,'email',"Invalid email");
    $error['first_name'] = validateInput($fname,'first_name',"Invalid first name");
    $error['last_name'] = validateInput($lname,'last_name',"Invalid last name");
    $error['phone'] = validateInput($phone,'phone',"Invalid phone format");
    $error['company'] = validateInput($company,'company',"Invalid company name");
    $validateOk = true;
    foreach($error as $key => $errMsg){
        if($errMsg != null){
            $validateOk = false;
        }
    }
    if($validateOk){
        unset($_SESSION['register_errors']);
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
        }
    }
    else{
        $_SESSION['register_errors'] = $error;
        $_SESSION['old_register_data'] = $_POST;
        header("Location:register.php");
    }
}

?>
<div class='my-8'>
<form action="<?=htmlentities($_SERVER['PHP_SELF'])?>" method="POST" class="max-w-md mx-auto">
    <div class="relative z-0 w-full mb-5 group">
        <input type="text" name="username" id="floating_username" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required
               value="<?= isset($_SESSION['register_errors']['username']) ? '' : $_SESSION['old_register_data']['username'] ?? '' ?>" />
        <label for="floating_username" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
            <?= $_SESSION['register_errors']['username'] ?? 'Username' ?></label>
    </div>
    <div class="relative z-0 w-full mb-5 group">
        <input type="email" name="email" id="floating_email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required
               value="<?= isset($_SESSION['register_errors']['email']) ? '' : $_SESSION['old_register_data']['username'] ?? '' ?>"/>
        <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
            <?= $_SESSION['register_errors']['email'] ?? 'Email address' ?></label>
    </div>
    <div class="relative z-0 w-full mb-5 group">
        <input type="password" name="password" id="floating_password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required
                value="<?= isset($_SESSION['register_errors']['password']) ? '' : $_SESSION['old_register_data']['password'] ?? '' ?>"/>
        <label for="floating_password" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
            <?=$_SESSION['register_errors']['password'] ?? 'Password'?></label>
    </div>
    <div class="relative z-0 w-full mb-5 group">
        <input type="password" name="repeat_password" id="floating_repeat_password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required
        />
        <label for="floating_repeat_password" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Confirm password</label>
    </div>
    <div class="grid md:grid-cols-2 md:gap-6">
        <div class="relative z-0 w-full mb-5 group">
            <input type="text" name="first_name" id="floating_first_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required
            value="<?= isset($_SESSION['register_errors']['first_name']) ? '' : $_SESSION['old_register_data']['first_name'] ?? '' ?>"/>
            <label for="floating_first_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                <?= $_SESSION['register_errors']['first_name'] ?? 'First name' ?></label>
        </div>
        <div class="relative z-0 w-full mb-5 group">
            <input type="text" name="last_name" id="floating_last_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required
            value="<?= isset($_SESSION['register_errors']['last_name']) ? '' : $_SESSION['old_register_data']['last_name'] ?? '' ?>"/>
            <label for="floating_last_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                <?= $_SESSION['register_errors']['last_name'] ?? 'Last name' ?></label>
        </div>
    </div>
    <div class="grid md:grid-cols-2 md:gap-6">
        <div class="relative z-0 w-full mb-5 group">
            <input type="tel" name="phone" id="floating_phone" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" "
            value="<?= isset($_SESSION['register_errors']['phone']) ? '' : $_SESSION['old_register_data']['phone'] ?? '' ?>"/>
            <label for="floating_phone" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                <?=$_SESSION['register_errors']['phone'] ?? 'Phone (Optional)' ?></label>
        </div>
        <div class="relative z-0 w-full mb-5 group">
            <input type="text" name="company" id="floating_company" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" "
            value="<?= isset($_SESSION['register_errors']['company']) ? '' : $_SESSION['old_register_data']['company'] ?? '' ?>"/>
            <label for="floating_company" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                <?=$_SESSION['register_errors']['company'] ?? 'Company (Optional)' ?></label>
        </div>
    </div>
    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
</form>
</div>
<?php
include './templates/footer.php';
