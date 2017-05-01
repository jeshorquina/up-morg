<?php
namespace Jesh\Helpers;

class ValidationDataBuilder
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
        if($data === null)
        {
            $this->valid        = false;
            $this->array[$name] = sprintf("Empty %s", $name);
        }
        else if(strtolower(gettype($data)) !== "string") 
        {
            $this->valid        = false;
            $this->array[$name] = sprintf("Incorrect data type for %s", $name);
        }
        else if(strlen($data) === 0) 
        {
            $this->valid        = false;
            $this->array[$name] = sprintf("Empty %s", $name);
        }
    }

    public function CheckEquals($name, $data1, $data2)
    {
        if($data1 !== $data2) 
        {
            $this->valid        = false;
            $this->array[$name] = sprintf("Not equal %s", $name);
        }
    }

    public function CheckEmail($name, $email)
    {
        if($email === null)
        {
            $this->valid        = false;
            $this->array[$name] = sprintf("Empty %s", $name);
        }
        else if(strtolower(gettype($email)) !== "string") 
        {
            $this->valid        = false;
            $this->array[$name] = sprintf("Incorrect data type for %s", $name);
        }
        else if(strlen($email) === 0) 
        {
            $this->valid        = false;
            $this->array[$name] = sprintf("Empty %s", $name);
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $this->valid        = false;
            $this->array[$name] = sprintf("Invalid %s", $name);
        }
    }

    public function CheckDecimal($name, $value)
    {
        if(!filter_var($value, FILTER_VALIDATE_FLOAT))
        {
            $this->valid        = false;
            $this->array[$name] = sprintf("Invalid %s", $name);
        }
    }

    public function CheckArray($name, $value)
    {
        if($value === null)
        {
            $this->valid        = false;
            $this->array[$name] = sprintf("Empty %s", $name);
        }
        else if(strtolower(gettype($value)) !== "array")
        {
            $this->valid        = false;
            $this->array[$name] = sprintf("Incorrect data type for %s", $name);
        }
        else if(sizeof($value) === 0)
        {
            $this->valid        = false;
            $this->array[$name] = sprintf("Empty %s", $name);
        }
    }

    public function CheckDate($name, $value)
    {
        if($value === null)
        {
            $this->valid        = false;
            $this->array[$name] = sprintf("Empty %s", $name);
        }
        else if(strtolower(gettype($value)) !== "string") 
        {
            $this->valid        = false;
            $this->array[$name] = sprintf("Incorrect data type for %s", $name);
        }
        else if(strlen($value) === 0) 
        {
            $this->valid        = false;
            $this->array[$name] = sprintf("Empty %s", $name);
        }

        $is_valid = filter_var(
            preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/", $value), 
            FILTER_VALIDATE_BOOLEAN
        );

        if(!$is_valid)
        {
            $this->valid        = false;
            $this->array[$name] = sprintf(
                "Malformed date for %s. Should have 0000-00-00 format.", 
                $name
            );
        }
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
