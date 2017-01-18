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
     *               $param[0] = TaskCommentID;
     *               $param[1] = TaskID;
     *               $param[2] = TaskSubscriberID;
     *               $param[3] = Comment;
     *               $param[4] = Timestamp;
     */ 
     public function __construct(...$params){
         $this->TaskCommentID    = $params[0];
         $this->TaskID           = $params[1];
         $this->TaskSubscriberID = $params[2];
         $this->Comment          = $params[3];
         $this->Timestamp        = $params[4];
     }
}