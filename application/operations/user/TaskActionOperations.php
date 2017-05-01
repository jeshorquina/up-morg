<?php
namespace Jesh\Operations\User;

use \Jesh\Helpers\Sort;
use \Jesh\Helpers\StringHelper;
use \Jesh\Helpers\ValidationDataBuilder;

use \Jesh\Models\TaskModel;
use \Jesh\Models\TaskSubscriberModel;
use \Jesh\Models\TaskTreeModel;

use \Jesh\Operations\Repository\BatchMember;
use \Jesh\Operations\Repository\Committee;
use \Jesh\Operations\Repository\Member;
use \Jesh\Operations\Repository\Task;

class TaskActionOperations
{
    private $batch_member;
    private $committee;
    private $member;
    private $task;

    public function __construct()
    {
        $this->batch_member = new BatchMember;
        $this->committee = new Committee;
        $this->member = new Member;
        $this->task = new Task;
    }

    public function GetFrontmanViewTaskPageDetails(
        $batch_member_id, $batch_id
    )
    {
        $task_ids = array();
        $tasks = array();

        $assigned_tasks = array();
        foreach($this->task->GetAssignedTasks($batch_member_id) as $task)
        {
            $temp_task = array(
                "id" => $task->TaskID,
                "title" => $task->TaskTitle,
                "description" => $task->TaskDescription,
                "deadline" => $task->TaskDeadline,
                "reporter" => $this->GetMemberName(
                    $this->batch_member->GetMemberID($task->Reporter)
                ),
                "assignee" => $this->GetMemberName(
                    $this->batch_member->GetMemberID($task->Assignee)
                )
            );

            if($this->task->HasParentTask($task->TaskID))
            {
                $temp_task["parent"] = (
                    $this->task->GetParentTaskID($task->TaskID)
                );
            }
            else 
            {
                $temp_task["parent"] = null;
            }

            $assigned_tasks[] = $temp_task;
            $task_ids[] = $task->TaskID;
        }

        $tasks[] = array(
            "name" => "Assigned Tasks",
            "tasks" => Sort::AssociativeArray(
                $assigned_tasks, "deadline", Sort::ASCENDING
            )
        );

        $reported_tasks = array();
        foreach($this->task->GetReportedTasks($batch_member_id) as $task)
        {
            if(!in_array($task->TaskID, $task_ids))
            {
                $temp_task = array(
                    "id" => $task->TaskID,
                    "title" => $task->TaskTitle,
                    "description" => $task->TaskDescription,
                    "deadline" => $task->TaskDeadline,
                    "reporter" => $this->GetMemberName(
                        $this->batch_member->GetMemberID($task->Reporter)
                    ),
                    "assignee" => $this->GetMemberName(
                        $this->batch_member->GetMemberID($task->Assignee)
                    )
                );

                if($this->task->HasParentTask($task->TaskID))
                {
                    $temp_task["parent"] = (
                        $this->task->GetParentTaskID($task->TaskID)
                    );
                }
                else 
                {
                    $temp_task["parent"] = null;
                }

                $reported_tasks[] = $temp_task;
                $task_ids[] = $task->TaskID;
            }
        }

        $tasks[] = array(
            "name" => "Reported Tasks",
            "tasks" => Sort::AssociativeArray(
                $reported_tasks, "deadline", Sort::ASCENDING
            )
        );

        $subscribed_tasks = array();
        foreach($this->task->GetSubscribedTaskIDs($batch_member_id) as $task)
        {
            if(!in_array($task->TaskID, $task_ids))
            {
                 $temp_task = array(
                    "id" => $task->TaskID,
                    "title" => $task->TaskTitle,
                    "description" => $task->TaskDescription,
                    "deadline" => $task->TaskDeadline,
                    "reporter" => $this->GetMemberName(
                        $this->batch_member->GetMemberID($task->Reporter)
                    ),
                    "assignee" => $this->GetMemberName(
                        $this->batch_member->GetMemberID($task->Assignee)
                    )
                );

                if($this->task->HasParentTask($task->TaskID))
                {
                    $parent = $this->task->GetParentTaskID($task->TaskID);

                    if($this->task->IsTaskSubscriber($parent, $batch_member_id))
                    {
                        $temp_task["parent"] = $parent;
                    }
                    else
                    {
                        $temp_task["parent"] = null;
                    }
                }
                else 
                {
                    $temp_task["parent"] = null;
                }

                $subscribed_tasks[] = $temp_task;
                $task_ids[] = $task->TaskID;
            }
        }

        $tasks[] = array(
            "name" => "Subscribed Tasks",
            "tasks" => Sort::AssociativeArray(
                $subscribed_tasks, "deadline", Sort::ASCENDING
            )
        );

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
                $batch_id, $this->batch_member->GetMemberTypeID($batch_member_id)
            )
        );

        foreach($scoped_committees as $committee_id) 
        {
            $batch_member_ids = array_merge(
                $batch_member_ids, 
                $this->committee->GetApprovedBatchMemberIDs($committee_id)
            );
        }

        $other_tasks = array();
        foreach($batch_member_ids as $batch_member_id)
        {
            foreach($this->task->GetAssignedTasks($batch_member_id) as $task)
            {
                if(!in_array($task->TaskID, $task_ids))
                {
                    $temp_task = array(
                        "id" => $task->TaskID,
                        "title" => $task->TaskTitle,
                        "description" => $task->TaskDescription,
                        "deadline" => $task->TaskDeadline,
                        "reporter" => $this->GetMemberName(
                            $this->batch_member->GetMemberID($task->Reporter)
                        ),
                        "assignee" => $this->GetMemberName(
                            $this->batch_member->GetMemberID($task->Assignee)
                        )
                    );

                    if($this->task->HasParentTask($task->TaskID))
                    {
                        $temp_task["parent"] = (
                            $this->task->GetParentTaskID($task->TaskID)
                        );
                    }
                    else 
                    {
                        $temp_task["parent"] = null;
                    }

                    $other_tasks[] = $temp_task;
                    $task_ids[] = $task->TaskID;
                }
            }

            foreach($this->task->GetReportedTasks($batch_member_id) as $task)
            {
                if(!in_array($task->TaskID, $task_ids))
                {
                    $temp_task = array(
                        "id" => $task->TaskID,
                        "title" => $task->TaskTitle,
                        "description" => $task->TaskDescription,
                        "deadline" => $task->TaskDeadline,
                        "reporter" => $this->GetMemberName(
                            $this->batch_member->GetMemberID($task->Reporter)
                        ),
                        "assignee" => $this->GetMemberName(
                            $this->batch_member->GetMemberID($task->Assignee)
                        )
                    );

                    if($this->task->HasParentTask($task->TaskID))
                    {
                        $temp_task["parent"] = (
                            $this->task->GetParentTaskID($task->TaskID)
                        );
                    }
                    else 
                    {
                        $temp_task["parent"] = null;
                    }

                    $other_tasks[] = $temp_task;
                    $task_ids[] = $task->TaskID;
                }
            }
        }

        $tasks[] = array(
            "name" => "Other Tasks",
            "tasks" => Sort::AssociativeArray(
                $other_tasks, "deadline", Sort::ASCENDING
            )
        );

        return $tasks;
    }

    public function GetCommitteeHeadViewTaskPageDetails(
        $batch_member_id, $committee_id
    )
    {
        $task_ids = array();
        $tasks = array();

        $assigned_tasks = array();
        foreach($this->task->GetAssignedTasks($batch_member_id) as $task)
        {
            $temp_task = array(
                "id" => $task->TaskID,
                "title" => $task->TaskTitle,
                "description" => $task->TaskDescription,
                "deadline" => $task->TaskDeadline,
                "reporter" => $this->GetMemberName(
                    $this->batch_member->GetMemberID($task->Reporter)
                ),
                "assignee" => $this->GetMemberName(
                    $this->batch_member->GetMemberID($task->Assignee)
                )
            );

            if($this->task->HasParentTask($task->TaskID))
            {
                $temp_task["parent"] = (
                    $this->task->GetParentTaskID($task->TaskID)
                );
            }
            else 
            {
                $temp_task["parent"] = null;
            }

            $assigned_tasks[] = $temp_task;
            $task_ids[] = $task->TaskID;
        }

        $tasks[] = array(
            "name" => "Assigned Tasks",
            "tasks" => Sort::AssociativeArray(
                $assigned_tasks, "deadline", Sort::ASCENDING
            )
        );

        $reported_tasks = array();
        foreach($this->task->GetReportedTasks($batch_member_id) as $task)
        {
            if(!in_array($task->TaskID, $task_ids))
            {
                $temp_task = array(
                    "id" => $task->TaskID,
                    "title" => $task->TaskTitle,
                    "description" => $task->TaskDescription,
                    "deadline" => $task->TaskDeadline,
                    "reporter" => $this->GetMemberName(
                        $this->batch_member->GetMemberID($task->Reporter)
                    ),
                    "assignee" => $this->GetMemberName(
                        $this->batch_member->GetMemberID($task->Assignee)
                    )
                );

                if($this->task->HasParentTask($task->TaskID))
                {
                    $temp_task["parent"] = (
                        $this->task->GetParentTaskID($task->TaskID)
                    );
                }
                else 
                {
                    $temp_task["parent"] = null;
                }

                $reported_tasks[] = $temp_task;
                $task_ids[] = $task->TaskID;
            }
        }

        $tasks[] = array(
            "name" => "Reported Tasks",
            "tasks" => Sort::AssociativeArray(
                $reported_tasks, "deadline", Sort::ASCENDING
            )
        );

        $subscribed_tasks = array();
        foreach($this->task->GetSubscribedTaskIDs($batch_member_id) as $task)
        {
            if(!in_array($task->TaskID, $task_ids))
            {
                 $temp_task = array(
                    "id" => $task->TaskID,
                    "title" => $task->TaskTitle,
                    "description" => $task->TaskDescription,
                    "deadline" => $task->TaskDeadline,
                    "reporter" => $this->GetMemberName(
                        $this->batch_member->GetMemberID($task->Reporter)
                    ),
                    "assignee" => $this->GetMemberName(
                        $this->batch_member->GetMemberID($task->Assignee)
                    )
                );

                if($this->task->HasParentTask($task->TaskID))
                {
                    $parent = $this->task->GetParentTaskID($task->TaskID);

                    if($this->task->IsTaskSubscriber($parent, $batch_member_id))
                    {
                        $temp_task["parent"] = $parent;
                    }
                    else
                    {
                        $temp_task["parent"] = null;
                    }
                }
                else 
                {
                    $temp_task["parent"] = null;
                }

                $subscribed_tasks[] = $temp_task;
                $task_ids[] = $task->TaskID;
            }
        }

        $tasks[] = array(
            "name" => "Subscribed Tasks",
            "tasks" => Sort::AssociativeArray(
                $subscribed_tasks, "deadline", Sort::ASCENDING
            )
        );

        $batch_member_ids = (
            $this->committee->GetApprovedBatchMemberIDs($committee_id)
        );

        $other_tasks = array();
        foreach($batch_member_ids as $batch_member_id)
        {
            foreach($this->task->GetAssignedTasks($batch_member_id) as $task)
            {
                if(!in_array($task->TaskID, $task_ids))
                {
                    $temp_task = array(
                        "id" => $task->TaskID,
                        "title" => $task->TaskTitle,
                        "description" => $task->TaskDescription,
                        "deadline" => $task->TaskDeadline,
                        "reporter" => $this->GetMemberName(
                            $this->batch_member->GetMemberID($task->Reporter)
                        ),
                        "assignee" => $this->GetMemberName(
                            $this->batch_member->GetMemberID($task->Assignee)
                        )
                    );

                    if($this->task->HasParentTask($task->TaskID))
                    {
                        $temp_task["parent"] = (
                            $this->task->GetParentTaskID($task->TaskID)
                        );
                    }
                    else 
                    {
                        $temp_task["parent"] = null;
                    }

                    $other_tasks[] = $temp_task;
                    $task_ids[] = $task->TaskID;
                }
            }

            foreach($this->task->GetReportedTasks($batch_member_id) as $task)
            {
                if(!in_array($task->TaskID, $task_ids))
                {
                    $temp_task = array(
                        "id" => $task->TaskID,
                        "title" => $task->TaskTitle,
                        "description" => $task->TaskDescription,
                        "deadline" => $task->TaskDeadline,
                        "reporter" => $this->GetMemberName(
                            $this->batch_member->GetMemberID($task->Reporter)
                        ),
                        "assignee" => $this->GetMemberName(
                            $this->batch_member->GetMemberID($task->Assignee)
                        )
                    );

                    if($this->task->HasParentTask($task->TaskID))
                    {
                        $temp_task["parent"] = (
                            $this->task->GetParentTaskID($task->TaskID)
                        );
                    }
                    else 
                    {
                        $temp_task["parent"] = null;
                    }

                    $other_tasks[] = $temp_task;
                    $task_ids[] = $task->TaskID;
                }
            }
        }

        $tasks[] = array(
            "name" => "Other Tasks",
            "tasks" => Sort::AssociativeArray(
                $other_tasks, "deadline", Sort::ASCENDING
            )
        );

        return $tasks;
    }

    public function GetCommitteeMemberViewTaskPageDetails($batch_member_id)
    {
        $task_ids = array();
        $tasks = array();

        $assigned_tasks = array();
        foreach($this->task->GetAssignedTasks($batch_member_id) as $task)
        {
            $temp_task = array(
                "id" => $task->TaskID,
                "title" => $task->TaskTitle,
                "description" => $task->TaskDescription,
                "deadline" => $task->TaskDeadline,
                "reporter" => $this->GetMemberName(
                    $this->batch_member->GetMemberID($task->Reporter)
                ),
                "assignee" => $this->GetMemberName(
                    $this->batch_member->GetMemberID($task->Assignee)
                )
            );

            if($this->task->HasParentTask($task->TaskID))
            {
                $temp_task["parent"] = (
                    $this->task->GetParentTaskID($task->TaskID)
                );
            }
            else 
            {
                $temp_task["parent"] = null;
            }

            $assigned_tasks[] = $temp_task;
            $task_ids[] = $task->TaskID;
        }

        $tasks[] = array(
            "name" => "Assigned Tasks",
            "tasks" => Sort::AssociativeArray(
                $assigned_tasks, "deadline", Sort::ASCENDING
            )
        );

        $subscribed_tasks = array();
        foreach($this->task->GetSubscribedTaskIDs($batch_member_id) as $task)
        {
            if(!in_array($task->TaskID, $task_ids))
            {
                 $temp_task = array(
                    "id" => $task->TaskID,
                    "title" => $task->TaskTitle,
                    "description" => $task->TaskDescription,
                    "deadline" => $task->TaskDeadline,
                    "reporter" => $this->GetMemberName(
                        $this->batch_member->GetMemberID($task->Reporter)
                    ),
                    "assignee" => $this->GetMemberName(
                        $this->batch_member->GetMemberID($task->Assignee)
                    )
                );

                if($this->task->HasParentTask($task->TaskID))
                {
                    $parent = $this->task->GetParentTaskID($task->TaskID);

                    if($this->task->IsTaskSubscriber($parent, $batch_member_id))
                    {
                        $temp_task["parent"] = $parent;
                    }
                    else
                    {
                        $temp_task["parent"] = null;
                    }
                }
                else 
                {
                    $temp_task["parent"] = null;
                }

                $subscribed_tasks[] = $temp_task;
                $task_ids[] = $task->TaskID;
            }
        }

        $tasks[] = array(
            "name" => "Subscribed Tasks",
            "tasks" => Sort::AssociativeArray(
                $subscribed_tasks, "deadline", Sort::ASCENDING
            )
        );

        return $tasks;
    }

    public function GetFrontmanAddTaskPageDetails(
        $batch_id, $frontman_id, $is_first_frontman
    )
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
        $tasks = array();

        foreach($batch_member_ids as $batch_member_id)
        {
            // members
            $member_name = $this->GetMemberName(
                $this->batch_member->GetMemberID($batch_member_id)
            );
            $members[] = array(
                "id" => $batch_member_id,
                "name" => $member_name
            );

            // tasks
            $task_ids = array();
            foreach($this->task->GetAssignedTasks($batch_member_id) as $task)
            {
                if($this->CheckParentTaskValid($task))
                {
                    if($is_first_frontman)
                    {
                        $tasks[] = array(
                            "id" => $task->TaskID,
                            "name" => $task->TaskTitle
                        );
                        $task_ids[] = $task->TaskID;
                    }
                    else if($task->Reporter == $frontman_id)
                    {
                        $tasks[] = array(
                            "id" => $task->TaskID,
                            "name" => $task->TaskTitle
                        );
                        $task_ids[] = $task->TaskID;
                    }
                }
            }
        }

        $events = array();

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
        $tasks = array();

        foreach($batch_member_ids as $batch_member_id)
        {
            // members
            $member_name = $this->GetMemberName(
                $this->batch_member->GetMemberID($batch_member_id)
            );
            $members[] = array(
                "id" => $batch_member_id,
                "name" => $member_name
            );

            // tasks
            $task_ids = array();
            foreach($this->task->GetAssignedTasks($batch_member_id) as $task)
            {
                if($this->CheckParentTaskValid($task))
                {
                    if($task->Reporter == $committee_head_id)
                    {
                        $tasks[] = array(
                            "id" => $task->TaskID,
                            "name" => $task->TaskTitle
                        );
                        $task_ids[] = $task->TaskID;
                    }
                }
            }
        }

        $events = array();

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
        $task_ids = array();
        foreach($this->task->GetAssignedTasks($committee_member_id) as $task)
        {
            if($this->CheckParentTaskValid($task))
            {
                $tasks[] = array(
                    "id" => $task->TaskID,
                    "name" => $task->TaskTitle
                );
                $task_ids[] = $task->TaskID;
            }
        }

        foreach($this->task->GetReportedTasks($committee_member_id) as $task)
        {
            if($this->CheckParentTaskValid($task))
            {
                if(!in_array($task->TaskID, $task_ids))
                {
                    $tasks[] = array(
                        "id" => $task->TaskID,
                        "name" => $task->TaskTitle
                    );
                    $task_ids[] = $task->TaskID;
                }
            }
        }

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

    public function CheckParentTaskValidByID($task_id)
    {
        if($task_id !== null)
        {
            return $this->CheckParentTaskValid($this->task->GetTask($task_id));
        }
        else
        {
            return true;
        }
    }   

    private function CheckParentTaskValid($task)
    {
        return (
            $this->IsTaskDeadlineValid($task->TaskDeadline) &&
            !$this->task->HasParentTask($task->TaskID)
        );
    }

    public function AddTask(
        $title, $description, $deadline, $reporter, $assignee, $subscribers,
        $parent
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

        if($parent !== null)
        {
            $this->task->AddParentTask(
                new TaskTreeModel(
                    array(
                        "ChildTaskID" => $task_id,
                        "ParentTaskID" => $parent
                    )
                )
            );
        }

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
