<?php
namespace Jesh\Operations;

use \Jesh\Repository\SampleOperationsRepository;
use \Jesh\Models\BatchModel;

class SampleOperations {

    public function CreateBatch()
    {
        $AcadYear = "2016-2017";
        (new SampleOperationsRepository)->AddBatch(
            new BatchModel(
                $AcadYear
            )
        );
    }
}
