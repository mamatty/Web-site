<?php
/**
 * Created by PhpStorm.
 * User: matte
 * Date: 27/08/2018
 * Time: 12:04
 */

include_once dirname(__FILE__) . '../Config.php';


class DbOperation{

    public function autocomplete_message($title){

        $data = array(
          'title' => $title
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

    public function create_exercise($title, $body, $send_date, $destination){

        $data = array(
            'title' => $title,
            'body' => $body,
            'send_date' => $send_date,
            'destination' => $destination
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

    public function delete_user($id){

        $data = array(
            'id' => $id
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

    public function read_messages($records_per_page, $from_record_num){

        $data = array(
            'records_per_page' => $records_per_page,
            'from_record_num' => $from_record_num
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

    public function read_one_message($id){

        $data = array(
            'id' => $id
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

    public function search_message($title, $records_per_page, $from_record_num){

        $data = array(
            'title' => $title,
            'records_per_page' => $records_per_page,
            'from_record_num' => $from_record_num
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
}