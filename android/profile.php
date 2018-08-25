<?php

//include database connection
include '../DbConnect.php';
$conn = new DbConnect();
$mysqli = $conn->connect();
$response = array();

// read current record's data
if(isset($_POST['id_user']) and isset($_POST['token'])){
    try {
        // prepare select query
        $query = $mysqli->prepare("SELECT id_user, name, surname, email, birth_date, address, image, id_subscription FROM user WHERE id_user = '".$_POST['user_id']."' 
                        and token_auth = '".$_POST['token']."' LIMIT 0,1");

        $query->bind_param("s",$email);
        $query->execute();
        $query->store_result();
        $num_rows = $query->num_rows;
        if($num_rows > 0){
            $row = $query->get_result();
            while($result = $row->fetch_assoc()) {
                $response['name'] = $result['name'];
                $response['surname'] = $result['surname'];
                $response['email'] = $result['email'];
                $response['birthdate'] = $result['birth_date'];
                $response['address'] = $result['address'];
                $response['subscription'] = $result['id_subscription'];
                $response['image'] = $result['image'];
            }
        }
    }
    // show error
    catch (mysqli_sql_exception $e) {
        throw $e;
    }
    echo json_encode($response);
}

?>
