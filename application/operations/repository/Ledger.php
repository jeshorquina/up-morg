<?php
namespace Jesh\Operations\Repository;

use \Jesh\Helpers\StringHelper;

use \Jesh\Models\LedgerInputModel;
use \Jesh\Models\StaticDataModel;

use \Jesh\Repository\LedgerRepository;

class Ledger
{
    private $repository;

    public function __construct()
    {
        $this->repository = new LedgerRepository;
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
        $is_ledger_activated = $this->repository->GetIsLedgerActivated();
        if(sizeof($is_ledger_activated) === 1)
        {
            return (bool) $is_ledger_activated[0]["Value"];
        }
        else 
        {
            throw new \Exception("No record for ledger activated flag found");
        }
    }
    
    public function IsOpen()
    {
        $is_ledger_opened = $this->repository->GetIsLedgerOpen();
        if(sizeof($is_ledger_opened) === 1)
        {
            return (bool) $is_ledger_opened[0]["Value"];
        }
        else 
        {
            throw new \Exception("No record for ledger opened flag found");
        }
    }

    public function ActivateLedger()
    {
        if($this->OpenLedger())
        {
            return $this->repository->ToggleLedger(new StaticDataModel(
                array("Value" => "1")
            ));
        }
    }

    public function DeactivateLedger()
    {
        if($this->OpenLedger())
        {
            return $this->repository->ToggleLedger(new StaticDataModel(
                array("Value" => "0")
            ));
        }
    }

    public function OpenLedger()
    {
        return $this->repository->EnableLedger(new StaticDataModel(
            array("Value" => "1")
        ));
    }

    public function CloseLedger()
    {
        return $this->repository->EnableLedger(new StaticDataModel(
            array("Value" => "0")
        ));
    }

    public function AddEntry(LedgerInputModel $entry)
    {
        return $this->repository->AddEntry($entry);
    }

    public function VerifyEntry($ledger_input_id)
    {
        return $this->repository->UpdateEntry(
            $ledger_input_id,
            new LedgerInputModel(
                array("IsVerified"=> true)
            )
        );
    }
}
