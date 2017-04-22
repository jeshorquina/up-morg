<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Http;
use \Jesh\Helpers\PageRenderer;
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
        else if(UserSession::IsFirstFrontman())
        {
            $this->GetFirstFrontmanFinancePageDetails();
        }
        else if(UserSession::IsCommitteeHead())
        {
            $this->GetCommitteeHeadFinancePageDetails();
        }
        else
        {
            $this->GetCommitteeMemberFinancePageDetails();
        }
    }

    private function GetFirstFrontmanFinancePageDetails()
    {
        $details = $this->operations->GetFirstFrontmanFinancePageDetails(
            UserSession::GetBatchID()
        );

        if(!$details)
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not prepare finance page details. 
                        Please refresh browser."
                    )
                )
            );
        }
        else
        {
            Http::Response(
                Http::OK, array(
                    "message" => StringHelper::NoBreakString(
                        "FInance page details successfully processed."
                    ),
                    "data" => $details
                )
            );
        }
    }

    private function GetCommitteeHeadFinancePageDetails()
    {
        $details = $this->operations->GetCommitteeHeadFinancePageDetails(
            UserSession::GetBatchID()
        );

        if(!$details)
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not prepare finance page details. 
                        Please refresh browser."
                    )
                )
            );
        }
        else
        {
            Http::Response(
                Http::OK, array(
                    "message" => StringHelper::NoBreakString(
                        "FInance page details successfully processed."
                    ),
                    "data" => $details
                )
            );
        }
    }

    private function GetCommitteeMemberFinancePageDetails()
    {
        $details = $this->operations->GetCommitteeMemberFinancePageDetails(
            UserSession::GetBatchID()
        );

        if(!$details)
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not prepare finance page details. 
                        Please refresh browser."
                    )
                )
            );
        }
        else
        {
            Http::Response(
                Http::OK, array(
                    "message" => StringHelper::NoBreakString(
                        "FInance page details successfully processed."
                    ),
                    "data" => $details
                )
            );
        }
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
        else
        {
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
                $this->AddCommitteeHeadLedgerEntry(
                    $amount, $type, $description
                );
            }
            else
            {
                $this->AddCommitteeMemberLedgerEntry(
                    $amount, $type, $description
                );
            }
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
                        "Could not add ledger entry. Please try again."
                    )
                )
            );
        }
        
        $details = $this->operations->GetCommitteeHeadFinancePageDetails(
            UserSession::GetBatchID()
        );

        if(!$details)
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not add ledger entry. Please refresh browser."
                    )
                )
            );
        }
        else
        {
            Http::Response(
                Http::CREATED, array(
                    "message" => StringHelper::NoBreakString(
                        "Ledger entry successfully added."
                    ),
                    "data" => $details
                )
            );
        }
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
                        "Could not add ledger entry. Please try again."
                    )
                )
            );
        }

        $details = $this->operations->GetCommitteeMemberFinancePageDetails(
            UserSession::GetBatchID()
        );

        if(!$details)
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not add ledger entry. Please refresh browser."
                    )
                )
            );
        }
        else
        {
            Http::Response(
                Http::CREATED, array(
                    "message" => StringHelper::NoBreakString(
                        "Ledger entry successfully added."
                    ),
                    "data" => $details
                )
            );
        }
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
                        "Could not verify ledger entry. Please try again."
                    )
                )
            );
        }

        $details = $this->operations->GetCommitteeHeadFinancePageDetails(
            UserSession::GetBatchID()
        );

        if(!$details)
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not verify ledger entry. Please refresh browser."
                    )
                )
            );
        }
        else
        {
            Http::Response(
                Http::OK, array(
                    "message" => StringHelper::NoBreakString(
                        "Ledger entry successfully verified."
                    ),
                    "data" => $details
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
        else if(!$details = $this->operations->GetActivationDetails())
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not prepare ledger activation details. 
                        Please refresh browser."
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
                    "data" => $details
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
                        "Could not activate ledger. Please try again."
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
                    "redirect_url" => Url::GetBaseURL("admin/finance")
                )
            );
        }
    }
}