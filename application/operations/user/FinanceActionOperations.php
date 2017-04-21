<?php
namespace Jesh\Operations\User;

use \Jesh\Operations\Repository\LedgerOperations;

class FinanceActionOperations
{
    private $static_data;

    public function __construct()
    {
        $this->ledger = new LedgerOperations;
    }

    public function GetActivationDetails()
    {
        $debit = 0; 
        $credit = 0;

        $entries = $this->ledger->GetLedgerEntries();

        foreach($entries as $entry)
        {
            if((bool)$entry->IsDebit)
            {
                $debit += (float)$entry->Amount;
            }
            else
            {
                $credit += (float)$entry->Amount;
            }
        }

        $total = $debit - $credit;

        return array(
            "debit" => number_format($debit, 2),
            "credit" => number_format($credit, 2),
            "total" => number_format($total, 2)
        );
    }

    public function IsLedgerActivated()
    {
        return $this->ledger->IsActivated();
    }

    public function ActivateLedger()
    {
        return $this->ledger->ActivateLedger();
    }
}
