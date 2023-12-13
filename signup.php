<?php

if (isset($_POST["submit"])){
    $username = $_POST["uname"];
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["prepeat"];

    require_once 'dbh.php';
    require_once 'function.php';


    $emptyInput = emptyInputsSignup($username, $email, $pwd, $pwdRepeat); 
    $invalidUsername = invalidUsername($username);
    $invalidEmail = invalidEmail($email);
    $pwdMatch = pwdMatch($pwd, $pwdRepeat);
    $uidExists = uidExists($conn, $username, $email);

    if ($emptyInput !== false) {
        header("Location:signup.html?error=emptyinput");
        exit();
    }

    if ($invalidUsername !== false) {
        header("Location:signup.html?error=invalidUSername");
        exit();
    }

    if ($invalidEmail !== false) {
        header("Location:signup.html?error=invalidEmail");
        exit();
    }

    if ($pwdMatch !== false) {
        header("Location:signup.html?error=passworddontmatch");
        exit();
    }

    if ($uidExists !== false) {
        header("Location:signup.html?error=usernametaken");
        exit();
    }

    creatUser($conn, $username, $email, $pwd);
    exit();


} 
else {
    header('Location:loging.html');
    exit();
}
