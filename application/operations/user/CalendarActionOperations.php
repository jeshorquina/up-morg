<?php
namespace Jesh\Operations\User;

use \Jesh\Helpers\Url;

use \Jesh\Operations\Repository\BatchMember;
use \Jesh\Operations\Repository\Committee;
use \Jesh\Operations\Repository\Event;
use \Jesh\Operations\Repository\Member;
use \Jesh\Operations\Repository\Task;

class CalendarActionOperations
{
    private $batch_member;
    private $committee;
    private $event;
    private $member;
    private $task;

    public function __construct()
    {
        $this->batch_member = new BatchMember;
        $this->committee = new Committee;
        $this->event = new Event;
        $this->member = new Member;
        $this->task = new Task;
    }

    public function GetCalendarEventsPageDetails($batch_id)
    {
        $events = array();

        $batch_members = $this->batch_member->GetBatchMemberIDs($batch_id);
        foreach($batch_members as $batch_member_id)
        {
            $events = array_merge(
                $events, $this->event->GetEvents($batch_member_id)
            );
        }

        $return_events = array();
        foreach($events as $event)
        {
            $temp_event = array(
                "title" => $event->EventName,
                "url" => Url::GetBaseURL(
                    sprintf("calendar/events/details/%s", $event->EventID)
                )
            );

            if($event->EventEndDate != null)
            {
                $temp_event["start"] = $event->EventStartDate;
                $temp_event["end"] = $event->EventEndDate;
            }
            else if($event->EventTime != null)
            {
                $temp_event["start"] = sprintf(
                    "%sT%s",
                    $event->EventStartDate,
                    $event->EventTime
                );
            }
            else
            {
                $temp_event["start"] = $event->EventStartDate;
            }

            $return_events[] = $temp_event;
        }

        return $return_events;
    }

    public function GetFrontmanCalendarTaskPageDetails(
        $batch_member_id, $batch_id
    )
    {
        $tasks = array();
        foreach($this->task->GetAssignedTasks($batch_member_id) as $task)
        {
            $tasks[$task->TaskID] = $this->GetCalendarTaskEntry($task);
        }

        foreach($this->task->GetReportedTasks($batch_member_id) as $task)
        {
            if(!array_key_exists($task->TaskID, $tasks))
            {
                $tasks[$task->TaskID] = $this->GetCalendarTaskEntry($task);
            }
        }

        foreach($this->task->GetSubscribedTaskIDs($batch_member_id) as $task)
        {
            if(!array_key_exists($task->TaskID, $tasks))
            {
                $tasks[$task->TaskID] = $this->GetCalendarTaskEntry($task);
            }
        }

        $frontmen = array(
            $this->member->GetMemberTypeID(Member::FIRST_FRONTMAN),
            $this->member->GetMemberTypeID(Member::SECOND_FRONTMAN),
            $this->member->GetMemberTypeID(Member::THIRD_FRONTMAN)
        );

        $batch_member_ids = array();
        foreach($this->batch_member->GetBatchMembers($batch_id) as $member)
        {
            if(in_array($member->MemberTypeID, $frontmen))
            {
                $batch_member_ids[] = $member->BatchMemberID;
            }
        }

        $scoped_committees = (
            $this->committee->GetCommitteePermissionCommitteeIDs(
                $batch_id, $this->batch_member->GetMemberTypeID(
                    $batch_member_id
                )
            )
        );

        foreach($scoped_committees as $committee_id) 
        {
            $batch_member_ids = array_merge(
                $batch_member_ids, 
                $this->committee->GetApprovedBatchMemberIDs($committee_id)
            );
        }

        foreach($batch_member_ids as $batch_member_id)
        {
            foreach($this->task->GetAssignedTasks($batch_member_id) as $task)
            {
                if(!array_key_exists($task->TaskID, $tasks))
                {
                    $tasks[$task->TaskID] = $this->GetCalendarTaskEntry($task);
                }
            }

            foreach($this->task->GetReportedTasks($batch_member_id) as $task)
            {
                if(
                    !array_key_exists($task->TaskID, $tasks) && 
                    in_array($task->Assignee, $batch_member_ids)
                )
                {
                    $tasks[$task->TaskID] = $this->GetCalendarTaskEntry($task);
                }
            }
        }

        $return_tasks = array();
        foreach($tasks as $details)
        {
            if($details)
            {
                $return_tasks[] = $details;
            }
        }
        return $return_tasks;
    }

