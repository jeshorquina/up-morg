<?php
namespace Jesh\Operations\User;

use \Jesh\Helpers\Sort;
use \Jesh\Helpers\StringHelper;
use \Jesh\Helpers\ValidationDataBuilder;

use \Jesh\Models\TaskModel;
use \Jesh\Models\TaskSubscriberModel;

use \Jesh\Operations\Repository\BatchMember;
use \Jesh\Operations\Repository\Committee;
use \Jesh\Operations\Repository\Member;
use \Jesh\Operations\Repository\Task;

class TaskActionOperations
{
    private $batch_member;
    private $committee;
    private $member;

    public function __construct()
    {
        $this->batch_member = new BatchMember;
        $this->committee = new Committee;
        $this->member = new Member;
        $this->task = new Task;
    }

    public function GetFrontmanAddTaskPageDetails($batch_id, $frontman_id)
    {
        $frontmen = array(
            $this->member->GetMemberTypeID(Member::FIRST_FRONTMAN),
            $this->member->GetMemberTypeID(Member::SECOND_FRONTMAN),
            $this->member->GetMemberTypeID(Member::THIRD_FRONTMAN)
        );

        foreach($this->batch_member->GetBatchMembers($batch_id) as $member)
        {
            if(in_array($member->MemberTypeID, $frontmen))
            {
                $batch_member_ids[] = $member->BatchMemberID;
            }
        }

        $scoped_committees = (
            $this->committee->GetCommitteePermissionCommitteeIDs(
                $batch_id, $this->batch_member->GetMemberTypeID($frontman_id)
            )
        );

        foreach($scoped_committees as $committee_id) 
        {
            $batch_member_ids = array_merge(
                $batch_member_ids, 
                $this->committee->GetApprovedBatchMemberIDs($committee_id)
            );
        }

        $members = array();
        foreach($batch_member_ids as $batch_member_id)
        {
            $member_name = $this->GetMemberName(
                $this->batch_member->GetMemberID($batch_member_id)
            );
            $members[] = array(
                "id" => $batch_member_id,
                "name" => $member_name
            );
        }

        $events = array();

        $tasks = array();

        return array(
            "events" => $events,
            "members" => Sort::AssociativeArray(
                $members, "name", Sort::ASCENDING
            ),
            "self" => array(
                "id" => $frontman_id
            ),
            "tasks" => Sort::AssociativeArray($tasks, "id", Sort::DESCENDING)
        );
    }

    public function GetCommitteeHeadAddTaskPageDetails(
        $committee_id, $committee_head_id
    )
    {
        $batch_member_ids = (
            $this->committee->GetApprovedBatchMemberIDs($committee_id)
        );

        $members = array();
        foreach($batch_member_ids as $batch_member_id)
        {
            $member_name = $this->GetMemberName(
                $this->batch_member->GetMemberID($batch_member_id)
            );
            $members[] = array(
                "id" => $batch_member_id,
                "name" => $member_name
            );
        }

        $events = array();

        $tasks = array();

        return array(
            "events" => $events,
            "members" => Sort::AssociativeArray(
                $members, "name", Sort::ASCENDING
            ),
            "self" => array(
                "id" => $committee_head_id
            ),
            "tasks" => Sort::AssociativeArray($tasks, "id", Sort::DESCENDING)
        );
    }

    public function GetCommitteeMemberAddTaskPageDetails($committee_member_id)
    {
        $members = array();
        $members[] = array(
            "id" => $committee_member_id,
            "name" => $this->GetMemberName(
                $this->batch_member->GetMemberID($committee_member_id)
            )
        );

        $events = array();

        $tasks = array();

        return array(
            "events" => $events,
            "members" => $members,
            "self" => array(
                "id" => $committee_member_id
            ),
            "tasks" => Sort::AssociativeArray($tasks, "id", Sort::DESCENDING)
        );
    }

    public function ValidateAddTaskData($input_data)
    {
        $validation = new ValidationDataBuilder;

        $validation->CheckString(
            "task-title", $input_data["task-title"]
        );
        $validation->CheckString(
            "task-description", $input_data["task-description"]
        );
        $validation->CheckArray(
            "task-subscribers", $input_data["task-subscribers"]
        );
        $validation->CheckDate(
            "task-deadline", $input_data["task-deadline"]
        );
        $validation->CheckInteger(
            "task-assignee", $input_data["task-assignee"]
        );

        return array(
            "status"  => $validation->GetStatus(),
            "message" => array(
                "message" => StringHelper::NoBreakString(
                    "There are validation errors. Please check input data."
                ),
                "data" => $validation->GetValidationData()
            )
        );
    }

    public function IsTaskDeadlineValid($deadline)
    {
        return (
            \DateTime::createFromFormat("Y-m-d", $deadline) >= new \DateTime()
        );
    }

    public function IsSubscriberArrayValid($subscribers, $assignee, $reporter)
    {
        return (
            in_array($assignee, $subscribers) && 
            in_array($reporter, $subscribers)
        );
    }

    public function AreSubscribersSubordinates($subscribers, $get_details)
    {
        $subordinates = array();
        foreach($get_details["members"] as $member)
        {
            $subordinates[] = $member["id"];
        }

        foreach($subscribers as $subscriber)
        {
            if(!in_array($subscriber, $subordinates))
            {
                return false;
            }
        }
        return true;
    }

    public function IsAssigneeSubordinate($assignee, $get_details)
    {
        foreach($get_details["members"] as $member)
        {
            if($assignee == $member["id"])
            {
                return true;
            }
        }
        return false;
    }

    public function AddTask(
        $title, $description, $deadline, $reporter, $assignee, $subscribers
    )
    {
        $task_id = $this->task->AddTask(
            new TaskModel(
                array(
                    "TaskStatusID" => $this->task->GetTaskStatusID(Task::TODO),
                    "Reporter" => $reporter,
                    "Assignee" => $assignee,
                    "TaskTitle" => $title,
                    "TaskDescription" => $description,
                    "TaskDeadline" => $deadline
                )
            )
        );

        foreach($subscribers as $subscriber)
        {
            $this->task->AddSubscriber(
                new TaskSubscriberModel(
                    array(
                        "TaskID"        => $task_id,
                        "BatchMemberID" => $subscriber
                    )
                )
            );
        }

        return true;
    }

    private function GetMemberName($member_id)
    {
        $member = $this->member->GetMember($member_id);

        return str_replace(
            "  ", " ",
            sprintf(
                "%s %s %s", 
                $member->FirstName, 
                $member->MiddleName, 
                $member->LastName
            )
        ); 
    }
}
