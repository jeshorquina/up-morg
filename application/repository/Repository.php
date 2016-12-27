<?php
namespace Jesh\Repository;

use CI_Model;

use \Jesh\Models\ModelInterface;

abstract class Repository extends CI_Model {

    public function __construct()
    { 
        $this->load->database();
    }

    public function __destruct()
    {
        unset($this->db);
    }

    protected function insert($table_name, ModelInterface $object)
    {
        $this->db->insert($table_name, $object);
    }
}
