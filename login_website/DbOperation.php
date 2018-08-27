<?php
/**
 * Created by PhpStorm.
 * User: matte
 * Date: 27/08/2018
 * Time: 12:04
 */

include_once dirname(__FILE__) . '../Config.php';


class DbOperation{

    public function login($email, $password){

        $data = array(
          'email' => $email,
          'password' => $password
        );

        $options = array(
            'http' => array(
                'header'  => array(
                    "Content-type: application/x-www-form-urlencoded",
                    "Authorization: "
                ),
                'method' => 'GET',
                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($options);

        $sFile = file_get_contents(GENERALI, False, $context);

        return $sFile;
    }

    public function logout(){

        $options = array(
            'http' => array(
                'header'  => array(
                    "Content-type: application/x-www-form-urlencoded",
                    "Authorization: "
                ),
                'method' => 'GET',
            )
        );
        $context = stream_context_create($options);

        $sFile = file_get_contents(GENERALI, False, $context);

        return $sFile;
    }

    public function register_account($email, $first_name, $last_name, $password){

        $data = array(
            'email' => $email,
            'password' => $password,
            'first_name' => $first_name,
            'last_name' => $last_name
        );

        $options = array(
            'http' => array(
                'header'  => array(
                    "Content-type: application/x-www-form-urlencoded",
                    "Authorization: "
                ),
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($options);

        $sFile = file_get_contents(GENERALI, False, $context);

        return $sFile;
    }

}