<?php
namespace Jesh\Operations\User;

use \Jesh\Helpers\Sort;
use \Jesh\Helpers\StringHelper;
use \Jesh\Helpers\Url;
use \Jesh\Helpers\ValidationDataBuilder;

use \Jesh\Models\TaskModel;
use \Jesh\Models\TaskCommentModel;
use \Jesh\Models\TaskEventModel;
use \Jesh\Models\TaskSubmissionModel;
use \Jesh\Models\TaskSubscriberModel;
use \Jesh\Models\TaskTreeModel;

use \Jesh\Operations\Repository\BatchMember;
use \Jesh\Operations\Repository\Committee;
use \Jesh\Operations\Repository\Event;
use \Jesh\Operations\Repository\Member;
use \Jesh\Operations\Repository\Task;

class TaskActionOperations
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

    public function GetFrontmanViewTaskPageDetails(
        $batch_member_id, $batch_id
    )
    {
        $task_ids = array();
        $tasks = array();

        $assigned_tasks = array();
        foreach($this->task->GetAssignedTasks($batch_member_id) as $task)
        {
            $assigned_tasks[] = $this->MutateTaskDetails($task);
            $task_ids[] = $task->TaskID;
        }

        $reported_tasks = array();
        foreach($this->task->GetReportedTasks($batch_member_id) as $task)
        {
            if(!in_array($task->TaskID, $task_ids))
            {
                $reported_tasks[] = $this->MutateTaskDetails($task);
                $task_ids[] = $task->TaskID;
            }
        }

        $subscribed_tasks = array();
        foreach($this->task->GetSubscribedTaskIDs($batch_member_id) as $task)
        {
            if(!in_array($task->TaskID, $task_ids))
            {
                $subscribed_tasks[] = $this->MutateTaskDetails($task);
                $task_ids[] = $task->TaskID;
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

        $batch_member_ids = array_intersect(
            $batch_member_ids,
            $this->batch_member->GetBatchMemberIDs($batch_id)
        );

        $other_tasks = array();
        foreach($batch_member_ids as $batch_member_id)
        {
            foreach($this->task->GetAssignedTasks($batch_member_id) as $task)
            {
                if(!in_array($task->TaskID, $task_ids))
                {
                    $other_tasks[] = $this->MutateTaskDetails($task);
                    $task_ids[] = $task->TaskID;
                }
            }

            foreach($this->task->GetReportedTasks($batch_member_id) as $task)
            {
                if(
                    !in_array($task->TaskID, $task_ids) && 
                    in_array($task->Assignee, $batch_member_ids)
                )
                {
                    $other_tasks[] = $this->MutateTaskDetails($task);
                    $task_ids[] = $task->TaskID;
                }
            }
        }

        return array(
            array(
                "name" => "Assigned Tasks",
                "tasks" => Sort::AssociativeArray(
                    $assigned_tasks, "deadline", Sort::ASCENDING
                )
            ),
            array(
                "name" => "Reported Tasks",
                "tasks" => Sort::AssociativeArray(
                    $reported_tasks, "deadline", Sort::ASCENDING
                )
            ),
            array(
                "name" => "Subscribed Tasks",
                "tasks" => Sort::AssociativeArray(
                    $subscribed_tasks, "deadline", Sort::ASCENDING
                )
            ),
            array(
                "name" => "Other Tasks",
                "tasks" => Sort::AssociativeArray(
                    $other_tasks, "deadline", Sort::ASCENDING
                )
            )
        );
    }

    public function GetCommitteeHeadViewTaskPageDetails(
        $batch_id, $batch_member_id, $committee_id
    )
    {
        $task_ids = array();
        $tasks = array();

        $assigned_tasks = array();
        foreach($this->task->GetAssignedTasks($batch_member_id) as $task)
        {
            $assigned_tasks[] = $this->MutateTaskDetails($task);
            $task_ids[] = $task->TaskID;
        }

        $reported_tasks = array();
        foreach($this->task->GetReportedTasks($batch_member_id) as $task)
        {
            if(!in_array($task->TaskID, $task_ids))
            {
                $reported_tasks[] = $this->MutateTaskDetails($task);
                $task_ids[] = $task->TaskID;
            }
        }

        $subscribed_tasks = array();
        foreach($this->task->GetSubscribedTaskIDs($batch_member_id) as $task)
        {
            if(!in_array($task->TaskID, $task_ids))
            {
                $subscribed_tasks[] = $this->MutateTaskDetails($task);
                $task_ids[] = $task->TaskID;
            }
        }

        $batch_member_ids = (
            $this->committee->GetApprovedBatchMemberIDs($committee_id)
        );

        $batch_member_ids = array_intersect(
            $batch_member_ids,
            $this->batch_member->GetBatchMemberIDs($batch_id)
        );

        $other_tasks = array();
        foreach($batch_member_ids as $batch_member_id)
        {
            foreach($this->task->GetAssignedTasks($batch_member_id) as $task)
            {
                if(!in_array($task->TaskID, $task_ids))
                {
                    $other_tasks[] = $this->MutateTaskDetails($task);
                    $task_ids[] = $task->TaskID;
                }
            }

            foreach($this->task->GetReportedTasks($batch_member_id) as $task)
            {
                if(!in_array($task->TaskID, $task_ids))
                {
                    $other_tasks[] = $this->MutateTaskDetails($task);
                    $task_ids[] = $task->TaskID;
                }
            }
        }

        return array(
            array(
                "name" => "Assigned Tasks",
                "tasks" => Sort::AssociativeArray(
                    $assigned_tasks, "deadline", Sort::ASCENDING
                )
            ),
            array(
                "name" => "Reported Tasks",
                "tasks" => Sort::AssociativeArray(
                    $reported_tasks, "deadline", Sort::ASCENDING
                )
            ),
            array(
                "name" => "Subscribed Tasks",
                "tasks" => Sort::AssociativeArray(
                    $subscribed_tasks, "deadline", Sort::ASCENDING
                )
            ),
            array(
                "name" => "Other Tasks",
                "tasks" => Sort::AssociativeArray(
                    $other_tasks, "deadline", Sort::ASCENDING
                )
            )
        );
    }

    public function GetCommitteeMemberViewTaskPageDetails($batch_member_id)
    {
        $task_ids = array();
        $tasks = array();

        $assigned_tasks = array();
        foreach($this->task->GetAssignedTasks($batch_member_id) as $task)
        {
            $assigned_tasks[] = $this->MutateTaskDetails($task);
            $task_ids[] = $task->TaskID;
        }

        $subscribed_tasks = array();
        foreach($this->task->GetSubscribedTaskIDs($batch_member_id) as $task)
        {
            if(!in_array($task->TaskID, $task_ids))
            {
                $subscribed_tasks[] = $this->MutateTaskDetails($task);
                $task_ids[] = $task->TaskID;
            }
        }

        return array(
            array(
                "name" => "Assigned Tasks",
                "tasks" => Sort::AssociativeArray(
                    $assigned_tasks, "deadline", Sort::ASCENDING
                )
            ),
            array(
                "name" => "Subscribed Tasks",
                "tasks" => Sort::AssociativeArray(
                    $subscribed_tasks, "deadline", Sort::ASCENDING
                )
            )
        );
    }

    public function HasTask($task_id)
    {
        return $this->task->HasTask($task_id);
    }

    public function HasTaskAccess($task_id, $batch_member_id)
    {
        $task_object = $this->task->GetTask($task_id);

        if($task_object->Assignee == $batch_member_id)
        {
            return $task_object;
        }
        else if($task_object->Reporter == $batch_member_id)
        {
            return $task_object;
        }
        
        $task_subscribers = $this->task->GetTaskSubscribersByTaskID($task_id);

        if(in_array($batch_member_id, $task_subscribers))
        {
            return $task_object;
        }

        $member_type = $this->member->GetMemberType(
            $this->batch_member->GetMemberTypeID(
                $batch_member_id
            )
        );
        if($member_type == Member::FIRST_FRONTMAN)
        {
            return $task_object;
        }
        else if(
            $member_type == Member::SECOND_FRONTMAN || 
            $member_type == Member::THIRD_FRONTMAN
        )
        {
            $frontmen = array(
                $this->member->GetMemberTypeID(Member::FIRST_FRONTMAN),
                $this->member->GetMemberTypeID(Member::SECOND_FRONTMAN),
                $this->member->GetMemberTypeID(Member::THIRD_FRONTMAN)
            );
            $assignee_member_type = $this->batch_member->GetMemberTypeID(
                $task_object->Assignee
            );

            if(in_array($assignee_member_type, $frontmen))
            {
                return $task_object;
            }
        
            $committee_id = $this->committee->GetCommitteeIDByBatchMemberID(
                $task_object->Assignee
            );
            $scoped_committees = (
                $this->committee->GetCommitteePermissionCommitteeIDs(
                    $this->batch_member->GetBatchID($batch_member_id), 
                    $this->batch_member->GetMemberTypeID($batch_member_id)
                )
            );

            if(in_array($committee_id, $scoped_committees))
            {
                return $task_object;
            }
            else
            {
                return false;
            }
        }
        else if($member_type == Member::COMMITTEE_HEAD)
        {
            $frontmen = array(
                Member::FIRST_FRONTMAN,
                Member::SECOND_FRONTMAN,
                Member::THIRD_FRONTMAN
            );

            $assignee_member_type = $this->member->GetMemberType(
                $this->batch_member->GetMemberTypeID(
                    $task_object->Assignee
                )
            );
            if(in_array($assignee_member_type, $frontmen))
            {
                return false;
            }

            $assignee_committee_id = (
                $this->committee->GetCommitteeIDByBatchMemberID(
                    $task_object->Assignee
                )
            );
            $head_committee_id = (
                $this->committee->GetCommitteeIDByBatchMemberID(
                    $batch_member_id
                )
            );
            if($assignee_committee_id == $head_committee_id)
            {
                return $task_object;
            }
            else 
            {
                return false;
            }
        }
        else
        {
            if($this->task->IsTaskSubscriber($task_id, $batch_member_id))
            {
                return $task_object;
            }
            else
            {
                return false;
            }
        }
    }

    public function GetFrontmanTaskDetailsPageDetails(
        $task_object, $batch_member_id, $batch_id, $is_first_front
    )
    {
        if($task_object->Assignee == $batch_member_id)
        {
            if($task_object->Reporter == $batch_member_id)
            {
                return $this->GetTaskDetails(
                    $task_object, $batch_member_id, true, true, true
                );
            }
            else
            {
                return $this->GetTaskDetails(
                    $task_object, $batch_member_id, true, false, false
                );
            }
        }
        else if($task_object->Reporter == $batch_member_id)
        {
            return $this->GetTaskDetails(
                $task_object, $batch_member_id, false, true, true
            );
        }

        $frontmen = array(
            $this->member->GetMemberTypeID(Member::FIRST_FRONTMAN),
            $this->member->GetMemberTypeID(Member::SECOND_FRONTMAN),
            $this->member->GetMemberTypeID(Member::THIRD_FRONTMAN)
        );
        $assignee_member_type = $this->batch_member->GetMemberTypeID(
            $task_object->Assignee
        );

        if(in_array($assignee_member_type, $frontmen))
        {
            return $this->GetTaskDetails(
                $task_object, $batch_member_id, false, true, true
            );
        }

        $committee_id = $this->committee->GetCommitteeIDByBatchMemberID(
            $task_object->Assignee
        );
        $scoped_committees = (
            $this->committee->GetCommitteePermissionCommitteeIDs(
                $batch_id, $this->batch_member->GetMemberTypeID(
                    $batch_member_id
                )
            )
        );

        if(in_array($committee_id, $scoped_committees))
        {
            return $this->GetTaskDetails(
                $task_object, $batch_member_id, false, true, false
            );
        }
        else
        {
            return $this->GetTaskDetails(
                $task_object, $batch_member_id, false, false, false
            );
        }
    }

    public function GetCommitteeTaskDetailsPageDetails(
        $task_object, $batch_member_id
    )
    {
        if($task_object->Assignee == $batch_member_id)
        {
            if($task_object->Reporter == $batch_member_id)
            {
                return $this->GetTaskDetails(
                    $task_object, $batch_member_id, true, true, true
                );
            }
            else
            {
                return $this->GetTaskDetails(
                    $task_object, $batch_member_id, true, false, false
                );
            }
        }
        else if($task_object->Reporter == $batch_member_id)
        {
            return $this->GetTaskDetails(
                $task_object, $batch_member_id, false, true, true
            );
        }
        else
        {
            return $this->GetTaskDetails(
                $task_object, $batch_member_id, false, false, false
            );
        }
    }

    private function GetTaskDetails(
        $task_object, $batch_member_id, $can_submit, $can_edit, $can_approve
    )
    {
        return array(
            "task" => array(
                "details" => array(
                    "id" => $task_object->TaskID,
                    "title" => $task_object->TaskTitle,
                    "description" => $task_object->TaskDescription,
                    "deadline" => $task_object->TaskDeadline,
                    "assignee" => $this->GetMemberName(
                        $this->batch_member->GetMemberID($task_object->Assignee)
                    ),
                    "reporter" => $this->GetMemberName(
                        $this->batch_member->GetMemberID($task_object->Reporter)
                    ),
                    "status" => array(
                        "id" => $task_object->TaskStatusID,
                        "name" => $this->task->GetTaskStatus(
                            $task_object->TaskStatusID
                        )
                    )
                ),
                "parent" => $this->GetParentTask($task_object->TaskID),
                "children" => $this->GetChildrenTasks($task_object->TaskID),
                "event" => $this->GetEvent($task_object->TaskID),
                "comments" => $this->GetTaskComments($task_object->TaskID),
                "submissions" => $this->GetSubmissions(
                    $task_object->TaskID, ($can_approve || $can_submit)
                ),
                "flags" => array(
                    "submit" => $can_submit,
                    "edit" => $can_edit,
                    "approve" => $can_approve
                )
            )
        );
    }

    private function GetParentTask($task_id)
    {
        if($this->task->HasParentTask($task_id))
        {
            $parent = $this->task->GetTask(
                $this->task->GetParentTaskID($task_id)
            );
            return array(
                "id" => $parent->TaskID,
                "title" => $parent->TaskTitle
            );
        }
        else
        {
            return false;
        }
    }

    private function GetChildrenTasks($task_id)
    {
        $tasks = array();
        foreach($this->task->GetChildrenTaskIDs($task_id) as $task_id)
        {
            $child = $this->task->GetTask($task_id);

            $tasks[] = array(
                "id" => $child->TaskID,
                "title" => $child->TaskTitle,
                "status" => $this->task->GetTaskStatus(
                    $child->TaskStatusID
                ),
                "deadline" => $child->TaskDeadline
            );
        }
        return (sizeof($tasks) > 0) ? $tasks : false;
    }

    private function GetEvent($task_id)
    {
        if($this->task->HasEvent($task_id))
        {
            $event = $this->event->GetEvent(
                $this->task->GetTaskEventByTaskID($task_id)->EventID
            );
            return array(
                "id" => $event->EventID,
                "name" => $event->EventName,
                "url" => Url::GetBaseURL(
                    sprintf("calendar/events/details/%s", $event->EventID)
                )
            );
        }
        else
        {
            return false;
        }
    }

    private function GetTaskComments($task_id)
    {
        $comments = array();
        foreach($this->task->GetTaskCommentsByTaskID($task_id) as $comment)
        {
            $comments[] = array(
                "id" => $comment->TaskCommentID,
                "comment" => $comment->Comment,
                "commentor" => $this->GetMemberName(
                    $this->batch_member->GetMemberID(
                        $this->task->GetTaskSubscriber(
                            $comment->TaskSubscriberID
                        )->BatchMemberID
                    )
                ),
                "timestamp" => $comment->Timestamp
            );
        }
        return Sort::AssociativeArray($comments, "timestamp", Sort::ASCENDING);
    }

    private function GetSubmissions($task_id, $can_see)
    {
        $submissions = array();

        if($can_see)
        {
            foreach($this->task->GetTaskSubmissionsByTaskID($task_id) as $submit)
            {
                if($submit->FilePath != null)
                {
                    $file_path = explode("/", $submit->FilePath);

                    $file_download_url = Url::GetBaseURL(
                        sprintf(
                            "action/task/view/details/%s%s%s",
                            $task_id, "/submission/download/",
                            $submit->TaskSubmissionID
                        ) 
                    );
                    $file_name = $file_path[sizeof($file_path) - 1];
                }
                else
                {
                    $file_download_url = "";
                    $file_name = "";
                }

                $submissions[] = array(
                    "id" => $submit->TaskSubmissionID,
                    "description" => $submit->Description,
                    "file" => array(
                        "url" => $file_download_url,
                        "name" => $file_name
                    ),
                    "timestamp" => $submit->Timestamp
                );
            }
        }

        return $submissions;
    }

    public function AddTaskComment($task_id, $task_comment, $batch_member_id)
    {
        $subscribers = $this->task->GetTaskSubscribersByTaskID($task_id);
        if(!in_array($batch_member_id, $subscribers))
        {
            $task_subscriber = $this->task->AddSubscriber(
                new TaskSubscriberModel(
                    array(
                        "TaskID" => $task_id, 
                        "BatchMemberID" => $batch_member_id
                    )
                )
            );

            foreach($this->task->GetChildrenTaskIDs($task_id) as $child)
            {
                $this->task->AddSubscriber(
                    new TaskSubscriberModel(
                        array(
                            "TaskID" => $child, 
                            "BatchMemberID" => $batch_member_id
                        )
                    )
                );
            }
        }
        else 
        {
            $task_subscriber = $this->task->GetTaskSubscriberID(
                $task_id, $batch_member_id
            );
        }

        return $this->task->AddComment(
            new TaskCommentModel(
                array(
                    "TaskID" => $task_id,
                    "TaskSubscriberID" => $task_subscriber,
                    "Comment" => $task_comment
                )
            )
        );
    }

    public function CanModifyTask(
        $task_id, $batch_member_id, $batch_id, $is_first_front
    )
    {
        $task_object = $this->task->GetTask($task_id);

        if($task_object->Assignee == $batch_member_id)
        {
            return true;
        }
        else if($task_object->Reporter == $batch_member_id)
        {
            return true;
        }

        $frontmen = array(
            $this->member->GetMemberTypeID(Member::FIRST_FRONTMAN),
            $this->member->GetMemberTypeID(Member::SECOND_FRONTMAN),
            $this->member->GetMemberTypeID(Member::THIRD_FRONTMAN)
        );
        $assignee_member_type = $this->batch_member->GetMemberTypeID(
            $task_object->Assignee
        );

        if(in_array($assignee_member_type, $frontmen))
        {
            return true;
        }

        $committee_id = $this->committee->GetCommitteeIDByBatchMemberID(
            $task_object->Assignee
        );
        $scoped_committees = (
            $this->committee->GetCommitteePermissionCommitteeIDs(
                $batch_id, $this->batch_member->GetMemberTypeID(
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
    
    public function IsSubmissionFromTask($task_id, $task_submission_id)
    {
        return $this->task->IsSubmissionFromTask($task_id, $task_submission_id);
    }

    public function CanDownloadSubmission(
        $task_id, $batch_member_id, $batch_id, $is_first_front
    )
    {
        return $this->CanModifyTask(
            $task_id, $batch_member_id, $batch_id, $is_first_front
        );
    }

    public function DeleteTask($task_id)
    {
        foreach($this->task->GetChildrenTaskIDs($task_id) as $child)
        {
            $this->task->DeleteTask($child);
        }
        
        return $this->task->DeleteTask($task_id);
    }

    public function CanSubmitTask($task_object, $batch_member_id)
    {
        return ($task_object->Assignee == $batch_member_id);
    }

    public function CanApproveTask(
        $task_id, $batch_member_id, $batch_id, $is_first_front
    )
    {
        return $this->CanModifyTask(
            $task_id, $batch_member_id, $batch_id, $is_first_front
        );
    }

    public function CanUpload($status_id)
    {
        switch($this->task->GetTaskStatus($status_id))
        {
            case Task::IN_PROGRESS:
            case Task::NEEDS_CHANGES:
                return true;
            default:
                return false;
        }
    }

    public function SubmitTask(
        $task_id, $status_id, $upload, $file_index, $submit_text
    )
    {
        switch($this->task->GetTaskStatus($status_id))
        {
            case Task::TODO:
                return $this->ProcessToDoTask($task_id);
            case Task::IN_PROGRESS:
            case Task::NEEDS_CHANGES:
                return $this->ProcessInProgressTask(
                    $upload, $file_index, $submit_text, $task_id
                );
            case Task::FOR_REVIEW:
                return $this->ProcessForReviewTask($task_id);
            case Task::ACCEPTED:
                return $this->ProcessAcceptedTask($task_id);
            default:
                break;
        }
    }

    public function ApproveTask($task_id, $is_approved)
    {
        if($is_approved)
        {
            $this->task->UpdateTask(
                $task_id, new TaskModel(
                    array(
                        "TaskStatusID" => $this->task->GetTaskStatusID(
                            Task::ACCEPTED
                        )
                    )
                )
            );
        }
        else
        {
            $this->task->UpdateTask(
                $task_id, new TaskModel(
                    array(
                        "TaskStatusID" => $this->task->GetTaskStatusID(
                            Task::NEEDS_CHANGES
                        )
                    )
                )
            );
        }

        return $this->task->GetTask($task_id);
    }

    private function ProcessToDoTask($task_id)
    {
        if($this->task->HasParentTask($task_id))
        {
            $parent_task = $this->task->GetTask(
                $this->task->GetParentTaskID($task_id)
            );
            $parent_task_status = $this->task->GetTaskStatus(
                $parent_task->TaskStatusID
            );

            if($parent_task_status == Task::TODO)
            {
                $this->task->UpdateTask(
                    $parent_task->TaskID, new TaskModel(
                        array(
                            "TaskStatusID" => $this->task->GetTaskStatusID(
                                Task::IN_PROGRESS
                            )
                        )
                    )
                );
            }
        }

        $this->task->UpdateTask(
            $task_id, new TaskModel(
                array(
                    "TaskStatusID" => $this->task->GetTaskStatusID(
                        Task::IN_PROGRESS
                    )
                )
            )
        );

        return $this->task->GetTask($task_id);
    }

    private function ProcessInProgressTask(
        $upload, $file_index, $submit_text, $task_id
    )
    {
        $task_submission = array(
            "TaskID" => $task_id,
            "Description" => $submit_text
        );

        if($upload !== null)
        {
            $task_submission["FilePath"] = $upload->GetUploadPath($file_index);
        }

        $this->task->AddSubmission(
            new TaskSubmissionModel($task_submission)
        );

        $this->task->UpdateTask(
            $task_id, 
            new TaskModel(
                array(
                    "TaskStatusID" => (
                        $this->task->GetTaskStatusID(Task::FOR_REVIEW)
                    )
                )
            )
        );

        return $this->task->GetTask($task_id);
    }

    private function ProcessForReviewTask($task_id)
    {
        $this->task->UpdateTask(
            $task_id, new TaskModel(
                array(
                    "TaskStatusID" => $this->task->GetTaskStatusID(
                        Task::IN_PROGRESS
                    )
                )
            )
        );
        
        return $this->task->GetTask($task_id);
    }

    private function ProcessAcceptedTask($task_id)
    {
        $this->task->UpdateTask(
            $task_id, new TaskModel(
                array(
                    "TaskStatusID" => $this->task->GetTaskStatusID(Task::DONE)
                )
            )
        );

        if($this->task->HasParentTask($task_id))
        {
            $parent_task = $this->task->GetTask(
                $this->task->GetParentTaskID($task_id)
            );

            $all_done = true;
            $done_id = $this->task->GetTaskStatusID(Task::DONE);
            foreach(
                $this->task->GetChildrenTaskIDs($parent_task->TaskID) 
                as $child_id
            ) 
            {
                $child = $this->task->GetTask($child_id);
                if($child->TaskStatusID != $done_id)
                {
                    $all_done = false;
                    break;
                }
            }

            $parent_task_status = $this->task->GetTaskStatus(
                $parent_task->TaskStatusID
            );
            if($all_done && $parent_task_status != Task::DONE)
            {
                $this->task->UpdateTask(
                    $parent_task->TaskID, new TaskModel(
                        array(
                            "TaskStatusID" => $this->task->GetTaskStatusID(
                                Task::DONE
                            )
                        )
                    )
                );
            }
        }

        return $this->task->GetTask($task_id);
    }

    public function DownloadSubmission($task_submission_id)
    {
        $submission = $this->task->GetTaskSubmission($task_submission_id);

        force_download($submission->FilePath, NULL);

        exit();
    }

    public function GetFrontmanEditTaskPageDetails(
        $batch_id, $frontman_id, $is_first_frontman, $task_id
    )
    {
        $add_details = $this->GetFrontmanAddTaskPageDetails(
            $batch_id, $frontman_id, $is_first_frontman
        );

        $add_details['details'] = $this->GetEditTaskDetails($task_id);

        return $add_details;
    }

    public function GetCommitteeHeadEditTaskPageDetails(
        $batch_id, $committee_id, $committee_head_id, $task_id
    )
    {
        $add_details = $this->GetCommitteeHeadAddTaskPageDetails(
            $batch_id, $committee_id, $committee_head_id
        );

        $add_details['details'] = $this->GetEditTaskDetails($task_id);

        return $add_details;
    }

    public function GetCommitteeMemberEditTaskPageDetails(
        $batch_id, $committee_member_id, $task_id
    )
    {
        $add_details = $this->GetCommitteeMemberAddTaskPageDetails(
            $batch_id, $committee_member_id
        );

        $add_details['details'] = $this->GetEditTaskDetails($task_id);

        return $add_details;
    }

    private function GetEditTaskDetails($task_id)
    {
        $task_object = $this->task->GetTask($task_id);

        return array(
            "id" => $task_object->TaskID,
            "title" => $task_object->TaskTitle,
            "description" => $task_object->TaskDescription,
            "deadline" => $task_object->TaskDeadline,
            "assignee" => array(
                "id" => $task_object->Assignee,
                "name" => $this->GetMemberName(
                    $this->batch_member->GetMemberID($task_object->Assignee)
                )
            ),
            "reporter" => array(
                "id" => $task_object->Reporter,
                "name" => $this->GetMemberName(
                    $this->batch_member->GetMemberID($task_object->Reporter)
                )
            ),
            "event" => $this->GetEvent($task_object->TaskID),
            "parent" => $this->GetParentTask($task_object->TaskID),
            "children" => $this->GetChildrenTasks($task_object->TaskID),
            "subscribers" => $this->task->GetTaskSubscribersByTaskID($task_id)
        );
    }

    public function EditTask(
        $task_id, $title, $description, $deadline, $subscribers, $parent, $event
    )
    {
        $this->task->UpdateTask(
            $task_id, new TaskModel(
                array(
                    "TaskTitle" => $title,
                    "TaskDescription" => $description,
                    "TaskDeadline" => $deadline
                )
            )
        );

        if($this->task->HasParentTask($task_id))
        {
            $this->task->DeleteTaskTreeByChildID($task_id);
        }

        if($parent !== null)
        {
            $parent_task = $this->task->GetTask($parent);

            $parent_subscribers = (
                $this->task->GetTaskSubscribersByTaskID($parent_task->TaskID)
            );
            foreach($parent_subscribers as $parent_subscriber_id)
            {
                if(!in_array($parent_subscriber_id, $subscribers))
                {
                    $subscribers[] = $parent_subscriber_id;
                }
            }

            $this->task->AddParentTask(
                new TaskTreeModel(
                    array(
                        "ChildTaskID" => $task_id,
                        "ParentTaskID" => $parent
                    )
                )
            );
        }

        if($this->task->HasEvent($task_id))
        {
            $this->task->DeleteEventByTaskID($task_id);
        }

        if($event !== null)
        {
            $this->task->AddTaskEvent(
                new TaskEventModel(
                    array(
                        "TaskID" => $task_id,
                        "EventID" => $event
                    )
                )
            );
        }

        $old_subscribers = $this->task->GetTaskSubscribersByTaskID($task_id);

        foreach($subscribers as $subscriber)
        {
            if(!in_array($subscriber, $old_subscribers))
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
        }

        foreach($old_subscribers as $old_subscriber)
        {
            if(!in_array($old_subscriber, $subscribers))
            {
                $this->task->DeleteSubscriber(
                    $this->task->GetTaskSubscriberID(
                        $task_id, $old_subscriber
                    )
                );
            }
        }

        return true;
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

        $batch_member_ids = array_intersect(
            $batch_member_ids,
            $this->batch_member->GetBatchMemberIDs($batch_id)
        );

        $members = array();
        $tasks = array();

        foreach($batch_member_ids as $batch_member_id)
        {
            $member_name = $this->GetMemberName(
                $this->batch_member->GetMemberID($batch_member_id)
            );
            $members[] = array(
                "id" => $batch_member_id,
                "name" => $member_name
            );

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

        $batch_members = $this->batch_member->GetBatchMemberIDs($batch_id);
        foreach($batch_members as $batch_member_id)
        {
             foreach($this->event->GetEvents($batch_member_id) as $event)
            {
                $events[] = array(
                    "id" => $event->EventID,
                    "name" => $event->EventName
                );
            }
        }

        return array(
            "events" => Sort::AssociativeArray($events, "id", Sort::DESCENDING),
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
        $batch_id, $committee_id, $committee_head_id
    )
    {
        $batch_member_ids = (
            $this->committee->GetApprovedBatchMemberIDs($committee_id)
        );

        $batch_member_ids = array_intersect(
            $batch_member_ids,
            $this->batch_member->GetBatchMemberIDs($batch_id)
        );

        $members = array();
        $tasks = array();

        foreach($batch_member_ids as $batch_member_id)
        {
            $member_name = $this->GetMemberName(
                $this->batch_member->GetMemberID($batch_member_id)
            );
            $members[] = array(
                "id" => $batch_member_id,
                "name" => $member_name
            );

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

        $batch_members = $this->batch_member->GetBatchMemberIDs($batch_id);
        foreach($batch_members as $batch_member_id)
        {
             foreach($this->event->GetEvents($batch_member_id) as $event)
            {
                $events[] = array(
                    "id" => $event->EventID,
                    "name" => $event->EventName
                );
            }
        }

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

    public function GetCommitteeMemberAddTaskPageDetails(
        $batch_id, $committee_member_id
    )
    {
        $members = array(
            array(
                "id" => $committee_member_id,
                "name" => $this->GetMemberName(
                    $this->batch_member->GetMemberID($committee_member_id)
                )
            )
        );

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


        $events = array();

        $batch_members = $this->batch_member->GetBatchMemberIDs($batch_id);
        foreach($batch_members as $batch_member_id)
        {
             foreach($this->event->GetEvents($batch_member_id) as $event)
            {
                $events[] = array(
                    "id" => $event->EventID,
                    "name" => $event->EventName
                );
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
        if(array_key_exists("task-assignee", $input_data))
        {
            $validation->CheckInteger(
                "task-assignee", $input_data["task-assignee"]
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

    public function IsTaskDeadlineValid($deadline)
    {
        return (
            \DateTime::createFromFormat("Y-m-d", $deadline) >= new \DateTime()
        );
    }

    public function IsEventStartDateValid($date)
    {
       return (
            \DateTime::createFromFormat("Y-m-d", $date) >= new \DateTime()
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
        if($task_id != null)
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
        $task_status = $this->task->GetTaskStatus($task->TaskStatusID);
        return (
            !$this->task->HasParentTask($task->TaskID) &&
            $this->IsTaskDeadlineValid($task->TaskDeadline) &&
            (
                $task_status == Task::TODO ||
                $task_status == Task::IN_PROGRESS
            )
        );
    }

    public function AddTask(
        $title, $description, $deadline, $reporter, $assignee, $subscribers,
        $parent, $event
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
            $parent_task = $this->task->GetTask($parent);

            $parent_subscribers = (
                $this->task->GetTaskSubscribersByTaskID($parent_task->TaskID)
            );
            foreach($parent_subscribers as $parent_subscriber_id)
            {
                if(!in_array($parent_subscriber_id, $subscribers))
                {
                    $subscribers[] = $parent_subscriber_id;
                }
            }

            $this->task->AddParentTask(
                new TaskTreeModel(
                    array(
                        "ChildTaskID" => $task_id,
                        "ParentTaskID" => $parent
                    )
                )
            );
        }

        if($event !== null)
        {
            $this->task->AddTaskEvent(
                new TaskEventModel(
                    array(
                        "TaskID" => $task_id,
                        "EventID" => $event
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

        return $task_id;
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

    private function MutateTaskDetails($task)
    {
        return array(
            "id" => $task->TaskID,
            "title" => $task->TaskTitle,
            "description" => $task->TaskDescription,
            "deadline" => $task->TaskDeadline,
            "reporter" => $this->GetMemberName(
                $this->batch_member->GetMemberID($task->Reporter)
            ),
            "assignee" => $this->GetMemberName(
                $this->batch_member->GetMemberID($task->Assignee)
            ),
            "status" => $this->task->GetTaskStatus(
                $task->TaskStatusID
            )
        );
    }
}
