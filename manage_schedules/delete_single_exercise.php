<?php ob_start();
/**
 * Created by PhpStorm.
 * User: matte
 * Date: 05/04/2018
 * Time: 10:44
 */
try{
    //include database connection
    include '../DbConnect.php';
    $conn = new DbConnect();
    $mysqli = $conn->connect();

    // isset() is a PHP function used to verify if a value is there or not
    $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

    // delete query
    $query = $mysqli->prepare("DELETE FROM exercise_list WHERE id_list = ?");
    $query->bind_param('i',$id);

    // Execute the query
    if($query->execute() === true){
        header('Location: manage_users.php?action=deleted');
    }else{
        die('Unable to delete record.');
    }

}

    // show error
catch (mysqli_sql_exception $e) {
    throw $e;
}
?>