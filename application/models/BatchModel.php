<?php 
namespace Jesh\Models;

use \Jesh\Core\Interfaces\ModelInterface;

class BatchModel implements ModelInterface
{
    public $BatchID;
    public $AcadYear;

    public function __construct($array)
    {    
        foreach($array as $key => $value)
        {
            $this->$key = $value;
        }
    }
}
