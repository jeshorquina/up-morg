<?php
namespace Jesh\Helpers;

Class PageRenderer
{
    public static function HasAdminPageAccess($base_url, $uri)
    {
        if($uri === "admin/login") 
        {
            if(Session::Find("admin_data"))
            {
                self::Redirect($base_url."admin");
            }
        }
        else 
        {
            if(!Session::Find("admin_data"))
            {
                self::Redirect($base_url."admin/login");
            }
        }

        return true; 
    }

    public static function HasUserPageAccess($base_url, $page_type)
    {
        $flags = json_decode(Session::Get("user_data"), true)["flags"];

        if(!$flags["is_batch_member"])
        {
            if($page_type !== "request-batch")
            {
                self::Redirect($base_url."request/batch");
            }
            else
            {
                return true;
            }
        }
        else if(!$flags["is_committee_member"] && !$flags["is_frontman"]) 
        {
            if($page_type !== "request-committee")
            {
                self::Redirect($base_url."request/committee");
            }
            else
            {
                return true;
            }
        }

        if($page_type === "request-batch" || $page_type === "request-committee")
        {
            self::Redirect($base_url);
        }
        
        if(!$flags["is_committee_head"] && !$flags["is_frontman"])
        {
            if($page_type === "batch-member")
            {
                self::Redirect($base_url);
            }
        }
        
        if(!$flags["is_finance"] && $page_type === "finance")
        {
            self::Redirect($base_url);
        }

        return true;
    }

    public static function GetAdminPageData(
        $base_url, $page_name, $other_details, $has_nav = true
    )
    {
        $page_array = array();
        foreach($other_details as $array)
        {
           $page_array = array_merge($page_array, $array);
        }

        if($has_nav)
        {
            return array_merge_recursive(
                $page_array,
                array(
                    "page" => array_merge(
                        self::GetAdminNavigationLinks($base_url),
                        self::GetAdminPageURLs($base_url, $page_name)
                    )
                )
            );
        }
        else 
        {
            return array_merge_recursive(
                $page_array,
                array(
                    "page" => self::GetAdminPageURLs($base_url, $page_name)
                )
            );
        }
    }

    public static function GetUserPageData(
        $base_url, $page_name, $other_details
    )
    {
        $page_array = array();
        foreach($other_details as $array)
        {
           $page_array = array_merge($page_array, $array);
        }

        return array_merge_recursive(
            $page_array,
            array(
                "page" => array_merge(
                    self::GetUserNavigationLinks($base_url, $page_name),
                    self::GetUserPageURLs($base_url, $page_name)
                )
            )
        );
    }

    private static function GetUserNavigationLinks($base_url, $page_name)
    {
        if($page_name === "request-batch" || $page_name === "request-committee")
        {
            return array(
                "nav" => array(
                    array(
                        "name" => "Logout",
                        "url" => sprintf("%s%s", $base_url, 'action/logout')
                    )
                )
            );
        }

        $navs = array(
            array(
                "name" => "Task Manager",
                "url" => sprintf("%s%s", $base_url, 'task')
            ),
            array(
                "name" => "Availability Tracker",
                "url" => sprintf("%s%s", $base_url, 'availability')
            ),
            array(
                "name" => "Calendar",
                "url" => sprintf("%s%s", $base_url, 'calendar')
            ),
        );

        $flags = json_decode(Session::Get("user_data"), true)["flags"];
        
        if($flags["is_finance"])
        {
            $navs[] = array(
                "name" => "Finance Tracker",
                "url" => sprintf("%s%s", $base_url, 'finance')
            );
        }
        
        if($flags["is_committee_head"] || $flags["is_frontman"])
        {
            $navs[] = array(
                "name" => "Manage Members",
                "url" => sprintf("%s%s", $base_url, 'member')
            );
        }

        $navs[] = array(
            "name" => "Logout",
            "url" => sprintf("%s%s", $base_url, 'action/logout')
        );

        return array("nav" => $navs);
    }

    private static function GetAdminNavigationLinks($base_url)
    {
        return array(
            "nav" => array(
                array(
                    "name" => "Manage Batch",
                    "url" => sprintf("%s%s", $base_url, 'admin/batch')
                ),
                array(
                    "name" => "Manage Members",
                    "url" => sprintf("%s%s", $base_url, 'admin/member')
                ),
                array(
                    "name" => "Change Password",
                    "url" => sprintf("%s%s", $base_url, 'admin/account/password')
                ),
                array(
                    "name" => "Logout",
                    "url" => sprintf("%s%s", $base_url, 'action/admin/logout')
                )
            )
        );
    }

    private static function GetUserPageURLs($base_url, $page_name)
    {
        return self::GetPageURLs($base_url, "user", "", $page_name);
    }

    private static function GetAdminPageURLs($base_url, $page_name)
    {
        return self::GetPageURLs($base_url, "admin", "admin", $page_name);
    }

    private static function GetPageURLs(
        $base_url, $page_type, $index, $page_name
    )
    {
        $urls = array();

        $urls["base"] = $base_url;
        $urls["index"] = sprintf("%s%s", $base_url, $index);

        $stylesheet = sprintf("public/css/%s/%s.css", $page_type, $page_name);
        if(file_exists($stylesheet))
        {
            $urls["stylesheet"] = sprintf("%s%s", $base_url, $stylesheet);
        }
        else
        {
            $urls["stylesheet"] = "";
        }

        $script = sprintf("public/js/%s/%s.js", $page_type, $page_name);
        if(file_exists($script))
        {
            $urls["script"] = sprintf("%s%s", $base_url, $script);
        }
        else
        {
            $urls["script"] = "";
        }

        return array("urls" => $urls);
    }

    private static function Redirect($url)
    {
        header("Location: " . $url);
        exit();
    }
}