<?php 
namespace Jesh\Models;

use \Jesh\Core\Interfaces\ModelInterface;

class BatchModel implements ModelInterface {
    
    public $BatchID;
    public $AcadYear;

    /**
     * Constructs the database model
     *
     * @param $param Array An array containing the 
     *               following:
     *
     *               $param[0] = AcadYear
     */
    public function __construct(...$params){
        $this->AcadYear = $params[0];
    }
}
