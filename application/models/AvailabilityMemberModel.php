<?php
namespace Jesh\Models;

use \Jesh\Core\Interfaces\ModelInterface;

class AvailabilityMemberModel implements ModelInterface
{
    public $AvailabilityMemberID;
    public $BatchMemberID;
    public $MondayVector;
    public $TuesdayVector;
    public $WednesdayVector;
    public $ThursdayVector;
    public $FridayVector;
    public $SaturdayVector;
    public $SundayVector;

    public function __construct($array)
    {    
        foreach($array as $key => $value)
        {
            $this->$key = $value;
        }
    }
}