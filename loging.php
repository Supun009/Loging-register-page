<?php
if (isset($_POST["submit"])){
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];

    require_once 'dbh.php';
    require_once 'function.php';

   
    $emptyInput = emptyInputsLogin($email, $pwd);

    if (emptyInputsLogin($email, $pwd) !== false) {
        header("Location:loging.html?error=invalidlogin");
        exit();
    }
    LogingUser($conn, $email, $pwd);


}
else {
    header('location:home.html');
}