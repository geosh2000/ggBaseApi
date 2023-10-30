<?php

    function gg_response( $code, $data, $type = 'json' ){

        $response = \Config\Services::response();

        $response->setStatusCode($code);

        switch( $type ){
            case 'json':
                $response->setJSON($data);
                break;
            case 'xml':
                $response->setXML($data);
                break;
            case 'html':
                $response->setBody($data);
                break;
            default:    
                $response->setBody($data);
                break;
        }

        $response->send();
        die();

    }

    function gg_die( $msg ){
        $response = \Config\Services::response();

        $response->setStatusCode(401)->setJson(array("msg" => $msg))->send();
        die();
    }

    function ifEmpty( $data, $msg = null ){

        if( $msg == null ){
            $msg = "No se encontraron registros";
        }

        if( empty($data) ){
            $json = array(
                "msg" => $msg
            );
            gg_response(400, $json);
        }

    }


?>