<?php
namespace Jesh\Core\Wrappers;

use \CI_Model;
use \Jesh\Core\Interfaces\ModelInterface;

abstract class Repository extends CI_Model {

    public function __construct()
    { 
        $this->load->database();
    }

    public function __destruct()
    {
        unset($this->db);
    }

    protected function Get($table_name, $column_name, $condition_array)
    {
        $this->db->select($column_name);
        foreach($condition_array as $column => $value) {
            $this->db->where($column, $value);   
        }
        $query = $this->db->get($table_name);
        return $query->result_array();   
    }

    protected function Find($table_name, $column_name, $value)
    {
        $this->db->select($column_name);
        $this->db->from($table_name);
        $this->db->where($column_name, $value);
        return ($this->db->count_all_results() > 0);
    }

    protected function Insert($table_name, ModelInterface $object)
    {
        return $this->db->insert($table_name, $object);
    }

    protected function Delete($table_name, $column_name, $value)
    {
        $this->db->where($column_name, $value);
        return $this->db->delete($table_name);
    }

    protected function Update($table_name, $condition_array, $update_array)
    {
        foreach($condition_array as $column => $value) {
            $this->db->where($column, $value); 
        }
        return $this->db->update($table_name, $update_array);
    }
}
