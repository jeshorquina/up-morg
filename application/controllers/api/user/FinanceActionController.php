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