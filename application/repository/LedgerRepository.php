<?php
namespace Jesh\Repository;

use \Jesh\Core\Wrappers\Repository;

use \Jesh\Models\StaticDataModel;
use \Jesh\Models\LedgerInputModel;

class LedgerRepository extends Repository
{
    public function GetLedgerEntries()
    {
        return self::Get("LedgerInput", "*");
    }

    public function GetIsLedgerActivated()
    {
        return self::Get(
            "StaticData", "Value", array("Name" => "IsLedgerActivated")
        );
    }

    public function GetIsLedgerOpen()
    {
        return self::Get(
            "StaticData", "Value", array("Name" => "IsLedgerOpen")
        );
    }

    public function ToggleLedger(StaticDataModel $static_data)
    {
        return self::Update(
            "StaticData", array("Name" => "IsLedgerActivated"), $static_data
        );
    }

    public function EnableLedger(StaticDataModel $static_data)
    {
        return self::Update(
            "StaticData", array("Name" => "IsLedgerOpen"), $static_data
        );
    }

    public function AddEntry(LedgerInputModel $entry)
    {
        return self::Insert("LedgerInput", $entry);
    }

    public function UpdateEntry($ledger_input_id, LedgerInputModel $entry)
    {
        return self::Update(
            "LedgerInput", array("LedgerInputID" => $ledger_input_id), $entry
        );
    }
}