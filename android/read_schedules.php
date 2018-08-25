<?php
/**
         * Created by PhpStorm.
         * User: matte
         * Date: 29/03/2018
         * Time: 12:55
         */

// include database connection
include '../DbConnect.php';

$conn = new DbConnect();
$mysqli = $conn->connect();

if(isset($_POST['id_user']) and isset($_POST['token'])){

    $query = "SELECT * FROM schedules WHERE id_user ='".$_POST['id_user']."' and token_auth = '".$_POST['token']."' ORDER BY end_date DESC";
    $result = $mysqli->query($query);

    //check if more than 0 record found
    if (mysqli_num_rows($result)){

        while ($row = $result->fetch_assoc()){
            $query1 = "SELECT day,ripetitions,weight,details FROM exercise_list WHERE id_schedule ='".$row['id_schedule']."'";
            $result1 = $mysqli->query($query1);

            $query2 = "SELECT name,description,muscolar_zone,url FROM exercise WHERE id_exercise ='".$row['id_exercise']."'";
            $result2 = $mysqli->query($query2);
        }
    }
    echo json_encode($result1);
    echo json_encode($result2);
}


