<?php
/**
 * Created by PhpStorm.
 * User: matte
 * Date: 19/03/2018
 * Time: 11:47
 */

class DbOperation
{
//Database connection link
    private $con;

    //Class constructor
    function __construct()
    {
        //Getting the DbConnect.php file
        require_once dirname(__FILE__) . '/DbConnect.php';

        //Creating a DbConnect object to connect to the database
        $db = new DbConnect();

        //Initializing our connection link of this class
        //by calling the method connect of DbConnect class
        $this->con = $db->connect();
    }

    //storing token in database
    public function registerOperation($name, $surname, $email, $passwordHash, $address, $birthdate, $phone, $image, $subscription, $tipology, $token){
        if(!$this->isEmailExist($email)){
            $stmt = $this->con->prepare("INSERT INTO user (name, surname, email, password, address, birth_date, phone, image, subscription, tipology, token_firebase) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss",$name, $surname, $email, $passwordHash, $address, $birthdate,$phone, $image, $subscription, $tipology, $token);
            if($stmt->execute())
                return 0; //return 0 means success
            return 1; //return 1 means failure
        }else{
            return 2; //returning 2 means email already exist
        }
    }

    //the method will check if email already exist
    private function isEmailexist($email){
        $stmt = $this->con->prepare("SELECT id_user FROM user WHERE email = ?");
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    //getting all tokens to send push to all devices
    public function getAllTokens(){
        $stmt = $this->con->prepare("SELECT token_firebase FROM user");
        $stmt->execute();
        $result = $stmt->get_result();
        $tokens = array();
        while($token = $result->fetch_assoc()){
            array_push($tokens, $token['token']);
        }
        return $tokens;
    }

    //getting a specified token to send push to selected device
    public function getTokenByID($ids){
        $tokens = array();
        foreach ($ids as $id){
            $stmt = $this->con->prepare("SELECT token_firebase FROM user WHERE id_user = ?");
            $stmt->bind_param("s",$id);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            array_push($tokens,$result['token']);
        }
        return $tokens;
    }

    //getting all the registered devices from database
    public function getAllUsers(){
        $stmt = $this->con->prepare("SELECT * FROM user");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    //cryting for the authentication token
    public function crypto_rand_secure($min, $max){
        $range = $max - $min;
        if ($range < 1) return $min;
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1;
        $bits = (int) $log + 1;
        $filter = (int) (1 << $bits) - 1;
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter;
        } while ($rnd > $range);
        return $min + $rnd;
    }

    //generating the authentication token of length equal to 21
    public function generateToken($length = 21){
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet); // edited

        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[$this->crypto_rand_secure(0, $max-1)];
        }
        return $token;
    }
}