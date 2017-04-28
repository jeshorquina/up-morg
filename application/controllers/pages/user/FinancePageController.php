<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\PageRenderer;
use \Jesh\Helpers\Security;
use \Jesh\Helpers\UserSession;

class FinancePageController extends Controller 
{
    public function __construct()
    {
        parent::__construct();

        $this->SetTemplates();
    }

    private function SetTemplates()
    {
        self::SetHeader("templates/header.html.inc");
        self::SetHeader("templates/nav.html.inc");
        self::SetFooter("templates/footer.html.inc");
    }

    public function FinanceIndex()
    {
        if(PageRenderer::HasFinancePageAccess())
        {
            $other_details = array(
                Security::GetCSRFData(),
                array(
                    "page" => array(
                        "title" => "Finance Tracker"
                    )
                ),
            );

            if(UserSession::IsCommitteeHead())
            {
                self::SetBody("user/finance/finance-head.html.inc");
                self::RenderView(
                    PageRenderer::GetUserPageData(
                        "finance-head", $other_details
                    )
                );
            }
            else if(UserSession::IsFirstFrontman())
            {
                self::SetBody("user/finance/first-frontman.html.inc");
                self::RenderView(
                    PageRenderer::GetUserPageData(
                        "finance-first-frontman", $other_details
                    )
                );
            }
            else
            {
                self::SetBody("user/finance/finance-member.html.inc");
                self::RenderView(
                    PageRenderer::GetUserPageData(
                        "finance-member", $other_details
                    )
                );
            }
        }
    }

    public function LedgerActivation()
    {
        if(PageRenderer::HasFinanceLedgerActivationPageAccess())
        {
            $other_details = array(
                Security::GetCSRFData(),
                array(
                    "page" => array(
                        "title" => "Finance Tracker"
                    )
                ),
            );

            self::SetBody("user/finance/activation.html.inc");
            self::RenderView(
                PageRenderer::GetUserPageData(
                    "finance-activation", $other_details
                )
            );
        }
    }

    public function LedgerClosed()
    {
        if(PageRenderer::HasFinanceLedgerClosedPageAccess())
        {
            $other_details = array(
                Security::GetCSRFData(),
                array(
                    "page" => array(
                        "title" => "Finance Tracker"
                    )
                ),
            );

            if(UserSession::IsFirstFrontman())
            {
                self::SetBody("user/finance/closed-frontman.html.inc");
                self::RenderView(
                    PageRenderer::GetUserPageData(
                        "finance-closed-frontman", $other_details
                    )
                );
            }
            else
            {
                self::SetBody("user/finance/closed-committee.html.inc");
                self::RenderView(
                    PageRenderer::GetUserPageData(
                        "finance-closed-committee", $other_details
                    )
                );
            }
        }
    }
}