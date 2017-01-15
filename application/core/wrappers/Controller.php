<?php
namespace Jesh\Core\Wrappers;

use \CI_Controller;

class Controller extends CI_Controller {

    protected function RenderView($page, $data = NULL)
    {
        $this->load->view($page, $data);
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
}
