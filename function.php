<?php
function emptyInputsSignup($username, $email, $pwd, $pwdRepeat) {
    $result;
    if (empty($username) || empty($email) || empty($pwd) || empty($pwdRepeat)) {
        $result = true;
    } else {
        $result = false;
    }
        return  $result;
}

function invalidUsername($username) {
    $result;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email) {
    $result;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function pwdMatch($pwd, $pwdRepeat) {
    $result;
    if ($pwd !==  $pwdRepeat) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function uidExists($conn, $email) {
    $sql = "SELECT * FROM user WHERE user_name = ? OR user_email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:signup.html?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $username, $email );
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        return false;
    }

    mysqli_stmt_close($stmt);
}

function creatUser($conn, $username, $email, $pwd) {
    $sql = "INSERT INTO user (user_name, user_Email, user_Password) VALUES (?,?,?)";
      $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:signup.html?error=stmtfailed");
        exit();
    }
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location:loging.html?error=none");
    exit();
}

function emptyInputsLogin($email, $pwd) {
    $result;
    if (empty($email) || empty($pwd) ) {
        $result = true;
    } else {
        $result = false;
    }
        return  $result;
}

function LogingUser($conn, $email, $pwd) {
$uidExists =  uidExists($conn, $email);
if ($uidExists === false) {
    header ("Location: signup.html?error=wronglogin");
    exit();
}
$pwdHashed = $uidExists["user_password"];
$checkPwd = password_verify($pwd, $pwdHashed);

if ($checkPwd === false) {
header('Location:signup.html?error=wrongloging');
exit();
}

else if ($checkPwd === true) {
    session_start();
    $_SESSON["userid"] = $uidExists["user_id"];
    $_SESSON["username"] = $uidExists["user_name"];
    header('Location:home.html');
    exit();   
}
}

