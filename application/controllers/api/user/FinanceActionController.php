<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Http;
use \Jesh\Helpers\StringHelper;
use \Jesh\Helpers\Url;
use \Jesh\Helpers\UserSession;

use \Jesh\Operations\User\FinanceActionOperations;

class FinanceActionController extends Controller 
{
    private $operations;

    public function __construct()
    {
        parent::__construct();

        $this->operations = new FinanceActionOperations;
    }

    public function GetFinancePageDetails()
    {
        if(!UserSession::IsFinanceMember())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }
        else if(!$this->operations->IsLedgerOpen())
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Ledger is already closed for this batch!"
                    )
                )
            );
        }
        else if(!$this->operations->IsLedgerActivated())
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Ledger is not yet activated for this batch!"
                    )
                )
            );
        }

        Http::Response(
            Http::OK, array(
                "message" => StringHelper::NoBreakString(
                    "FInance page details successfully processed."
                ),
                "data" => $this->operations->GetFinancePageDetails(
                    UserSession::GetBatchID()
                )
            )
        );
    }

    public function AddLedgerEntry()
    {
        if(!UserSession::IsFinanceMember() || UserSession::IsFirstFrontman())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }
        else if(!$this->operations->IsLedgerOpen())
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Ledger is already closed for this batch!"
                    )
                )
            );
        }
        else if(!$this->operations->IsLedgerActivated())
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Ledger is not yet activated for this batch!"
                    )
                )
            );
        }

        $amount = Http::Request(Http::POST, "amount");
        $type = Http::Request(Http::POST, "type");
        $description = Http::Request(Http::POST, "description");

        $validation = $this->operations->ValidateAddLedgerData(
            array(
                "amount" => $amount,
                "type" => $type,
                "description" => $description,
            )    
        );

        if($validation["status"] === false)
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, $validation["data"]
            );
        }
        else if(!in_array($type, array("debit", "credit")))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Ledger type is invalid! Please check."
                    )
                )
            );
        }
        else if(UserSession::IsCommitteeHead())
        {
            $this->AddCommitteeHeadLedgerEntry($amount, $type, $description);
        }
        else
        {
            $this->AddCommitteeMemberLedgerEntry($amount, $type, $description);
        }
    }

    private function AddCommitteeHeadLedgerEntry($amount, $type, $description)
    {
        $batch_member_id = UserSession::GetBatchMemberID();

        if(!$this->operations->AddLedgerEntry(
            $amount, $type, $description, $batch_member_id, true
        ))
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Cannot add ledger entry. Please try again."
                    )
                )
            );
        }

        Http::Response(
            Http::CREATED, array(
                "message" => StringHelper::NoBreakString(
                    "Ledger entry successfully added."
                ),
                "data" => $this->operations->GetFinancePageDetails(
                    UserSession::GetBatchID()
                )
            )
        );
    }

    private function AddCommitteeMemberLedgerEntry($amount, $type, $description)
    {
        $batch_member_id = UserSession::GetBatchMemberID();

        if(!$this->operations->AddLedgerEntry(
            $amount, $type, $description, $batch_member_id, false
        ))
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Cannot add ledger entry. Please try again."
                    )
                )
            );
        }

        Http::Response(
            Http::CREATED, array(
                "message" => StringHelper::NoBreakString(
                    "Ledger entry successfully added."
                ),
                "data" => $this->operations->GetFinancePageDetails(
                    UserSession::GetBatchID()
                )
            )
        );
    }

    public function VerifyLedgerEntry($ledger_input_id)
    {
        if(!UserSession::IsFinanceMember() || !UserSession::IsCommitteeHead())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }
        else if(!$this->operations->VerifyLedgerEntry($ledger_input_id))
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Cannot verify ledger entry. Please try again."
                    )
                )
            );
        }

        Http::Response(
            Http::OK, array(
                "message" => StringHelper::NoBreakString(
                    "Ledger entry successfully verified."
                ),
                "data" => $this->operations->GetFinancePageDetails(
                    UserSession::GetBatchID()
                )
            )
        );
    }

    public function CloseLedger()
    {
        if(!UserSession::IsFirstFrontman())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }
        else if(!$this->operations->AllLedgerEntriesVerified())
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Cannot close the current batch's ledger. Please
                        have all ledger entries verified by the Finance Head 
                        first!"
                    )
                )
            );
        }
        else if(!$this->operations->CloseLedger())
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Cannot close ledger. Please try again."
                    )
                )
            );
        }
        else
        {
            Http::Response(
                Http::OK, array(
                    "message" => StringHelper::NoBreakString(
                        "Ledger successfully closed!"
                    ),
                    "redirect_url" => Url::GetBaseURL("finance/closed")
                )
            );
        }
    }

    public function GetFinanceActivationDetails()
    {
        if(!UserSession::IsFinanceMember() || !UserSession::IsCommitteeHead())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }
        else if(!$this->operations->IsLedgerOpen())
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Ledger is already closed for this batch!"
                    )
                )
            );
        }
        else if($this->operations->IsLedgerActivated())
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Ledger is already activated for this batch!"
                    )
                )
            );
        }
        else
        {
            Http::Response(
                Http::OK, array(
                    "message" => StringHelper::NoBreakString(
                        "Ledger activation details successfully processed."
                    ),
                    "data" => $this->operations->GetActivationDetails(
                        UserSession::GetBatchID()
                    )
                )
            );
        }
    }

    public function ActivateLedger()
    {
        if(!UserSession::IsFinanceMember() || !UserSession::IsCommitteeHead())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }
        else if(!$this->operations->IsLedgerOpen())
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Ledger is already closed for this batch!"
                    )
                )
            );
        }
        else if($this->operations->IsLedgerActivated())
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Ledger is already activated for this batch!"
                    )
                )
            );
        }
        else if(!$this->operations->ActivateLedger())
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Cannot activate ledger. Please try again."
                    )
                )
            );
        }
        else
        {
            Http::Response(
                Http::OK, array(
                    "message" => StringHelper::NoBreakString(
                        "Ledger successfully activated!"
                    ),
                    "redirect_url" => Url::GetBaseURL("finance")
                )
            );
        }
    }

    public function GetClosedLedgerDetails()
    {
        if(!UserSession::IsFinanceMember())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }
        else if($this->operations->IsLedgerOpen())
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Ledger is still open for this batch!"
                    )
                )
            );
        }

        Http::Response(
            Http::OK, array(
                "message" => StringHelper::NoBreakString(
                    "FInance page details successfully processed."
                ),
                "data" => $this->operations->GetFinancePageDetails(
                    UserSession::GetBatchID()
                )
            )
        );
    }
}