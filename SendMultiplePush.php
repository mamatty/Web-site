<?php
/**
 * Created by PhpStorm.
 * User: matte
 * Date: 20/03/2018
 * Time: 12:37
 */

class SendMultiplePush{

    public function sendNotification($title, $body, $image=null,$destination, $argument = null){

        //importing required files
        require_once 'DbOperation.php';
        require_once 'Firebase.php';
        require_once 'Push.php';

        $response = array();

        //creating a new push
        $push = null;
        //first check if the push has an image with it
        if($image != null){
            $push = new Push(
                $title,
                $body,
                $image
            );
        }else{
            //if the push don't have an image give null in place of image
            $push = new Push(
                $title,
                $body,
                null
            );
        }
        if($destination =='topic') {
            //getting the push from push object
            $mPushNotification = $push->getPush();

            //creating firebase class object
            $firebase = new Firebase();

            //sending push notification and displaying result
            echo $firebase->send_topic($argument, $mPushNotification);
        }
        else{
            $response['error']=true;
            $response['message']='Parameters missing or invalid request!';
        }
        return json_encode($response);
    }

}
