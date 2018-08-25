<?php
/* User login_website process, checks if user exists and password is correct */
require_once "../DbConnect.php";
$conn = new DbConnect();
$mysqli = $conn->connect();

// Escape email to protect against SQL injections
$email = $mysqli->escape_string($_POST['email']);
$stmt = $mysqli->prepare("SELECT first_name, last_name, password FROM account WHERE email=?");
$stmt->bind_param('s',$email);
$result = $stmt->execute();
$stmt->store_result();

if ( $stmt->num_rows == 0 ){ // User doesn't exist
    $_SESSION['message'] = "User with that email doesn't exist!";
    header("location: error.php");
}
else { // User exists
    $stmt->bind_result($first_name, $last_name, $password);
    while($user = $stmt->fetch()){
        if ( password_verify($_POST['password'], $password) ) {

            $_SESSION['email'] = $email;
            $_SESSION['first_name'] = $first_name;
            $_SESSION['last_name'] = $last_name;

            // This is how we'll know the user is logged in
            $_SESSION['logged_in'] = true;

            header("location: ../fitness-club/index.php");
        }
        else {
            print_r($_POST['password'].' '.$user['password']);
            //$_SESSION['message'] = "You have entered wrong password, try again!";
            //header("location: error.php");
        }
    }
    $stmt->close();
}