    public function GetCommitteeHeadCalendarTaskPageDetails(
        $batch_member_id, $committee_id
    )
    {
        $tasks = array();

        foreach($this->task->GetAssignedTasks($batch_member_id) as $task)
        {
            if(!array_key_exists($task->TaskID, $tasks))
            {
                $tasks[$task->TaskID] = $this->GetCalendarTaskEntry($task);
            }
        }

        foreach($this->task->GetReportedTasks($batch_member_id) as $task)
        {
            if(!array_key_exists($task->TaskID, $tasks))
            {
                $tasks[$task->TaskID] = $this->GetCalendarTaskEntry($task);
            }
        }

        foreach($this->task->GetSubscribedTaskIDs($batch_member_id) as $task)
        {
            if(!array_key_exists($task->TaskID, $tasks))
            {
                $tasks[$task->TaskID] = $this->GetCalendarTaskEntry($task);
            }
        }

        $batch_member_ids = (
            $this->committee->GetApprovedBatchMemberIDs($committee_id)
        );

        $other_tasks = array();
        foreach($batch_member_ids as $batch_member_id)
        {
            foreach($this->task->GetAssignedTasks($batch_member_id) as $task)
            {
                if(!array_key_exists($task->TaskID, $tasks))
                {
                    $tasks[$task->TaskID] = $this->GetCalendarTaskEntry($task);
                }
            }

            foreach($this->task->GetReportedTasks($batch_member_id) as $task)
            {
                if(!array_key_exists($task->TaskID, $tasks))
                {
                    $tasks[$task->TaskID] = $this->GetCalendarTaskEntry($task);
                }
            }
        }

        $return_tasks = array();
        foreach($tasks as $details)
        {
            if($details)
            {
                $return_tasks[] = $details;
            }
        }
        return $return_tasks;
    }

    public function GetCommitteeMemberCalendarTaskPageDetails($batch_member_id)
    {
        $tasks = array();

        foreach($this->task->GetAssignedTasks($batch_member_id) as $task)
        {
            $tasks[$task->TaskID] = $this->GetCalendarTaskEntry($task);
        }

        foreach($this->task->GetSubscribedTaskIDs($batch_member_id) as $task)
        {
            if(!array_key_exists($task->TaskID, $tasks))
            {
                $tasks[$task->TaskID] = $this->GetCalendarTaskEntry($task);
            }
        }

        $return_tasks = array();
        foreach($tasks as $details)
        {
            if($details)
            {
                $return_tasks[] = $details;
            }
        }
        return $return_tasks;
    }

    private function GetCalendarTaskEntry($task)
    {
        switch($this->task->GetTaskStatus($task->TaskStatusID))
        {
            case Task::TODO:
                $class = "label-gray";
                break;
            case Task::IN_PROGRESS:
                $class = "label-yellow";
                break;
            case Task::FOR_REVIEW:
                $class = "label-blue";
                break;
            case Task::ACCEPTED:
                $class = "label-green";
                break;
            case Task::NEEDS_CHANGES:
                $class = "label-red";
                break;
            case Task::DONE:
                return false;
                break;
            default:
                $class = "label-blue";
                break;
        }

        return array(
            "title" => $task->TaskTitle,
            "start" => $task->TaskDeadline,
            "url" => Url::GetBaseURL(
                sprintf("task/view/details/%s", $task->TaskID)
            ),
            "className" => $class,
            "textColor" => "#FFF"
        );
    }
}
