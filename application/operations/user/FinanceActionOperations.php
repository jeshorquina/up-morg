<?php
namespace Jesh\Operations\User;

use  \Jesh\Helpers\ValidationDataBuilder;

use \Jesh\Models\MemberModel;
use \Jesh\Models\LedgerInputModel;

use \Jesh\Operations\Repository\BatchOperations;
use \Jesh\Operations\Repository\BatchMemberOperations;
use \Jesh\Operations\Repository\LedgerOperations;
use \Jesh\Operations\Repository\MemberOperations;

class FinanceActionOperations
{
    private $batch;
    private $batch_member;
    private $ledger;
    private $member;

    public function __construct()
    {
        $this->batch = new BatchOperations;
        $this->batch_member = new BatchMemberOperations;
        $this->ledger = new LedgerOperations;
        $this->member = new MemberOperations;
    }

    public function GetFinancePageDetails($batch_id)
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

        $entry_acad_year = false;
        $current_acad_year = false;

        $entries = array();
        foreach($this->ledger->GetLedgerEntries() as $entry)
        {
            if(in_array($entry->BatchMemberID, $batch_member_ids))
            {
                $entries[] = $entry;
                $is_previous = false;
            }
            else if($this->IsPreviousBatchEntry($batch_id, $entry))
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

    private function IsPreviousBatchEntry($batch_id, $entry)
    {
        $entry_acad_year = $this->batch->GetAcadYear(
            $this->batch_member->GetBatchID($entry->BatchMemberID)
        );
        $current_acad_year = $this->batch->GetAcadYear($batch_id);

        return strcmp($entry_acad_year, $current_acad_year) < 0;
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

    public function AllLedgerEntriesVerified()
    {
        foreach($this->ledger->GetLedgerEntries() as $entry)
        {
            if(!(bool)$entry->IsVerified)
            {
                return false;
            }
        }
        return true;
    }

    public function CloseLedger()
    {
        return $this->ledger->CloseLedger();
    }

    public function GetActivationDetails($batch_id)
    {
        $debit = 0; 
        $credit = 0;

        $entries = $this->ledger->GetLedgerEntries();

        foreach($entries as $entry)
        {
            if($this->IsPreviousBatchEntry($batch_id, $entry))
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

    public function IsLedgerOpen()
    {
        return $this->ledger->IsOpen();
    }

    public function ActivateLedger()
    {
        return $this->ledger->ActivateLedger();
    }
}
