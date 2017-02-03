<?php
namespace Jesh\Core\Wrappers;

use \CI_Controller;

class Controller extends CI_Controller {

    private $page_components;

    protected function SetHeader($pages)
    {
        if (strtolower(gettype($pages)) !== "string")
        {
            foreach($pages as $header) 
            {
                $this->page_components["header"][] = $header;
            }
        }
        else 
        {
            $this->page_components["header"][] = $pages;
        }
    }

    protected function SetFooter($pages)
    {
        if (strtolower(gettype($pages)) !== "string")
        {
            foreach($pages as $header) 
            {
                $this->page_components["footer"][] = $footer;
            }
        }
        else 
        {
            $this->page_components["footer"][] = $pages;
        }
    }

    protected function SetBody($pages)
    {
        if (strtolower(gettype($pages)) !== "string")
        {
            foreach($pages as $body) 
            {
                $this->page_components["body"][] = $body;
            }
        }
        else 
        {
            $this->page_components["body"][] = $pages;
        }
    }

    protected function RenderView($data = NULL)
    {
        $first = True;
        foreach(array("header", "body", "footer") as $component_key) 
        {
            if(array_key_exists($component_key, $this->page_components)) 
            {
                foreach($this->page_components[$component_key] as $component) 
                {
                    if($first) 
                    {
                        $this->load->view($component, $data);
                        $first = False;
                    }
                    else 
                    {
                        $this->load->view($component);
                    }
                }
            }
        }
    }

    protected function InitializeOperations($class_name)
    {
        // initialize operations class in
        // a variable with namespace
        $class_name = "\\Jesh\\Operations\\" . trim($class_name);

        // return new instance of the variable
        // name representing the class
        return new $class_name;
    }

    protected function Redirect($uri)
    {
        header("Location: " . base_url($uri));
        exit();
    }
}
