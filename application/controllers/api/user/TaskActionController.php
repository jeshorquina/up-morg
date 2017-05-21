<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Http;
use \Jesh\Helpers\StringHelper;
use \Jesh\Helpers\Upload;
use \Jesh\Helpers\Url;
use \Jesh\Helpers\UserSession;

use \Jesh\Operations\User\TaskActionOperations;

class TaskActionController extends Controller 
{
    private $operations;

    public function __construct()
    {
        parent::__construct();

        $this->operations = new TaskActionOperations;
    }

    public function GetViewTaskPageDetails()
    {
        if(!UserSession::IsCommitteeMember() && !UserSession::IsFrontman())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }

        $details = array();
        if(UserSession::IsFrontman())
        {
            $details = $this->operations->GetFrontmanViewTaskPageDetails(
                UserSession::GetBatchMemberID(), UserSession::GetBatchID()
            );
        }
        else if(UserSession::IsCommitteeHead())
        {
            $details = $this->operations->GetCommitteeHeadViewTaskPageDetails(
                UserSession::GetBatchID(), UserSession::GetBatchMemberID(), 
                UserSession::GetCommitteeID()
            );
        }
        else 
        {
            $details = $this->operations->GetCommitteeMemberViewTaskPageDetails(
                UserSession::GetBatchMemberID()
            );
        }

