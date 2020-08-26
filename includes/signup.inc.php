<?php
if (isset($_POST['signup-submit'])) {

    require 'dbh.inc.php';

    $username = $_POST['uid'];
    $email = $_POST['mail'];
    $rollno = $_POST['roll'];
    $password = $_POST['pwd'];
    $passwordRepeat = $_POST['pwd-repeat'];

    if (empty($username) || empty($email) || empty($rollno) || empty($password) || empty($passwordRepeat)) {
        header("Location: ../signup.php?error=emptyfields&uid=".$username. "&mail=".$email);
        exit();
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)){
        header("Location: ../signup.php?error=invalidmailuid");
        exit(); 
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../signup.php?error=invalidmail&uid=".$username);
        exit();
    }
    else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../signup.php?error=invaliduid&mail=".$email);
        exit();
    }
    elseif ($password !== $passwordRepeat) {
        header("Location: ../signup.php?error=passwordcheck&uid=".$username. "&mail=".$email);
        exit(); 
    }
    else{
        $sql = "SELECT uidUsers From users where uidUsers=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../signup.php?error=sqlerror");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
            if ($resultCheck > 0) {
                header("Location: ../signup.php?error=usertaken&mail=".$email);
            exit();
            }
            else{
                $sql = "INSERT Into users(uidUsers, emailUsers, rollUsers, pwdUsers) Values(?,?,?,?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../signup.php?error=sqlerror");
                    exit();
                }
                else{
                    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $rollno, $hashedPwd);
                    mysqli_stmt_execute($stmt);
                    header("Location: ../signup.php?signup=success");
                    exit();
                }
            }
        }


    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

}

else{
    header("Loaction: ../signup.php");
     exit();
}