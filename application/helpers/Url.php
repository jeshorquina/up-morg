<?php
namespace Jesh\Helpers;

class Url
{
    public static function GetBaseURL($uri = "")
    {
        return base_url($uri);
    }

    public static function GetCurrentURI()
    {
        return uri_string();
    }

    public static function Redirect($uri = "")
    {
        header("Location: " . self::GetBaseURL($uri));
        exit();
    }

    protected function PageNotFound()
    {
        show_404();
    }
}
