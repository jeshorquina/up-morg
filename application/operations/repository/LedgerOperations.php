<?php
namespace Jesh\Operations\Repository;

use \Jesh\Helpers\StringHelper;

use \Jesh\Models\LedgerInputModel;
use \Jesh\Models\StaticDataModel;

use \Jesh\Repository\LedgerOperationsRepository;

class LedgerOperations
{
    private $repository;

    public function __construct()
    {
        $this->repository = new LedgerOperationsRepository;
    }

    public function GetLedgerEntries()
    {
        $entries = $this->repository->GetLedgerEntries();

        $ledger_entries = [];
        foreach($entries as $entry)
        {
            $ledger_entries[] = new LedgerInputModel($entry);
        }

        return $ledger_entries;
    }

    public function IsActivated()
    {
        $is_ledger_activated = $this->repository->IsLedgerActivated();
        if(sizeof($is_ledger_activated) === 1)
        {
            return $is_ledger_activated[0]["Value"];
        }
        else 
        {
            throw new \Exception("No record for ledger activated flag found");
        }
    }

    public function ActivateLedger()
    {
        return $this->repository->ToggleLedger(new StaticDataModel(
            array("Value" => "1")
        ));
    }

    public function DeactivateLedger()
    {
        return $this->repository->ToggleLedger(new StaticDataModel(
            array("Value" => "0")
        ));
    }
}
