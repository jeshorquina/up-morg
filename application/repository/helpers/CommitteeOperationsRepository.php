<?php
namespace Jesh\Repository\Helpers;

use \Jesh\Core\Wrappers\Repository;

class CommitteeOperationsRepository extends Repository
{
    public function GetCommittees()
    {
        return self::Get("Committee", "CommitteeID, CommitteeName");
    }
}
