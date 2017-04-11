<?php
namespace Jesh\Repository;

use \Jesh\Core\Wrappers\Repository;

use \Jesh\Models\LedgerInputModel;

class FinanceTrackerActionOperationsRepository extends Repository
{
    public function GetBalance()
    {
        $balance_record = Self::Get("StaticData", "Value", array("Name" => "Balance"));
        if(sizeof($balance_record) === 0)
        {
            return null;
        }
        else if(sizeof($balance_record) === 1)
        {
            return $balance_record[0]["Value"];
        }
    }

    public function UpdateBalance($new_balance)
    {
        return Self::Update("StaticData", array("Name" => "Balance"), array("Value" => $new_balance));
    }

    public function AddDebitCredit(LedgerInputModel $input)
    {
        return Self::Insert("LedgerInput", $input);
    }

     public function GetLedgerEntries($order)
    {
        return self::Get(
            "LedgerInput", "*", 
            array(), 
            array("LedgerInputID" => $order)
        );
    }
    
}