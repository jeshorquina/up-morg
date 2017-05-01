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
        if(strtolower(gettype($data)) !== "string") 
        {
            $this->valid        = false;
            $this->array[$name] = sprintf(
                "Incorrect data type for %s", StringHelper::UnmakeIndex($name)
            );
        }
        else if(strlen($data) === 0) 
        {
            $this->valid        = false;
            $this->array[$name] = sprintf(
                "Empty %s", StringHelper::UnmakeIndex($name)
            );
        }
    }

    public function CheckEquals($name, $data1, $data2)
    {
        if($data1 !== $data2) 
        {
            $this->valid        = false;
            $this->array[$name] = sprintf(
                "Not equal %s", StringHelper::UnmakeIndex($name)
            );
        }
    }

    public function CheckEmail($name, $email)
    {
        if(strtolower(gettype($email)) !== "string") 
        {
            $this->valid        = false;
            $this->array[$name] = sprintf(
                "Incorrect data type for %s", StringHelper::UnmakeIndex($name)
            );
        }
        else if(strlen($email) === 0) 
        {
            $this->valid        = false;
            $this->array[$name] = sprintf(
                "Empty %s", StringHelper::UnmakeIndex($name)
            );
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $this->valid        = false;
            $this->array[$name] = sprintf(
                "Invalid %s", StringHelper::UnmakeIndex($name)
            );
        }
    }

    public function CheckDecimal($name, $value)
    {
        if(strtolower(gettype($value)) !== "string") 
        {
            $this->valid        = false;
            $this->array[$name] = sprintf(
                "Incorrect data type for %s", StringHelper::UnmakeIndex($name)
            );
        }
        else if(strlen($value) === 0) 
        {
            $this->valid        = false;
            $this->array[$name] = sprintf(
                "Empty %s", StringHelper::UnmakeIndex($name)
            );
        }
        else if(!filter_var($value, FILTER_VALIDATE_FLOAT))
        {
            $this->valid        = false;
            $this->array[$name] = sprintf(
                "Invalid %s", StringHelper::UnmakeIndex($name)
            );
        }
    }

    public function CheckArray($name, $value)
    {
        if(strtolower(gettype($value)) !== "array")
        {
            $this->valid        = false;
            $this->array[$name] = sprintf(
                "Incorrect data type for %s", StringHelper::UnmakeIndex($name)
            );
        }
        else if(sizeof($value) === 0)
        {
            $this->valid        = false;
            $this->array[$name] = sprintf(
                "Empty %s", StringHelper::UnmakeIndex($name)
            );
        }
    }

    public function CheckDate($name, $value)
    {
        if(strtolower(gettype($value)) !== "string") 
        {
            $this->valid        = false;
            $this->array[$name] = sprintf(
                "Incorrect data type for %s", StringHelper::UnmakeIndex($name)
            );
        }
        else if(strlen($value) === 0) 
        {
            $this->valid        = false;
            $this->array[$name] = sprintf(
                "Empty %s", StringHelper::UnmakeIndex($name)
            );
        }

        $is_valid = filter_var(
            preg_match("/[0-9]{4}-[0-1][0-9]-[0-3][0-9]/", $value), 
            FILTER_VALIDATE_BOOLEAN
        );

        if(!$is_valid)
        {
            $this->valid        = false;
            $this->array[$name] = sprintf(
                "Malformed date for %s. Should have YYYY-MM-DD format.", 
                StringHelper::UnmakeIndex($name)
            );
        }
    }

    public function CheckInteger($name, $value)
    {
        if($value === null)
        {
            $this->valid        = false;
            $this->array[$name] = sprintf(
                "Empty %s", StringHelper::UnmakeIndex($name)
            );
        }
        else if(!filter_var($value, FILTER_VALIDATE_INT))
        {
            $this->valid        = false;
            $this->array[$name] = sprintf(
                "Invalid %s", StringHelper::UnmakeIndex($name)
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
