<?php
namespace Jesh\Helpers;

use \Jesh\Operations\Repository\BatchMember;
use \Jesh\Operations\Repository\Committee;
use \Jesh\Operations\Repository\Ledger;
use \Jesh\Operations\Repository\Member;
use \Jesh\Operations\Repository\Task;

class PageRenderer
{
    public static function HasTaskPageAccess()
    {
        if(!UserSession::IsCommitteeMember() && !UserSession::IsFrontman())
        {
            self::ShowForbiddenPage();
        }
        else
        {
            return true;
        }
    }

    public static function HasTaskDetailsPageAccess($task_id = null)
    {
        if($task_id == null)
        {
            self::ShowForbiddenPage();
        }
        else if(!UserSession::IsCommitteeMember() && !UserSession::IsFrontman())
        {
            self::ShowForbiddenPage();
        }

        $task_helper = new Task;
        $batch_member_id = UserSession::GetBatchMemberID();

        if(!$task_helper->HasTask($task_id))
        {
            self::ShowForbiddenPage();
        }
        else if(!$task_helper->IsTaskSubscriber($task_id, $batch_member_id))
        {
            if(UserSession::IsFirstFrontman())
            {
                return true;
            }
            else if(UserSession::IsFrontman())
            {
                $task_object = $task_helper->GetTask($task_id);

                $batch_member_helper = new BatchMember;
                $member_helper = new Member;

                $frontmen = array(
                    $member_helper->GetMemberTypeID(Member::FIRST_FRONTMAN),
                    $member_helper->GetMemberTypeID(Member::SECOND_FRONTMAN),
                    $member_helper->GetMemberTypeID(Member::THIRD_FRONTMAN)
                );
                $assignee_member_type = $batch_member_helper->GetMemberTypeID(
                    $task_object->Assignee
                );

                if(!in_array($assignee_member_type, $frontmen))
                {
                    $batch_member_helper = new BatchMember;
                    $committee_helper = new Committee;

                    $committee_id = (
                        $committee_helper->GetCommitteeIDByBatchMemberID(
                            $task_object->Assignee
                        )
                    );
                    $scoped_committees = (
                        $committee_helper->GetCommitteePermissionCommitteeIDs(
                            $batch_member_helper->GetBatchID($batch_member_id), 
                            $batch_member_helper->GetMemberTypeID(
                                $batch_member_id
                            )
                        )
                    );

                    if(!in_array($committee_id, $scoped_committees))
                    {
                        self::ShowForbiddenPage();
                    }
                }
            }
            else if(UserSession::IsCommitteeHead())
            {
                $task_object = $task_helper->GetTask($task_id);

                $batch_member_helper = new BatchMember;
                $committee_helper = new Committee;
                $member_helper = new Member;

                $frontmen = array(
                    Member::FIRST_FRONTMAN,
                    Member::SECOND_FRONTMAN,
                    Member::THIRD_FRONTMAN
                );

                $assignee_member_type = $member_helper->GetMemberType(
                    $batch_member_helper->GetMemberTypeID(
                        $task_object->Assignee
                    )
                );
                if(in_array($assignee_member_type, $frontmen))
                {
                    self::ShowForbiddenPage();
                }

                $assignee_committee_id = (
                    $committee_helper->GetCommitteeIDByBatchMemberID(
                        $task_object->Assignee
                    )
                );
                $head_committee_id = (
                    $committee_helper->GetCommitteeIDByBatchMemberID(
                        $batch_member_id
                    )
                );
                if($assignee_committee_id != $head_committee_id)
                {
                    self::ShowForbiddenPage();
                }
            }
            else
            {
                self::ShowForbiddenPage();
            }
        }

        return true;
    }

    public static function HasAddTaskPageAccess()
    {
        if(!UserSession::IsCommitteeMember() && !UserSession::IsFrontman())
        {
            self::ShowForbiddenPage();
        }
        else
        {
            return true;
        }
    }

    public static function HasEditTaskPageAccess($task_id = null)
    {
        if($task_id == null)
        {
            self::ShowForbiddenPage();
        }
        else if(!UserSession::IsCommitteeMember() && !UserSession::IsFrontman())
        {
            self::ShowForbiddenPage();
        }
        else if(UserSession::IsFrontman())
        {
            return self::FrontmanHasEditTaskPageAccess($task_id);
        }
        else
        {
            return self::CommitteeHasEditTaskPageAccess($task_id);
        }
    }

