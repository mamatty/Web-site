<?php
/**
 * Created by PhpStorm.
 * User: matte
 * Date: 19/03/2018
 * Time: 11:48
 */
    require("../password.php");
    require_once '../DbConnect.php';
    include '../DbOperation.php';

    $conn = new DbConnect();
    $mysqli = $conn->connect();
    
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    $statement = mysqli_prepare($mysqli, "SELECT name, surname, email, password, active, id_user FROM user WHERE email = ?");
    mysqli_stmt_bind_param($statement, "s", $email);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $colName, $colSurname, $colEmail, $colPassword, $colActive, $colUserID);
    
    $response = array();
    $response["success"] = false;
    $gen = false;

    if ($colActive == 0){
        while(mysqli_stmt_fetch($statement)){
            if (password_verify($password, $colPassword)) {
                while ($gen = false){
                    $operation = new DbOperation();
                    $token = $operation ->generateToken();
                    $active = 1;
                    $statement =  $mysqli->prepare("UPDATE user,schedules SET token_auth = ?,active = ? WHERE id_user =?");
                    $statement->bind_param("sii", $token,$active,$colUserID);
                    if ($statement->execute()) {
                        $sql_title = $mysqli->prepare("SELECT token_auth FROM user WHERE email = ?");
                        $sql_title->bind_param("s", $email);
                        $sql_title->execute();
                        $result = $sql_title->get_result();
                        while($row = $result->fetch_assoc()) {
                            if($row['token_auth'] == $token) {
                                $gen = true;
                            }
                        }
                    }
                }
                $response["success"] = true;
                $response["name"] = $colName;
                $response["surname"] = $colSurname;
                $response["email"] = $colEmail;
                $response["token"] = $token;
                $response["id_user"] = $colUserID;
            }
        }
    }
    else{
        $response["success"] = false;
    }

    echo json_encode($response);
?>