<?php
namespace Jesh\Core\Wrappers;

use \CI_Controller;

class Controller extends CI_Controller {

    protected function view($page, $data = NULL)
    {
        $this->load->view($page, $data);
    }
}
