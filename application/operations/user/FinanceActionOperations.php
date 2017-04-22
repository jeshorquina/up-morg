<?php
namespace Jesh\Operations\User;

use \Jesh\Operations\Repository\BatchMemberOperations;
use \Jesh\Operations\Repository\CommitteeOperations;
use \Jesh\Operations\Repository\LedgerOperations;

class FinanceActionOperations
{
    private $batch_member;
    private $ledger;

    public function __construct()
    {
        $this->batch_member = new BatchMemberOperations;
        $this->ledger = new LedgerOperations;
    }

    public function GetFirstFrontmanFinancePageDetails($batch_id)
    {
        return array(
            "entries" => $this->GetBatchLedgerEntries($batch_id)
        );
    }

    public function GetCommitteeHeadFinancePageDetails($batch_id)
    {
        return array(
            "entries" => $this->GetBatchLedgerEntries($batch_id)
        );
    }

    public function GetCommitteeMemberFinancePageDetails($batch_id)
    {
        return array(
            "entries" => $this->GetBatchLedgerEntries($batch_id)
        );
    }

    private function GetBatchLedgerEntries($batch_id)
    {
        $batch_member_ids = $this->batch_member->GetBatchMembers($batch_id);
        
        $debit = 0;
        $credit = 0;

        $entries = array();
        foreach($this->ledger->GetLedgerEntries() as $entry)
        {
            if(in_array($entry->BatchMemberID, $batch_member_ids))
            {
                $entries[] = $entry;
            }
            else
            {
                if((bool)$entry->IsDebit)
                {
                    $debit = (float)$entry->Amount;
                }
                else
                {
                    $credit = (float)$entry->Amount;
                }
            }
        }

        $total = $debit - $credit;

        return array(
            "previous" => number_format($total, 2),
            "current" => $entries
        );
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
