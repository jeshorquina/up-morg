<?php
namespace Jesh\Operations\Repository;

use \Jesh\Helpers\StringHelper;

use \Jesh\Models\TaskModel;
use \Jesh\Models\TaskCommentModel;
use \Jesh\Models\TaskSubmissionModel;
use \Jesh\Models\TaskSubscriberModel;
use \Jesh\Models\TaskTreeModel;

use \Jesh\Repository\TaskRepository;

class Task
{
    const TODO = "To Do";
    const IN_PROGRESS = "In Progress";
    const FOR_REVIEW = "For Review";
    const NEEDS_CHANGES = "Needs Changes";
    const ACCEPTED = "Accepted";
    const DONE = "Done";

    private $repository;

    public function __construct()
    {
        $this->repository = new TaskRepository;
    }

    public function GetTask($task_id)
    {
        $task = $this->repository->GetTask($task_id);

        if(!$task)
        {
            throw new \Exception(
                sprintf(
                    "Cannot find task with id = [%s] in the database",
                    $task_id
                )
            );
        }

        return new TaskModel($task[0]);
    }

    public function GetAssignedTasks($batch_member_id)
    {
        $tasks = array();
        foreach($this->repository->GetAssignedTasks($batch_member_id) as $task)
        {
            $tasks[] = new TaskModel($task);
        }
        return $tasks;
    }

    public function GetReportedTasks($batch_member_id)
    {
        $tasks = array();
        foreach($this->repository->GetReportedTasks($batch_member_id) as $task)
        {
            $tasks[] = new TaskModel($task);
        }
        return $tasks;
    }

    public function GetSubscribedTaskIDs($batch_member_id)
    {
        $tasks = array();
        foreach($this->repository->GetSubscribedTasks($batch_member_id) as $task)
        {
            $tasks[] = new TaskModel($this->GetTask($task["TaskID"]));
        }
        return $tasks;
    }

    public function GetParentTaskID($task_id)
    {
        $task = $this->repository->GetParentTask($task_id);

        if(!$task)
        {
            throw new \Exception("Cannot find parent task in the database");
        }

        return $task[0]["ParentTaskID"];
    }

    public function GetChildrenTaskIDs($task_id)
    {
        $ids = array();
        foreach($this->repository->GetChildrenTaskIDs($task_id) as $task)
        {
            $ids[] = $task["ChildTaskID"];
        }
        return $ids;
    }

    public function GetTaskCommentsByTaskID($task_id)
    {
        $comments = array();
        foreach(
            $this->repository->GetTaskCommentsByTaskID($task_id) as $comment
        )
        {
            $comments[] = new TaskCommentModel($comment);
        }
        return $comments;
    }

    public function GetTaskSubscriber($task_subscriber_id)
    {
        $task_subscriber = $this->repository->GetTaskSubscriber(
            $task_subscriber_id
        );

        if(!$task_subscriber)
        {
            throw new \Exception("Cannot find task subscriber in the database");
        }

        return new TaskSubscriberModel($task_subscriber[0]);
    }

    public function GetTaskSubscriberID($task_id, $batch_member_id)
    {
        $task_subscriber = $this->repository->GetTaskSubscriberID(
            $task_id, $batch_member_id
        );

        if(!$task_subscriber)
        {
            throw new \Exception(
                sprintf(
                    StringHelper::NoBreakString(
                        "Cannot find task subscriber with task id = %s and 
                        batch member id = %s in the database"
                    ), $task_id, $batch_member_id
                )
            );
        }

        return $task_subscriber[0]["TaskSubscriberID"];
    }

    public function GetTaskSubscribersByTaskID($task_id)
    {
        $subscribers = array();

        $db_subs = $this->repository->GetTaskSubscribersByTaskID($task_id);
        foreach($db_subs as $subscriber)
        {
            $subscribers[] = $subscriber["BatchMemberID"];
        }
        return $subscribers;
    }

    public function GetTaskStatusID($name)
    {
        $is_found = $this->repository->GetTaskStatusID($name);
    
        if(!$is_found)
        {
            throw new \Exception(
                sprintf(
                    "Cannot find task status `%s` in the database.",$name
                )
            );
        }

        return $is_found[0]["TaskStatusID"];
    }

