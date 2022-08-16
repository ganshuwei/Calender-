<?php
    session_start();
    require 'database.php';

    // generate session token - a 32-byte random string
    $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));

    $_SESSION['user'] = $mysqli->real_escape_string($_POST['username']);
    $_SESSION['post_failure'] = FALSE;
    
    $password = $mysqli->real_escape_string($_POST['pwd']);

    $stmt = $mysqli->prepare("SELECT COUNT(username), hashed_password FROM users WHERE username=?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt->bind_param('s', $_SESSION['user']);
    $stmt->execute();
    $stmt->bind_result($cnt, $pwd_hash);
    $stmt->fetch();

    // verify username and corresponding password
    if($cnt == 1 && password_verify($password, $pwd_hash)){
        header('Location: main.php');
        exit;
    } else{
        session_destroy();
        header('Location: date.html');

        exit;
    }
?>