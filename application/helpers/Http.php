<?php 
namespace Jesh\Helpers;

Class Http{
    const GET  = INPUT_GET;
    const POST = INPUT_POST;

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
            case self::POST:
                return self::GetPreparedValue($type, $key);
            default:
                throw new \Exception("HTTP Method not supported.");
        }
    }

    private static function GetPreparedValue($type, $key)
    {
         // we do not filter input unless put in database 
         // (i.e. sql injection) or used as a 
         // browser output (i.e. XSS)
        return filter_input($type, $key, FILTER_DEFAULT);
    }

    public static function Response($status, $mixed)
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
        $array["data"] = $mixed;

        self::SendJSONResponse($status, $array);
    }

    private static function SendJSONResponse($status, $array)
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

