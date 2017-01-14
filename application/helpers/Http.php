<?php 
namespace Jesh\Helpers;

Class Http {
    
    const GET  = 1;
    const POST = 2;

    const OK                    = 200;
    const CREATED               = 201;
    const BAD_REQUEST           = 400;
    const UNPROCESSABLE_ENTITY  = 422;
    const INTERNAL_SERVER_ERROR = 500;

    public static function Request($type, $key)
    {
        switch($type)
        {
            case self::GET:
                return $_GET[$key];
            case self::POST:
                return $_POST[$key];
            default:
                throw new \Exception("HTTP Method not supported.");
        }
    }

    public static function Response($status, $message)
    {
        $array = array();
        switch($status)
        {
            case self::INTERNAL_SERVER_ERROR:
                $array["status"] = "(500) INTERNAL SERVER ERROR";
                break;
            case self::UNPROCESSABLE_ENTITY:
                $array["status"] = "(422) UNPROCESSABLE ENTITY";
                break;
            case self::BAD_REQUEST:
                $array["status"] = "(400) BAD REQUEST";
                break;
            case self::CREATED:
                $array["status"] = "(201) CREATED";
                break;
            case self::OK:
                $array["status"] = "(200) OK";
                break;
            default:
                throw new \Exception("HTTP Status not supported.");
        }
        $array["message"] = $message;

        self::SendJSON($status, $array);
    }

    private static function SendJSON($status, $array)
    {
        // set response status code
        http_response_code($status);
        
        // set headers
        header('Content-type: application/json');
        
        // Set body
        echo json_encode($array);

        // Exit
        exit();
    }
}

