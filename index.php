<?php
include './private/config.php';
include './templates/header.php';
include './templates/nav.php';

if(isset($_SESSION['user'])){
    unset($_SESSION['loginError']);
    unset($_SESSION['registerError']);
    echo var_export($_SESSION['user'],true);
}

?>

<?php
include './templates/footer.php';

