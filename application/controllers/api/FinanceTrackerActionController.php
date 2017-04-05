<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Http;
use \Jesh\Helpers\Security;

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
        $type = Http::Request(Http::POST, "type");
        
        $amount = floatval($amount_string);

        $balance = $this->operations->GetBalance();
        $temp_balance = $balance;

        if($type == "debit")
        {
            $temp_balance = $balance + $amount;
            echo "You have added a debit of " . $amount . "php. The temporary balance is now " . $temp_balance . "php. 
            The changes will reflect in the ledger once your input has been verified.";
        }
        else
        {
            $temp_balance = $balance - $amount;
            echo "You have added a crebit of " . $amount . "php. The temporary balance is now " . $temp_balance . "php. 
            The changes will reflect in the ledger once your input has been verified.";
        } 
    }

    public function VerifyBalance()
    {
        $debit = Http::Request(Http::POST, "debit");
        $credit = Http::Request(Http::POST, "credit");
        $temp_balance = Http::Request(Http::POST, "temp_balance");

        $debit = floatval($debit);
        $credit = floatval($credit);

        $balance = $this->operations->GetBalance();

        $new_balance = $balance + $debit - $credit;

        if($this->operations->UpdateBalance($new_balance))
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