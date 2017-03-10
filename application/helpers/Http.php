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
        self::SendJSONResponse($status, $mixed);
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

