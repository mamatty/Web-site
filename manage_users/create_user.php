<?php
/* Displays user information and some useful messages */
session_start();

// Check if user is logged in using the session variable
if ( isset($_SESSION['logged_in']) and $_SESSION['logged_in'] == true) {
// Makes it easier to read
$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Fitness Club</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" media="screen" href="css/reset.css">
        <link rel="stylesheet" type="text/css" media="screen" href="css/style.css">
        <link rel="stylesheet" type="text/css" media="screen" href="css/grid_12.css">

        <script src="js/jquery-1.7.min.js"></script>
        <script src="js/jquery.easing.1.3.js"></script>
        <script src="js/tms-0.3.js"></script>
        <script src="js/tms_presets.js"></script>
        <script src="js/cufon-yui.js"></script>
        <script src="js/Asap_400.font.js"></script>
        <script src="js/Coolvetica_400.font.js"></script>
        <script src="js/Kozuka_M_500.font.js"></script>
        <script src="js/cufon-replace.js"></script>
        <script src="js/FF-cash.js"></script>

        <!--[if lt IE 9]>
        <script src="js/html5.js"></script>
        <link rel="stylesheet" type="text/css" media="screen" href="css/ie.css">
        <![endif]-->
        <!-- Latest compiled and minified Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

    </head>
    <body>

    <!--==============================header=================================-->
    <!-- container -->
    <div class="main">
        <div class="bg-img"></div>
        <header>
            <h1><a href="../fitness-club/index.php">Fitness <strong>Club.</strong></a></h1>
            <nav>
                <div class="social-icons"> <a href="#" class="icon-2"></a> <a href="#" class="icon-1"></a> </div>
                <ul class="menu">
                    <li><a href="../fitness-club/index.php">Home</a></li>
                    <li class="current"><a href="manage_users.php">Manage Users</a></li>
                    <li><a href="../manage_schedules/manage_users.php">Manage Schedules</a></li>
                    <li><a href="../send_messages/read_messages.php">Send Messages</a></li>
                    <li><a href="dashboard.html">Dashboard</a></li>
                </ul>
            </nav>
        </header>

        <?php
    /**
     * Created by PhpStorm.
     * User: matte
     * Date: 29/03/2018
     * Time: 11:37
     */
        if($_POST){

            // include database connection
            include '../DbConnect.php';
            include '../DbOperation.php';
            $conn = new DbConnect();
            $mysqli = $conn->connect();

            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $email = $_POST['email'];
            $password = $_POST["password"];
            $address = $_POST['address'];
            $birthdate = $_POST['birthdate'];
            $phone = $_POST['phone'];
            $subscription = $_POST['subscription'];
            $tipology = $_POST['tipology'];
            $image=!empty($_FILES["image"]["name"])
                ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                : "";

            $db = new DbOperation();
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            if(!empty($name) and !empty($surname) and !empty($email) and !empty($passwordHash) and !empty($address) and !empty($birthdate) and !empty($subscription) and !empty($tipology)){
                $result = $db->registerOperation($name, $surname, $email, $passwordHash, $address,  $birthdate, $phone, $image, $subscription, $tipology, $token=null);

                if($result == 0){
                    echo "<div class='alert alert-success'>User correctly registered was saved.</div>";
                    // now, if image is not empty, try to upload the image
                    if($image){

                        // sha1_file() function is used to make a unique file name
                        $target_directory = "uploads/";
                        $target_file = $target_directory . $image;
                        $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

                        // error message is empty
                        $file_upload_error_messages="";
                        // make sure that file is a real image
                        $check = getimagesize($_FILES["image"]["tmp_name"]);
                        if($check!==false){
                            // submitted file is an image
                        }else{
                            $file_upload_error_messages.="<div>Submitted file is not an image.</div>";
                        }
                        // make sure certain file types are allowed
                        $allowed_file_types=array("jpg", "jpeg", "png", "gif");
                        if(!in_array($file_type, $allowed_file_types)){
                            $file_upload_error_messages.="<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
                        }
                        // make sure file does not exist
                        if(file_exists($target_file)){
                            $file_upload_error_messages.="<div>Image already exists. Try to change file name.</div>";
                        }
                        // make sure submitted file is not too large, can't be larger than 1 MB
                        if($_FILES['image']['size'] > (1024000)){
                            $file_upload_error_messages.="<div>Image must be less than 1 MB in size.</div>";
                        }
                        // make sure the 'uploads' folder exists
                        // if not, create it
                        if(!is_dir($target_directory)){
                            mkdir($target_directory, 0777, true);
                        }
                        // if $file_upload_error_messages is still empty
                        if(empty($file_upload_error_messages)){
                            // it means there are no errors, so try to upload the file
                            if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
                                // it means photo was uploaded
                            }else{
                                echo "<div class='alert alert-danger'>";
                                echo "<div>Unable to upload photo.</div>";
                                echo "<div>Update the record to upload photo.</div>";
                                echo "</div>";
                            }
                        }

                        // if $file_upload_error_messages is NOT empty
                        else{
                            // it means there are some errors, so show them to user
                            echo "<div class='alert alert-danger'>";
                            echo "<div>{$file_upload_error_messages}</div>";
                            echo "<div>Update the record to upload photo.</div>";
                            echo "</div>";
                        }
                    }
                }elseif($result == 2){
                    echo "<div class='alert alert-danger'>User already exists.</div>";
                }else{
                    echo "<div class='alert alert-danger'>User not registered.</div>";
                }
            }else{
                echo "<div class='alert alert-danger'>Fill all the fields.</div>";
            }


        }
        ?>
        <!-- html form here where the product information will be entered -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><input type='text' name='name' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Surname</td>
                    <td><input type='text' name='surname' class='form-control'></textarea></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type='email' name='email' class='form-control'></textarea></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type='password' name='password' class='form-control'></textarea></td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td><input type='text' name='address' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Birth date</td>
                    <td><input type='date' name='birthdate' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Phone</td>
                    <td><input type='number' name='phone' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Subscription</td>
                    <td><input type='text' name='subscription' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Tipology</td>
                    <td><input type='text' name='tipology' value="subscriber" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Photo</td>
                    <td><input type="file" name="image" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href='manage_users.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>
        </form>

        <footer>
            <p>© 2018 Fitness Club</p>
            <p>Design for Smart Gym</p>
        </footer>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    <!-- Latest compiled and minified Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


    </body>
    </html>
    <?php
}
else {

    ?><!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <style>
        .button {
            background-color: #518daf;
            border: none;
            color: white;
            padding: 7px 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            margin-left: 660px;
            margin-top: 19px;
            width: 84px;
            height: 40px;
        }
    </style>
    <?php
    echo "<div align='center' class='alert alert-danger'>You must be logged to view this page.</div>";
    echo "<a href=\"../login_website/index.php\"><button class=\"button\"><span>Log In</span>
                        </button></a>";
}
?>