    private static function FrontmanHasEditTaskPageAccess($task_id)
    {
        $task_helper = new Task;
        $member_helper = new Member;
        $batch_member_helper = new BatchMember;
        $committee_helper = new Committee;

        $batch_member_id = UserSession::GetBatchMemberID();
        $batch_id = UserSession::GetBatchID();

        $task_object = $task_helper->GetTask($task_id);
        if($task_object->Assignee == $batch_member_id)
        {
            return true;
        }
        else if($task_object->Reporter == $batch_member_id)
        {
            return true;
        }

        $frontmen = array(
            $member_helper->GetMemberTypeID(Member::FIRST_FRONTMAN),
            $member_helper->GetMemberTypeID(Member::SECOND_FRONTMAN),
            $member_helper->GetMemberTypeID(Member::THIRD_FRONTMAN)
        );
        $assignee_member_type = $batch_member_helper->GetMemberTypeID(
            $task_object->Assignee
        );

        if(in_array($assignee_member_type, $frontmen))
        {
            return true;
        }

        $committee_id = $committee_helper->GetCommitteeIDByBatchMemberID(
            $task_object->Assignee
        );
        $scoped_committees = (
            $committee_helper->GetCommitteePermissionCommitteeIDs(
                $batch_id, $batch_member_helper->GetMemberTypeID(
                    $batch_member_id
                )
            )
        );

        if(in_array($committee_id, $scoped_committees))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private static function CommitteeHasEditTaskPageAccess($task_id)
    {
        $task_helper = new Task;

        $task_object = $task_helper->GetTask($task_id);
        if($task_object->Assignee == $batch_member_id)
        {
            return true;
        }
        else if($task_object->Reporter == $batch_member_id)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public static function HasModifyAvailabilityPageAccess()
    {
        if(!UserSession::IsCommitteeMember() && !UserSession::IsFrontman())
        {
            self::ShowForbiddenPage();
        }
        else
        {
            return true;
        }
    }

    public static function HasCommitteeAvailabilityPageAccess()
    {
        if(!UserSession::IsCommitteeMember() && !UserSession::IsFrontman())
        {
            self::ShowForbiddenPage();
        }
        else if(UserSession::IsFrontman())
        {
            Url::Redirect("availability/group");
        }
        else
        {
            return true;
        }
    }

    public static function HasGroupAvailabilityPageAccess()
    {
        if(!UserSession::IsCommitteeMember() && !UserSession::IsFrontman())
        {
            self::ShowForbiddenPage();
        }
        else if(!UserSession::IsFrontman())
        {
            Url::Redirect("availability/committee");
        }
        else
        {
            return true;
        }
    }

    public static function HasMemberAvailabilityPageAccess()
    {
        if(!UserSession::IsCommitteeMember() && !UserSession::IsFrontman())
        {
            self::ShowForbiddenPage();
        }
        else if(!UserSession::IsFrontman())
        {
            Url::Redirect("availability/committee");
        }
        else
        {
            return true;
        }
    }

    public static function HasFinancePageAccess()
    {
        if(!UserSession::IsFinanceMember())
        {
            self::ShowForbiddenPage();
        }
        else
        {
            $ledger = new Ledger;

            if(!$ledger->IsOpen())
            {
                Url::Redirect("finance/closed");
            }
            else if(!$ledger->IsActivated())
            {
                Url::Redirect("finance/activate");
            }
            else
            {
                return true;
            }
        }
    }

    public static function HasFinanceLedgerActivationPageAccess()
    {
        if(!UserSession::IsFinanceMember())
        {
            self::ShowForbiddenPage();
        }
        else
        {
            $ledger = new Ledger;

            if(!$ledger->IsOpen())
            {
                Url::Redirect("finance/closed");
            }
            else if($ledger->IsActivated())
            {
                Url::Redirect("finance");
            }
            else
            {
                return true;
            }
        }
    }

    public static function HasFinanceLedgerClosedPageAccess()
    {
        if(!UserSession::IsFinanceMember())
        {
            self::ShowForbiddenPage();
        }
        else
        {
            $ledger = new Ledger;

            if(!$ledger->IsOpen())
            {
                return true;
            }
            else if(!$ledger->IsActivated())
            {
                Url::Redirect("finance/activate");
            }
            else
            {
                Url::Redirect("finance");
            }
        }
    }

    public static function HasMemberDetailsAccess()
    {
        if(!UserSession::IsFrontman() && !UserSession::IsCommitteeHead())
        {
            self::ShowForbiddenPage();
        }
        else
        {
            return true;
        }
    }

    public static function HasMemberCommitteeDetailsAccess($committee_name)
    {
        if(!UserSession::IsCommitteeMember() && !UserSession::IsFrontman())
        {
            self::ShowForbiddenPage();
        }
        else if(UserSession::IsFirstFrontman())
        {
            return true;
        }

        $can_access = false;
        if(UserSession::IsFrontman())
        {
            $committee = new Committee;
            $can_access = in_array(
                $committee->GetCommitteeIDByCommitteeName(
                    StringHelper::UnmakeIndex($committee_name)
                ), 
                $committee->GetCommitteePermissionCommitteeIDs(
                    UserSession::GetBatchID(), UserSession::GetMemberTypeID()
                )
            );
        }
        else if(UserSession::IsCommitteeHead())
        {
            $committee = new Committee;
            $can_access = $committee->GetCommitteeIDByBatchMemberID(
                UserSession::GetBatchMemberID()
            ) == $committee->GetCommitteeIDByCommitteeName(
                StringHelper::UnmakeIndex($committee_name)
            );
        }

        if(!$can_access)
        {
            self::ShowForbiddenPage();
        }
        else
        {
            return true;
        }
    }

    public static function HasAdminPageAccess()
    {
        if(Url::GetCurrentURI() === "admin/login") 
        {
            if(Session::Find("admin_data"))
            {
                Url::Redirect("admin");
            }
        }
        else 
        {
            if(!Session::Find("admin_data"))
            {
                Url::Redirect("admin/login");
            }
        }

        return true; 
    }

    public static function HasUserPageAccess($page_type)
    {
        if(!Session::Find("user_data"))
        {
            Url::Redirect("login");
        }

        // NOTE:: The code below will be depricated because the permission
        // checking will be done per function since it can be very specific
        // sometimes

        if(!UserSession::IsBatchMember())
        {
            if($page_type !== "request-batch")
            {
                Url::Redirect("request/batch");
            }
            else
            {
                return true;
            }
        }
        else 
        {
            if(!UserSession::IsCommitteeMember() && !UserSession::IsFrontman()) 
            {
                if($page_type !== "request-committee")
                {
                    Url::Redirect("request/committee");
                }
                else
                {
                    return true;
                }
            }
            
        }

        if($page_type === "request-batch" || $page_type === "request-committee")
        {
            Url::Redirect();
        }
        
        if(!UserSession::IsCommitteeHead() && !UserSession::IsFrontman())
        {
            if($page_type === "subordinate")
            {
                Url::Redirect();
            }
        }

        return true;
    }

    public static function GetPublicPageData($page_name, $other_details)
    {
        $page_array = array();
        foreach($other_details as $array)
        {
           $page_array = array_merge($page_array, $array);
        }

        return array_merge_recursive(
            $page_array,
            array(
                "page" => array_merge(
                    self::GetPublicNavigationLinks(),
                    self::GetPublicPageURLs($page_name)
                )
            )
        );
    }

    public static function GetAdminPageData(
        $page_name, $other_details = array(), $has_nav = true
    )
    {
        $page_array = array();
        foreach($other_details as $array)
        {
           $page_array = array_merge($page_array, $array);
        }

        if($has_nav)
        {
            return array_merge_recursive(
                $page_array,
                array(
                    "page" => array_merge(
                        self::GetAdminNavigationLinks(),
                        self::GetAdminPageURLs($page_name)
                    )
                )
            );
        }
        else 
        {
            return array_merge_recursive(
                $page_array,
                array(
                    "page" => self::GetAdminPageURLs($page_name)
                )
            );
        }
    }

    public static function GetUserPageData(
        $page_name, $other_details = array()
    )
    {
        $page_array = array();
        foreach($other_details as $array)
        {
           $page_array = array_merge($page_array, $array);
        }

        return array_merge_recursive(
            $page_array,
            array(
                "page" => array_merge(
                    self::GetUserNavigationLinks($page_name),
                    self::GetUserNavigationSecondaryLinks($page_name),
                    self::GetUserPageURLs($page_name)
                )
            )
        );
    }

    private static function GetUserNavigationSecondaryLinks($page_name)
    {
        $navs = array();

        if(strpos($page_name, 'availability-') !== false)
        {
            $navs[] = array(
                "name" => "Manage Schedule",
                "url" => Url::GetBaseURL("availability/manage")
            );

            if(UserSession::IsFrontman()) 
            {
                $navs[] = array(
                    "name" => "Manage Schedule Groups",
                    "url" => Url::GetBaseURL("availability/group")
                );
                $navs[] = array(
                    "name" => "View Individual Schedule",
                    "url" => Url::GetBaseURL("availability/member")
                );
            }
            else
            {
                $navs[] = array(
                    "name" => "View Committee Schedule",
                    "url" => Url::GetBaseURL("availability/committee")
                );
            }

            return array(
                "nav_secondary" => $navs
            );
        }
        else if(strpos($page_name, 'task-') !== false)
        {
            $navs[] = array(
                "name" => "View Tasks",
                "url" => Url::GetBaseURL("task/view")
            );

            $navs[] = array(
                "name" => "Create Task",
                "url" => Url::GetBaseURL("task/add")
            );

            return array(
                "nav_secondary" => $navs
            );
        }
        else 
        {
            return array();
        }
    }

    private static function GetUserNavigationLinks($page_name)
    {
        if($page_name === "request-batch" || $page_name === "request-committee")
        {
            return array(
                "nav" => array(
                    array(
                        "name" => "Logout",
                        "url" => Url::GetBaseURL('action/logout')
                    )
                )
            );
        }

        $navs = array(
            array(
                "name" => "Task Manager",
                "url" => Url::GetBaseURL('task')
            ),
            array(
                "name" => "Availability Tracker",
                "url" => Url::GetBaseURL('availability')
            ),
            array(
                "name" => "Calendar",
                "url" => Url::GetBaseURL('calendar')
            ),
        );
        
        if(UserSession::IsFinanceMember())
        {
            $navs[] = array(
                "name" => "Finance Tracker",
                "url" => Url::GetBaseURL('finance')
            );
        }
        
        if(UserSession::IsCommitteeHead() || UserSession::IsFrontman())
        {
            $navs[] = array(
                "name" => "Member Manager",
                "url" => Url::GetBaseURL('member')
            );
        }

        $navs[] = array(
            "name" => "Logout",
            "url" => Url::GetBaseURL('action/logout')
        );

        return array("nav" => $navs);
    }

    private static function GetAdminNavigationLinks()
    {
        return array(
            "nav" => array(
                array(
                    "name" => "Manage Batch",
                    "url" => Url::GetBaseURL('admin/batch')
                ),
                array(
                    "name" => "Manage Members",
                    "url" => Url::GetBaseURL('admin/member')
                ),
                array(
                    "name" => "Change Password",
                    "url" => Url::GetBaseURL('admin/account/password')
                ),
                array(
                    "name" => "Logout",
                    "url" => Url::GetBaseURL('action/admin/logout')
                )
            )
        );
    }

    private static function GetPublicNavigationLinks()
    {
        return array(
            "nav" => array(
                array(
                    "name" => "Login",
                    "url" => Url::GetBaseURL('login')
                ),
                array(
                    "name" => "Sign Up",
                    "url" => Url::GetBaseURL('sign-up')
                )
            )
        );
    }

    private static function GetPublicPageURLs($page_name)
    {
        return self::GetPageURLs("public", "", $page_name);
    }

    private static function GetUserPageURLs($page_name)
    {
        return self::GetPageURLs("user", "", $page_name);
    }

    private static function GetAdminPageURLs($page_name)
    {
        return self::GetPageURLs("admin", "admin", $page_name);
    }

    private static function GetPageURLs($page_type, $index, $page_name)
    {
        $urls = array();

        $urls["base"] = Url::GetBaseURL();
        $urls["index"] = Url::GetBaseURL($index);

        $stylesheet = sprintf("public/css/%s/%s.css", $page_type, $page_name);
        if(file_exists($stylesheet))
        {
            $urls["stylesheet"] = Url::GetBaseURL($stylesheet);
        }
        else
        {
            $urls["stylesheet"] = "";
        }

        $script = sprintf("public/js/%s/%s.js", $page_type, $page_name);
        if(file_exists($script))
        {
            $urls["script"] = Url::GetBaseURL($script);
        }
        else
        {
            $urls["script"] = "";
        }

        return array("urls" => $urls);
    }

    private static function ShowForbiddenPage()
    {
        show_404();
    }
}
