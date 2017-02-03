<?php
namespace Jesh\Helpers;

Class ValidationDataBuilder
{
    private $valid;
    private $array;

    public function __construct()
    {
        $this->valid = true;
        $this->array = array();
    }

    public function CheckString($name, $data)
    {
        if(strtolower(gettype($data)) !== "string") 
        {
            throw new \Exception(sprintf("Input type incorrect for %s", $name));
        }
        else if(strlen($data) === 0) 
        {
            $this->valid   = false;
            $this->array[$name] = sprintf("Empty %s", $name);
            return true;
        }
        else 
        {
            return false;
        }
    }

    public function CheckEquals($name, $data1, $data2)
    {
        if($data1 !== $data2) 
        {
            $this->valid   = false;
            $this->array[$name] = sprintf("Not equal %s", $name);
            return false;
        }
        else 
        {
            return true;
        }
    }

    public function CheckEmail($name, $email)
    {
        if(strlen($email) !== 0) 
        {
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $this->valid   = false;
                $this->array[$name] = sprintf("Invalid %s", $name);
                return false;
            }
        }
        return true;
    }

    public function GetStatus()
    {
        return $this->valid;
    }

    public function GetValidationData()
    {
        return $this->array;
    }
}