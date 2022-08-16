<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Register</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
    <?php
    session_start();
    require 'database.php';

    $new_user = $mysqli->real_escape_string($_POST['new_user']);
    $pwd = $mysqli->real_escape_string($_POST['new_pwd']);
    $pwd_confirm = $mysqli->real_escape_string($_POST['confirm_pwd']);
    $pwd_hash = password_hash($pwd, PASSWORD_DEFAULT);

    // check if there is identical username in the db
    $stmt = $mysqli->prepare("SELECT COUNT(username) FROM users WHERE username=?");
    $stmt->bind_param('s', $new_user);
    $stmt->execute();
    $stmt->bind_result($cnt);
    $stmt->fetch();
    $stmt->close();

    $insert_stmt = $mysqli->prepare("INSERT into users (username, hashed_password) values (?, ?)");


    if(strlen($new_user) > 10 || !preg_match('/^[\w_\.\-]+$/', $new_user)) {
        echo "<h3>Invalid username.</h3>";
        echo "<h3>Please choose a username no more than 10 characters with only numbers and letters.</h3>";
    } else if($cnt > 0) {
        echo "<h3>User exists.</h3>";
        echo "<h3>Please choose another username.</h3>";
    } else if (strlen($pwd) > 10 || strlen($pwd) < 4){
        echo "<h3>Invalid password.</h3>";
        echo "<h3>Please choose a password between 4 and 10 characters.</h3>";
    } else if (strcmp($pwd, $pwd_confirm) !== 0){ 
        // check if two passwords are the same
        echo "<h3>Passwords don't match.</h3>";
        echo "<h3>Please enter identical passwords.</h3>";
    } else {
        if(!$insert_stmt){
          printf("Query Prep Failed: %s\n", $mysqli->error);
          exit;
        }
        $insert_stmt->bind_param('ss', $new_user, $pwd_hash);
        $insert_stmt->execute();
        $insert_stmt->close();
        session_start();
        $_SESSION['user'] = $new_user;
        $_SESSION['post_failure'] = FALSE;
        header("Location: date.html");
		exit;
    }
    echo "<br><a href='signup.html'>Go back to the Sign Up page</a>";
    ?>
    </body>
</html>