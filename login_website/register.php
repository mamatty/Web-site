<?php ob_start();
/* Registration process, inserts user info into the database 
   and sends account confirmation email message
 */
require_once "../DbConnect.php";
$conn = new DbConnect();
$mysqli = $conn->connect();

// Set session variables to be used on profile.php page
$_SESSION['email'] = $_POST['email'];
$_SESSION['first_name'] = $_POST['firstname'];
$_SESSION['last_name'] = $_POST['lastname'];

// Escape all $_POST variables to protect against SQL injections
$first_name = $mysqli->escape_string($_POST['firstname']);
$last_name = $mysqli->escape_string($_POST['lastname']);
$email = $mysqli->escape_string($_POST['email']);
$password = $mysqli->escape_string(password_hash($_POST['password'], PASSWORD_BCRYPT));
//$hash = $mysqli->escape_string( md5( rand(0,1000) ) );
      
// Check if user with that email already exists
$result = $mysqli->prepare("SELECT * FROM account WHERE email= ?");
$result->bind_param("s",$email);
$result->execute();
$result->store_result();

// We know user email exists if the rows returned are more than 0
if ( $result->num_rows > 0 ) {
    
    $_SESSION['message'] = 'User with this email already exists!';
    header("location: error.php");
    
}
else { // Email doesn't already exist in a database, proceed...
    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // active is 0 by DEFAULT (no need to include it here)
        $stmt = $mysqli->prepare("INSERT INTO account (first_name, last_name, email, password) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss", $first_name, $last_name, $email, $password);
        // Add user to the database
        if ($stmt->execute()) {

            $_SESSION['active'] = 1; //0 until user activates their account with verify.php
            $_SESSION['logged_in'] = true; // So we know the user has logged in

            header("location: profile.php");

        } else {
            $_SESSION['message'] = 'Registration failed!';
            header("location: error.php");
        }
    }
    else {
            $_SESSION['message'] = 'Registration failed, not a valid email, try again!';
            header("location: error.php");
    }
}