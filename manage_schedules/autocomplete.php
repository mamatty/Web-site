<?php
// include database connection
include '../DbConnect.php';

$conn = new DbConnect();
$mysqli = $conn->connect();

if(isset($_POST["query"]))
{
    $output = '';
    $param = "%{$_POST['query']}%";
    $query = $mysqli->prepare("SELECT surname FROM user WHERE surname LIKE ? LIMIT 5");
    $query->bind_param('s',$param);
    $query->execute();
    $query->store_result();
    $result = $query->num_rows;
    $output = '<ul class="list-unstyled">';
    if($result > 0)
    {
        $query->bind_result($surname);
        while($row = $query->fetch())
        {
            $output .= '<li>'.$surname.'</li>';
        }
    }
    else
    {
        $output .= '<li>User Not Found</li>';
    }
    $output .= '</ul>';
    echo $output;
}
