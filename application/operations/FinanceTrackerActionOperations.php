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

    public function UpdateBalance($new_balance)
    {
        return $this->repository->UpdateBalance($new_balance);
    }

    public function AddDebitCredit(LedgerInputModel $input)
    {
        return $this->repository->AddDebitCredit($input);
    }

    public function GetLedgerEntries()
    {
        return $this->repository->GetLedgerEntries("DESC");
    }
}