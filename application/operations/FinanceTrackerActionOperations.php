<?php
namespace Jesh\Operations;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;
use \Jesh\Helpers\ValidationDataBuilder;

use \Jesh\Repository\FinanceTrackerActionOperationsRepository;

use \Jesh\Models\LedgerInputModel;

class FinanceTrackerActionOperations
{

    public function __construct()
    {
        $this->repository = new FinanceTrackerActionOperationsRepository;
    }

    public function GetBalance()
    {
        return $this->repository->GetBalance();
    }

    public function UpdateBalance($new_balance, $id)
    {
        if($this->repository->VerifyLedgerEntry($id))
        {
            return $this->repository->UpdateBalance($new_balance);
        }
        return false;
    }

    public function GetLedgerEntry($id)
    {
        return $this->repository->GetLedgerEntry($id);
    }

    public function AddDebitCredit(LedgerInputModel $input)
    {
        return $this->repository->AddDebitCredit($input);
    }

    public function GetLedgerEntries()
    {
        $entries = array();
        foreach($this->repository->GetLedgerEntries("DESC") as $entry)
        {
            $new_entry = array();

            $new_entry["id"] = $entry["LedgerInputID"];
            $new_entry["amount"] = $entry["Amount"];
            $new_entry["type"] = $this->GetInputType($entry["IsDebit"]);
            $new_entry["verified"] = (bool) $entry["IsVerified"];
            $new_entry["owner"] = $this->GetLedgerEntryOwner($entry["BatchMemberID"]);

            $entries[] = $new_entry;
        }
        return (sizeof($entries) != 0) ? $entries : false;
    }

    private function GetLedgerEntryOwner($id)
    {
        $member = $this->repository->GetMemberByBatchMemberID($id);
        return $member[0]["FirstName"] . " " . $member[0]["LastName"];
    }

    private function GetInputType($isDebit) 
    {
        return ((bool)$isDebit) ? "debit" : "credit";
    }
}