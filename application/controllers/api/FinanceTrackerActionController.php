<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Http;
use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;

use \Jesh\Models\LedgerInputModel;

class FinanceTrackerActionController extends Controller 
{
    private $operations;

    public function __construct()
    {
        parent::__construct();

        $this->operations = self::InitializeOperations("FinanceTrackerActionOperations");
    }

    public function AddDebitCredit()
    {
        $amount_string = Http::Request(Http::POST, "amount");
        $type = (int) Http::Request(Http::POST, "type");
        
        $amount = floatval($amount_string);

        $balance = $this->operations->GetBalance();
        $temp_balance = $balance;

        $user_data = json_decode(Session::Get("user_data"), true);
        $user_id = $user_data["id"];

        $array = array(
            "BatchMemberID" => (int) $user_id,
            "IsDebit" => (int) $type,
            "Amount" => $amount,
            "IsVerified" => 0
                );
        $response = $this->operations->AddDebitCredit(
            new LedgerInputModel(
                $array
            )
        );

        if(!$response)
        {
            Http::Response(Http::INTERNAL_SERVER_ERROR, 
                "Unable to add ledger input." . json_encode($array)
            );
        }
        else
        {
            Http::Response(Http::CREATED, 
                "Ledger input successfully added."
            );
        }
    }

    public function GetLedgerEntries()
    {
        $entries = $this->operations->GetLedgerEntries();
        if($entries !== false) 
        {
            Http::Response(Http::OK, $entries);
        }
        else 
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, 
                array(
                    "message" => "Something went wrong. 
                    Please refresh your browser."
                )    
            );
        }
    } 

    public function VerifyBalance()
    {
        $debit = 0;
        $credit = 0;

        $id = Http::Request(Http::POST, "ledger-entry-id");

        $debit = floatval($debit);
        $credit = floatval($credit);

        $ledger_entry = $this->operations->GetLedgerEntry($id);

        $is_debit = $ledger_entry[0]["IsDebit"];
        $amount = $ledger_entry[0]["Amount"];

        $balance = $this->operations->GetBalance();

        if($is_debit)
        {
            $new_balance = $balance + $amount;
        }
        else
        {
            $new_balance = $balance - $amount;
        }

        if($this->operations->UpdateBalance($new_balance, $id))
        {
            echo "Your balance has been verified. Your new balance is " . $this->operations->GetBalance() . ".";
        }
        else
        {
            echo "Unable to verify balance.";
        }
    }

    public function ApproveStatement()
    {
        
    }
}