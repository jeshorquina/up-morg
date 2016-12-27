<?php
namespace Jesh\Repository;

use \Jesh\Models\BatchModel;
use \Jesh\Repository\Repository;

class SampleOperationsRepository extends Repository {

    public function AddBatch(BatchModel $batch)
    {
        self::insert($table = 'Batch', $batch);
    }
}
