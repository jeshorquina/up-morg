<?php
namespace Jesh\Operations\User;

use  \Jesh\Helpers\ValidationDataBuilder;

use \Jesh\Models\MemberModel;
use \Jesh\Models\LedgerInputModel;

use \Jesh\Operations\Repository\BatchMemberOperations;
use \Jesh\Operations\Repository\LedgerOperations;
use \Jesh\Operations\Repository\MemberOperations;

class FinanceActionOperations
{
    private $batch_member;
    private $ledger;

    public function __construct()
    {
        $this->batch_member = new BatchMemberOperations;
        $this->ledger = new LedgerOperations;
        $this->member = new MemberOperations;
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
        $batch_member_ids = $this->batch_member->GetBatchMemberIDs($batch_id);
        
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
                    $debit += (float)$entry->Amount;
                }
                else
                {
                    $credit += (float)$entry->Amount;
                }
            }
        }

        $total = $debit - $credit;
        $new_total = $total;

        $formatted_entries = array();
        foreach($entries as $entry)
        {
            $debit = ((bool)$entry->IsDebit) ? (float)$entry->Amount : 0;
            $credit = (!(bool)$entry->IsDebit) ? (float)$entry->Amount : 0;

            $new_total = $new_total + $debit - $credit;

            $formatted_entries[] = array(
                "id" => $entry->LedgerInputID,
                "date" => substr($entry->Timestamp, 0, 10),
                "status" => (bool)$entry->IsVerified,
                "member" => $this->GetMemberName(
                    $this->member->GetMember(
                        $this->batch_member->GetMemberID($entry->BatchMemberID)
                    )
                ),
                "description" => $entry->Description,
                "debit" => ($debit !== 0) ? 
                    "Php ".number_format($debit, 2) : "-",
                "credit" => ($credit !== 0) ? 
                    "Php ".number_format($credit, 2) : "-",
                "total" => "Php ".number_format($new_total, 2)
            );
        }

        return array(
            "previous" => "Php ".number_format($total, 2),
            "current" => $formatted_entries
        );
    }

    private function GetMemberName(MemberModel $member)
    {
        return str_replace('  ', ' ', sprintf(
                "%s %s %s", 
                $member->FirstName, 
                $member->MiddleName, 
                $member->LastName
            )
        );
    }

    public function VerifyLedgerEntry($ledger_input_id)
    {
        return $this->ledger->VerifyEntry($ledger_input_id);
    }

    public function ValidateAddLedgerData($input_data)
    {
        $validation = new ValidationDataBuilder;

        foreach($input_data as $name => $value) 
        {
            if(strtolower(gettype($value)) === "string") 
            {
                if($name == "amount")
                {
                    $validation->CheckDecimal($name, $value);
                }
                else
                {
                    $validation->CheckString($name, $value);
                }
            }
        }
        
        return array(
            "status" => $validation->GetStatus(),
            "data"   => $validation->GetValidationData()
        );
    }

    public function AddLedgerEntry(
        $amount, $type, $description, $batch_member_id, $is_verified
    ) 
    {
        $is_debit = ($type == "debit") ? true : false;
        return $this->ledger->AddEntry(
            new LedgerInputModel(
                array(
                    "BatchMemberID" => $batch_member_id,
                    "Amount" => $amount,
                    "IsDebit" => $is_debit,
                    "IsVerified" => $is_verified,
                    "Description" => $description
                )
            )
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
