<?php

namespace Jesh\Models;

use Jesh\Core\Models\ModelInterface;

class TaskCommentModel implements ModelInterface {

    public $TaskCommentID;
    public $TaskID;
    public $TaskSubscriberID;
    public $Comment;
    public $Timestamp;

    /**
     * Constructs the database model
     *
     * @param $param Array An array containing the 
     *               following:
     *
     *               $param[0] = TaskID;
     *               $param[1] = TaskSubscriberID;
     *               $param[2] = Comment;
     *               $param[3] = Timestamp;
     */ 
     public function __construct(...$params){
         $this->TaskID           = $params[0];
         $this->TaskSubscriberID = $params[1];
         $this->Comment          = $params[2];
         $this->Timestamp        = $params[3];
     }
}