        Http::Response(
            Http::OK, array(
                "message" => StringHelper::NoBreakString(
                    "Task page details successfully processed."
                ),
                "data" => $details
            )
        );
    }

    public function GetViewTaskDetailsPageDetails($task_id)
    {
        if(!UserSession::IsCommitteeMember() && !UserSession::IsFrontman())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }

        $batch_member_id = UserSession::GetBatchMemberID();

        if(!$this->operations->HasTask($task_id))
        {
            Http::Response(
                Http::NOT_FOUND, array(
                    "message" => StringHelper::NoBreakString(
                        "The task was not found in the database!"
                    )
                )
            );
        }
        else if(!$task = $this->operations->HasTaskAccess(
            $task_id, $batch_member_id
        ))
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this particular task!"
                    )
                )
            );
        }

        $details = array();
        if(UserSession::IsFrontman())
        {
            $details = $this->operations->GetFrontmanTaskDetailsPageDetails(
                $task, $batch_member_id, UserSession::GetBatchID(),
                UserSession::IsFirstFrontman()
            );
        }
        else 
        {
            $details = (
                $this->operations->GetCommitteeTaskDetailsPageDetails(
                    $task, $batch_member_id
                )
            );
        }

        Http::Response(
            Http::OK, array(
                "message" => StringHelper::NoBreakString(
                    "Task details page details successfully processed."
                ),
                "data" => $details
            )
        );
    }

    public function AddTaskComment($task_id)
    {
        if(!UserSession::IsCommitteeMember() && !UserSession::IsFrontman())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }

        $batch_member_id = UserSession::GetBatchMemberID();

        if(!$this->operations->HasTask($task_id))
        {
            Http::Response(
                Http::NOT_FOUND, array(
                    "message" => StringHelper::NoBreakString(
                        "The task was not found in the database!"
                    )
                )
            );
        }
        else if(!$task = $this->operations->HasTaskAccess(
            $task_id, $batch_member_id
        ))
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this particular task!"
                    )
                )
            );
        }

        $task_comment = Http::Request(Http::POST, "task-comment");

        if(!$this->operations->AddTaskComment(
            $task_id, $task_comment, $batch_member_id
        ))
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Something went wrong. Task comment not added. Please
                        Try again."
                    )
                )
            );
        }

        $details = array();
        if(UserSession::IsFrontman())
        {
            $details = $this->operations->GetFrontmanTaskDetailsPageDetails(
                $task, $batch_member_id, UserSession::GetBatchID(),
                UserSession::IsFirstFrontman()
            );
        }
        else 
        {
            $details = (
                $this->operations->GetCommitteeTaskDetailsPageDetails(
                    $task, $batch_member_id
                )
            );
        }

        Http::Response(
            Http::CREATED, array(
                "message" => StringHelper::NoBreakString(
                    "Task comment successfully added."
                ),
                "data" => $details
            )
        );
    }

    public function DeleteTask($task_id)
    {
        if(!UserSession::IsCommitteeMember() && !UserSession::IsFrontman())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }

        $batch_member_id = UserSession::GetBatchMemberID();

        if(!$this->operations->HasTask($task_id))
        {
            Http::Response(
                Http::NOT_FOUND, array(
                    "message" => StringHelper::NoBreakString(
                        "The task was not found in the database!"
                    )
                )
            );
        }
        else if(!$this->operations->HasTaskAccess($task_id, $batch_member_id))
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this particular task!"
                    )
                )
            );
        }
        else if(!$this->operations->CanModifyTask(
            $task_id, $batch_member_id, UserSession::GetBatchID(),
            UserSession::IsFirstFrontman()
        ))
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have delete access for this task!"
                    )
                )
            );
        }

        if(!$this->operations->DeleteTask($task_id))
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "SOmething went wrong. Cannot delete task. 
                        Please try again."
                    )
                )
            );
        }
        else
        {
            Http::Response(
                Http::OK, array(
                    "message" => "Successfully deleted task!",
                    "redirect_url" => Url::GetBaseURL("task/view")
                )
            );
        }
    }

    public function SubmitTask($task_id)
    {
        if(!UserSession::IsCommitteeMember() && !UserSession::IsFrontman())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }

        $batch_member_id = UserSession::GetBatchMemberID();

        if(!$this->operations->HasTask($task_id))
        {
            Http::Response(
                Http::NOT_FOUND, array(
                    "message" => StringHelper::NoBreakString(
                        "The task was not found in the database!"
                    )
                )
            );
        }
        else if(!$task = $this->operations->HasTaskAccess(
            $task_id, $batch_member_id
        ))
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this particular task!"
                    )
                )
            );
        }
        else if(!$this->operations->CanSubmitTask($task, $batch_member_id))
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have submit access for this task!"
                    )
                )
            );
        }

        $status_id = Http::Request(Http::POST, "task-status");
        $submit_text = Http::Request(Http::POST, "task-submission-text");

        $upload = new Upload(
            Upload::UPLOAD_DIRECTORY_INTERNAL, 
            Upload::UPLOAD_TYPE_SUMBISSIONS
        );
        if($this->operations->CanUpload($status_id))
        {
            if(!$upload->UploadFile("task-submission-file"))
            {
                $upload = null;
            }

            if($submit_text == null || $submit_text == "")
            {
                Http::Response(
                    Http::UNPROCESSABLE_ENTITY, array(
                        "message" => StringHelper::NoBreakString(
                            "Please provide a description for the submission."
                        )
                    )
                );
            }
        }
        else
        {
            $upload = null;
        }

        if(!$task = $this->operations->SubmitTask(
            $task_id, $status_id, $upload, "task-submission-file", $submit_text
        ))
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Something went wrong. Cannot submit task. 
                        Please try again."
                    )
                )
            );
        }

        $details = array();
        if(UserSession::IsFrontman())
        {
            $details = $this->operations->GetFrontmanTaskDetailsPageDetails(
                $task, $batch_member_id, UserSession::GetBatchID(),
                UserSession::IsFirstFrontman()
            );
        }
        else 
        {
            $details = (
                $this->operations->GetCommitteeTaskDetailsPageDetails(
                    $task, $batch_member_id
                )
            );
        }

        Http::Response(
            Http::CREATED, array(
                "message" => StringHelper::NoBreakString(
                    "Successfully changed task status."
                ),
                "data" => $details
            )
        );
    }

    public function DownloadSubmission($task_id, $task_submission_id)
    {
        if(!UserSession::IsCommitteeMember() && !UserSession::IsFrontman())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }

        $batch_member_id = UserSession::GetBatchMemberID();

        if(!$this->operations->HasTask($task_id))
        {
            Http::Response(
                Http::NOT_FOUND, array(
                    "message" => StringHelper::NoBreakString(
                        "The task was not found in the database!"
                    )
                )
            );
        }
        else if(!$task = $this->operations->HasTaskAccess(
            $task_id, $batch_member_id
        ))
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this particular task!"
                    )
                )
            );
        }
        else if(!$this->operations->IsSubmissionFromTask(
            $task_id, $task_submission_id
        ))
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "Submission is invalid!"
                    )
                )
            );
        }
        else if(!$this->operations->CanDownloadSubmission(
            $task_id, $batch_member_id, UserSession::GetBatchID(),
            UserSession::IsFirstFrontman()
        ))
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You cannot download this particular!"
                    )
                )
            );
        }

        $this->operations->DownloadSubmission($task_submission_id);
    }

    public function ApproveTask($task_id)
    {
        if(!UserSession::IsCommitteeMember() && !UserSession::IsFrontman())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }

        $batch_member_id = UserSession::GetBatchMemberID();

        if(!$this->operations->HasTask($task_id))
        {
            Http::Response(
                Http::NOT_FOUND, array(
                    "message" => StringHelper::NoBreakString(
                        "The task was not found in the database!"
                    )
                )
            );
        }
        else if(!$task = $this->operations->HasTaskAccess(
            $task_id, $batch_member_id
        ))
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this particular task!"
                    )
                )
            );
        }
        else if(!$this->operations->CanApproveTask(
            $task_id, $batch_member_id, UserSession::GetBatchID(),
            UserSession::IsFirstFrontman()
        ))
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have submit access for this task!"
                    )
                )
            );
        }

        $action = Http::Request(Http::POST, "action");
        $is_approved = ($action == "approve") ? true : false;

        if(!$task = $this->operations->ApproveTask($task_id, $is_approved))
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Something went wrong. Cannot approve/disapprove 
                        task. Please try again."
                    )
                )
            );
        }

        $details = array();
        if(UserSession::IsFrontman())
        {
            $details = $this->operations->GetFrontmanTaskDetailsPageDetails(
                $task, $batch_member_id, UserSession::GetBatchID(),
                UserSession::IsFirstFrontman()
            );
        }
        else 
        {
            $details = (
                $this->operations->GetCommitteeTaskDetailsPageDetails(
                    $task, $batch_member_id
                )
            );
        }

        Http::Response(
            Http::CREATED, array(
                "message" => StringHelper::NoBreakString(
                    "Successfully changed task status."
                ),
                "data" => $details
            )
        );
    }

    public function EditTaskDetails($task_id)
    {
        if(!UserSession::IsCommitteeMember() && !UserSession::IsFrontman())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }

        $batch_member_id = UserSession::GetBatchMemberID();

        if(!$this->operations->HasTask($task_id))
        {
            Http::Response(
                Http::NOT_FOUND, array(
                    "message" => StringHelper::NoBreakString(
                        "The task was not found in the database!"
                    )
                )
            );
        }
        else if(!$task = $this->operations->HasTaskAccess(
            $task_id, $batch_member_id
        ))
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this particular task!"
                    )
                )
            );
        }
        else if(!$this->operations->CanModifyTask(
            $task_id, $batch_member_id, UserSession::GetBatchID(),
            UserSession::IsFirstFrontman()
        ))
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have submit access for this task!"
                    )
                )
            );
        }

        $details = array();
        if(UserSession::IsFrontman())
        {
            $details = $this->operations->GetFrontmanEditTaskPageDetails(
                UserSession::GetBatchID(), UserSession::GetBatchMemberID(),
                UserSession::IsFirstFrontman(), $task_id
            );
        }
        else if(UserSession::IsCommitteeHead())
        {
            $details = $this->operations->GetCommitteeHeadEditTaskPageDetails(
                UserSession::GetBatchID(), UserSession::GetCommitteeID(), 
                UserSession::GetBatchMemberID(), $task_id
            );
        }
        else 
        {
            $details = $this->operations->GetCommitteeMemberEditTaskPageDetails(
                UserSession::GetBatchID(), UserSession::GetBatchMemberID(), 
                $task_id
            );
        }

        Http::Response(
            Http::OK, array(
                "message" => StringHelper::NoBreakString(
                    "Edit task page details successfully processed."
                ),
                "data" => $details
            )
        );
    }

    public function EditTask($task_id)
    {
        if(!UserSession::IsCommitteeMember() && !UserSession::IsFrontman())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }

        $batch_member_id = UserSession::GetBatchMemberID();

        if(!$this->operations->HasTask($task_id))
        {
            Http::Response(
                Http::NOT_FOUND, array(
                    "message" => StringHelper::NoBreakString(
                        "The task was not found in the database!"
                    )
                )
            );
        }
        else if(!$task = $this->operations->HasTaskAccess(
            $task_id, $batch_member_id
        ))
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this particular task!"
                    )
                )
            );
        }
        else if(!$this->operations->CanModifyTask(
            $task_id, $batch_member_id, UserSession::GetBatchID(),
            UserSession::IsFirstFrontman()
        ))
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have submit access for this task!"
                    )
                )
            );
        }

        $reporter = UserSession::GetBatchMemberID();

        $title = Http::Request(Http::POST, "task-title");
        $description = Http::Request(Http::POST, "task-description");
        $deadline = Http::Request(Http::POST, "task-deadline");
        $subscribers = json_decode(
            Http::Request(Http::POST, "task-subscribers"), true
        );

        $validation = $this->operations->ValidateAddTaskData(
            array(
                "task-title"       => $title,
                "task-description" => $description,
                "task-deadline"    => $deadline,
                "task-subscribers" => $subscribers,
            )
        );
        if($validation["status"] === false)
        {
            Http::Response(Http::UNPROCESSABLE_ENTITY, $validation["message"]);
        }
        else if(!$this->operations->IsTaskDeadlineValid($deadline))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Task deadline cannot be in the past!"
                    )
                )
            );
        }

        $details = array();
        if(UserSession::IsFrontman())
        {
            $details = $this->operations->GetFrontmanEditTaskPageDetails(
                UserSession::GetBatchID(), UserSession::GetBatchMemberID(),
                UserSession::IsFirstFrontman(), $task_id
            );
        }
        else if(UserSession::IsCommitteeHead())
        {
            $details = $this->operations->GetCommitteeHeadEditTaskPageDetails(
                UserSession::GetBatchID(), UserSession::GetCommitteeID(), 
                UserSession::GetBatchMemberID(), $task_id
            );
        }
        else 
        {
            $details = $this->operations->GetCommitteeMemberEditTaskPageDetails(
                UserSession::GetBatchID(), UserSession::GetBatchMemberID(), 
                $task_id
            );
        }

        $assignee = $details["details"]["assignee"]["id"];

        if(!$this->operations->IsAssigneeSubordinate($assignee, $details))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Assignee is a non-subordinate! Assignee should be a 
                        subordinate."
                    )
                )
            );
        }
        else if(!$this->operations->IsSubscriberArrayValid(
            $subscribers, $assignee, $reporter
        ))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Subscriber list is malformed!"
                    )
                )
            );
        }
        else if(!$this->operations->AreSubscribersSubordinates(
            $subscribers, $details
        ))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Subscriber list contain non-subordinates!"
                    )
                )
            );
        }

        $parent = Http::Request(Http::POST, "task-parent");
        $parent = ((int)$parent <= -1) ? null : $parent;

        $event = Http::Request(Http::POST, "task-event");
        $event = ((int)$event <= -1) ? null : $event;

        if(!$this->operations->CheckParentTaskValidByID($parent))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Parent task is not a valid task for a parent!"
                    )
                )
            );
        }
        else if(!$this->operations->EditTask(
            $task_id, $title, $description, $deadline, $subscribers, $parent,
            $event
        ))
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Cannot prepare edit task page details. 
                        Please refresh browser."
                    )
                )
            );
        }


        $details = array();
        if(UserSession::IsFrontman())
        {
            $details = $this->operations->GetFrontmanEditTaskPageDetails(
                UserSession::GetBatchID(), UserSession::GetBatchMemberID(),
                UserSession::IsFirstFrontman(), $task_id
            );
        }
        else if(UserSession::IsCommitteeHead())
        {
            $details = $this->operations->GetCommitteeHeadEditTaskPageDetails(
                UserSession::GetBatchID(), UserSession::GetCommitteeID(), 
                UserSession::GetBatchMemberID(), $task_id
            );
        }
        else 
        {
            $details = $this->operations->GetCommitteeMemberEditTaskPageDetails(
                UserSession::GetBatchID(), UserSession::GetBatchMemberID(), 
                $task_id
            );
        }

        Http::Response(
            Http::OK, array(
                "message" => StringHelper::NoBreakString(
                    "Task successfully edited."
                ),
                "data" => $details
            )
        );
    }

    public function GetAddTaskPageDetails()
    {
        if(!UserSession::IsCommitteeMember() && !UserSession::IsFrontman())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }

        $details = array();
        if(UserSession::IsFrontman())
        {
            $details = $this->operations->GetFrontmanAddTaskPageDetails(
                UserSession::GetBatchID(), UserSession::GetBatchMemberID(),
                UserSession::IsFirstFrontman()
            );
        }
        else if(UserSession::IsCommitteeHead())
        {
            $details = $this->operations->GetCommitteeHeadAddTaskPageDetails(
                UserSession::GetBatchID(), UserSession::GetCommitteeID(), 
                UserSession::GetBatchMemberID()
            );
        }
        else 
        {
            $details = $this->operations->GetCommitteeMemberAddTaskPageDetails(
                UserSession::GetBatchID(), UserSession::GetBatchMemberID()
            );
        }

        Http::Response(
            Http::OK, array(
                "message" => StringHelper::NoBreakString(
                    "Add task page details successfully processed."
                ),
                "data" => $details
            )
        );
    }

    public function AddTask()
    {
        if(!UserSession::IsCommitteeMember() && !UserSession::IsFrontman())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }

        $reporter = UserSession::GetBatchMemberID();

        $title = Http::Request(Http::POST, "task-title");
        $description = Http::Request(Http::POST, "task-description");
        $deadline = Http::Request(Http::POST, "task-deadline");
        $assignee = Http::Request(Http::POST, "task-assignee");
        $subscribers = json_decode(
            Http::Request(Http::POST, "task-subscribers"), true
        );

        $validation = $this->operations->ValidateAddTaskData(
            array(
                "task-title"       => $title,
                "task-description" => $description,
                "task-deadline"    => $deadline,
                "task-assignee"    => $assignee,
                "task-subscribers" => $subscribers,
            )
        );

        if($validation["status"] === false)
        {
            Http::Response(Http::UNPROCESSABLE_ENTITY, $validation["message"]);
        }
        else if(!$this->operations->IsTaskDeadlineValid($deadline))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Task deadline cannot be in the past!"
                    )
                )
            );
        }
        
        $details = array();
        if(UserSession::IsFrontman())
        {
            $details = $this->operations->GetFrontmanAddTaskPageDetails(
                UserSession::GetBatchID(), UserSession::GetBatchMemberID(),
                UserSession::IsFirstFrontman()
            );
        }
        else if(UserSession::IsCommitteeHead())
        {
            $details = $this->operations->GetCommitteeHeadAddTaskPageDetails(
                UserSession::GetBatchID(), UserSession::GetCommitteeID(), 
                UserSession::GetBatchMemberID()
            );
        }
        else 
        {
            $details = $this->operations->GetCommitteeMemberAddTaskPageDetails(
                UserSession::GetBatchID(), UserSession::GetBatchMemberID()
            );
        }

        if(!$this->operations->IsAssigneeSubordinate($assignee, $details))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Assignee is a non-subordinate! Assignee should be a 
                        subordinate."
                    )
                )
            );
        }
        else if(!$this->operations->IsSubscriberArrayValid(
            $subscribers, $assignee, $reporter
        ))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Subscriber list is malformed!"
                    )
                )
            );
        }
        else if(!$this->operations->AreSubscribersSubordinates(
            $subscribers, $details
        ))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Subscriber list contain non-subordinates!"
                    )
                )
            );
        }

        $parent = Http::Request(Http::POST, "task-parent");
        $event = Http::Request(Http::POST, "task-event");

        if(!$this->operations->CheckParentTaskValidByID($parent))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Parent task is not a valid task for a parent!"
                    )
                )
            );
        }
        else if(!$task_id = $this->operations->AddTask(
            $title, $description, $deadline, $reporter, $assignee, $subscribers,
            $parent, $event
        ))
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Something went wrong. Cannot add task. Please
                        try again."
                    )
                )
            );
        }

        Http::Response(
            Http::CREATED, array(
                "message" => StringHelper::NoBreakString(
                    "Task successfully added!"
                ),
                "data" => $details,
                "redirect_url" => Url::GetBaseURL(
                    sprintf("task/view/details/%s", $task_id)
                )
            )
        );
    }
}
