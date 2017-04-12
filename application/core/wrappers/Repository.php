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

    protected function Get(
        $table_name, $column_name, $conditions = array(), $orders = array())
    {
        $this->db->select($column_name);
        foreach($conditions as $column => $value) {
            $this->db->where($column, $value);   
        }
        foreach($orders as $column => $order) {
            $this->db->order_by($column, $order);
        }
        $query = $this->db->get($table_name);

        if($query === false)
        {
            throw new \Exception($this->db->last_query());
        }
        else
        {
            return $query->result_array();
        }
    }

    protected function Find($table_name, $column_name, $condition_array)
    {
        $this->db->select($column_name);
        $this->db->from($table_name);
        foreach($condition_array as $column => $value) {
            $this->db->where($column, $value);   
        }
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

    protected function Update(
        $table_name, $condition_array, ModelInterface $object
    )
    {
        foreach($condition_array as $column => $value) {
            $this->db->where($column, $value); 
        }

        foreach($object as $key => $value)
        {
            if(!isset($object->$key))
            {
                unset($object->$key);
            }
        }

        return $this->db->update($table_name, $object);
    }
}
