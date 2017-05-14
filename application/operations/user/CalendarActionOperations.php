<?php
namespace Jesh\Operations\User;

use \Jesh\Helpers\StringHelper;
use \Jesh\Helpers\Url;
use \Jesh\Helpers\ValidationDataBuilder;

use \Jesh\Models\EventModel;

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

    public function HasEvent($event_id)
    {
        return $this->event->HasEvent($event_id);
    }

    public function GetCalendarEventDetails(
        $event_id, $batch_id, $batch_member_id, $committee_id
    )
    {
        $event_object = $this->event->GetEvent($event_id);

        return array(
            "details" => array(
                "name" => $event_object->EventName,
                "owner" => $this->GetMemberName(
                    $this->batch_member->GetMemberID($event_object->EventOwner)
                ),
                "date" => $this->MutateEventDate($event_object),
                "description" => $event_object->EventDescription
            ),
            "flags" => array(
                "edit" => $this->CanEditEvent(
                    $event_object, $batch_id, $batch_member_id, $committee_id
                )
            ),
            "tasks" => $this->GetTaskReferences($event_id)
        );
    }

    private function GetTaskReferences($event_id)
    {
        $tasks = array();
        foreach($this->task->GetTaskEventsByEventID($event_id) as $event)
        {
            $task = $this->task->GetTask($event->TaskID);

            $tasks[] = array(
                "id" => $task->TaskID,
                "title" => $task->TaskTitle,
                "status" => $this->task->GetTaskStatus(
                    $task->TaskStatusID
                ),
                "deadline" => $task->TaskDeadline
            );
        }
        return (sizeof($tasks) > 0) ? $tasks : false;
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

    private function MutateEventDate($event_object)
    {
        if($event_object->EventEndDate != null)
        {
            return sprintf(
                "%s to %s", 
                date("F j, Y", strtotime($event_object->EventStartDate)),
                date("F j, Y", strtotime($event_object->EventEndDate))
            );
        }
        else if($event_object->EventTime != null)
        {
            return date(
                "F j, Y - g:i a",
                strtotime(
                    sprintf(
                        "%s %s", 
                        $event_object->EventStartDate, 
                        $event_object->EventTime
                    )
                )
            );
        }
        else
        {
            return date("F j, Y", strtotime($event_object->EventStartDate));
        }
    }

    public function CanEditEventByID(
        $event_id, $batch_id, $batch_member_id, $committee_id
    )
    {
        $event_object = $this->event->GetEvent($event_id);
        return $this->CanEditEvent(
            $event_object, $batch_id, $batch_member_id, $committee_id
        );
    }

    private function CanEditEvent(
        $event_object, $batch_id, $batch_member_id, $committee_id
    )
    {
        if($event_object->EventOwner == $batch_member_id)
        {
            return true;
        }

        $member_type_id = $this->batch_member->GetMemberTypeID(
            $batch_member_id
        );
        $member_type = $this->member->GetMemberType($member_type_id);

        if($member_type == Member::FIRST_FRONTMAN)
        {
            return true;
        }
        else if($member_type == Member::COMMITTEE_MEMBER)
        {
            return false;
        }
        else if($member_type == Member::COMMITTEE_HEAD)
        {
            $batch_member_ids = (
                $this->committee->GetApprovedBatchMemberIDs($committee_id)
            );

            return in_array($event_object->EventOwner, $batch_member_ids);
        }
        else
        {
            $batch_member_ids = array();

            $scoped_committees = (
                $this->committee->GetCommitteePermissionCommitteeIDs(
                    $batch_id, $member_type_id
                )
            );

            foreach($scoped_committees as $committee_id) 
            {
                $batch_member_ids = array_merge(
                    $batch_member_ids, 
                    $this->committee->GetApprovedBatchMemberIDs($committee_id)
                );
            }

            return in_array($event_object->EventOwner, $batch_member_ids);
        }
    }

    public function DeleteEvent($event_id)
    {
        return $this->event->DeleteEvent($event_id);
    }

    public function GetEditEventDetails($event_id)
    {
        $event = $this->event->GetEvent($event_id);

        return array(
            "id" => $event->EventID,
            "name" => $event->EventName,
            "description" => $event->EventDescription,
            "date" => array(
                "start" => $event->EventStartDate,
                "end" => $event->EventEndDate
            ),
            "time" => $event->EventTime,
            "public" => (bool)$event->IsPublic
        );
    }

    public function ValidateEventData($input_data)
    {
        $validation = new ValidationDataBuilder;

        $validation->CheckString("event-name", $input_data["event-name"]);
        $validation->CheckString(
            "event-description", $input_data["event-description"]
        );
        $validation->CheckDate(
            "event-start-date", $input_data["event-start-date"]
        );
        if($input_data["event-end-date"] != null)
        {
            $validation->CheckDate(
                "event-end-date", $input_data["event-end-date"]
            );
        }
        if($input_data["event-time"] != null)
        {
            $validation->CheckTime(
                "event-time", $input_data["event-time"]
            );
        }

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

    public function HasValidEventDate($event_start_date, $event_end_date)
    {
        $now = new \DateTime();
        $start = \DateTime::createFromFormat("Y-m-d", $event_start_date);

        if($event_end_date != null)
        {
            $end = \DateTime::createFromFormat("Y-m-d", $event_end_date);
        }
        else
        {
            $end = $start;
        }

        return ($start <= $end && $start >= $now && $end >= $now);
    }

    public function AddEvent(
        $event_name, $event_start_date, $event_end_date, $event_time, 
        $event_owner, $is_public, $event_description
    ) 
    {
        return $this->event->AddEvent(
            new EventModel(
                array(
                    "EventOwner" => $event_owner,
                    "EventName" => $event_name,
                    "EventDescription" => $event_description,
                    "EventStartDate" => $event_start_date,
                    "EventEndDate" => $event_end_date,
                    "EventTime" => $event_time,
                    "IsPublic" => $is_public
                )
            )
        );
    }

    public function EditEvent(
        $event_id, $event_name, $event_start_date, $event_end_date, 
        $event_time, $event_owner, $is_public, $event_description
    )
    {
        return $this->event->EditEvent(
            $event_id,
            new EventModel(
                array(
                    "EventOwner" => $event_owner,
                    "EventName" => $event_name,
                    "EventDescription" => $event_description,
                    "EventStartDate" => $event_start_date,
                    "EventEndDate" => $event_end_date,
                    "EventTime" => $event_time,
                    "IsPublic" => $is_public
                )
            )
        );
    }
}