    public function GetTaskStatus($task_status_id)
    {
        $is_found = $this->repository->GetTaskStatus($task_status_id);
    
        if(!$is_found)
        {
            throw new \Exception(
                sprintf(
                    "Cannot find task status with id = `%s` in the database.",
                    $task_status_id
                )
            );
        }

        return $is_found[0]["Name"];
    }

    public function GetTaskSubmission($task_submission_id)
    {
        $is_found = $this->repository->GetTaskSubmission($task_submission_id);
    
        if(!$is_found)
        {
            throw new \Exception(
                sprintf(
                    "Cannot find task submission with id = `%s`.",
                    $task_submission_id
                )
            );
        }

        return new TaskSubmissionModel($is_found[0]);
    }

    public function GetTaskSubmissionsByTaskID($task_id)
    {
        $submissions = array();

        $db_subs = $this->repository->GetTaskSubmissionsByTaskID($task_id);
        foreach($db_subs as $submission)
        {
            $submissions[] = new TaskSubmissionModel($submission);
        }
        return $submissions;
    }

    public function HasTask($task_id)
    {
        return ($this->repository->GetTask($task_id)) ? true : false;
    }

    public function HasParentTask($task_id)
    {
        return $this->repository->HasParentTask($task_id);
    }

    public function IsTaskSubscriber($task_id, $batch_member_id)
    {
        return $this->repository->IsTaskSubscriber($task_id, $batch_member_id);
    }

    public function IsSubmissionFromTask($task_id, $task_submission_id)
    {
        return $this->repository->IsSubmissionFromTask(
            $task_id, $task_submission_id
        );
    }

    public function AddTask(TaskModel $task)
    {
        $is_added = $this->repository->AddTask($task);

        if(!$is_added)
        {
            throw new \Exception("Cannot add task to the database.");
        }

        return $is_added;
    }

    public function AddSubscriber(TaskSubscriberModel $subscriber)
    {
        $is_added = $this->repository->AddSubscriber($subscriber);

        if(!$is_added)
        {
            throw new \Exception(
                "Cannot add task subscriber to the database."
            );
        }

        return $is_added;
    }

    public function AddParentTask(TaskTreeModel $relation)
    {
        $is_added = $this->repository->AddParentTask($relation);

        if(!$is_added)
        {
            throw new \Exception(
                "Cannot add task relationship to the database."
            );
        }

        return $is_added;
    }

    public function AddComment(TaskCommentModel $comment)
    {
        $is_added = $this->repository->AddComment($comment);

        if(!$is_added)
        {
            throw new \Exception(
                "Cannot add task comment to the database."
            );
        }

        return $is_added;
    }

    public function AddSubmission(TaskSubmissionModel $submission)
    {
        $is_added = $this->repository->AddSubmission($submission);

        if(!$is_added)
        {
            throw new \Exception(
                "Cannot add task submission to the database."
            );
        }

        return $is_added;
    }

    public function UpdateTask($task_id, TaskModel $task)
    {
        $is_updated = $this->repository->UpdateTask($task_id, $task);

        if(!$is_updated)
        {
            throw new \Exception(
                "Cannot update task from the database."
            );
        }

        return $is_updated;
    }

    public function DeleteTask($task_id)
    {
        $is_deleted = $this->repository->DeleteTask($task_id);

        if(!$is_deleted)
        {
            throw new \Exception(
                "Cannot delete task from the database."
            );
        }

        return $is_deleted;
    }

    public function DeleteTaskTreeByChildID($task_id)
    {
        $is_deleted = $this->repository->DeleteTaskTreeByChildID($task_id);

        if(!$is_deleted)
        {
            throw new \Exception(
                "Cannot delete task tree from the database."
            );
        }

        return $is_deleted;
    }

    public function DeleteSubscriber($task_subscriber_id)
    {
        $is_deleted = $this->repository->DeleteSubscriber($task_subscriber_id);

        if(!$is_deleted)
        {
            throw new \Exception(
                "Cannot delete task subscriber from the database."
            );
        }

        return $is_deleted;
    }
}
