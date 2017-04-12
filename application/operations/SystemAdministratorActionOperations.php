<?php
namespace Jesh\Operations;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;
use \Jesh\Helpers\StringHelper;
use \Jesh\Helpers\Sort;
use \Jesh\Helpers\ValidationDataBuilder;

use \Jesh\Operations\Helpers\BatchMemberOperations;
use \Jesh\Operations\Helpers\CommitteeOperations;
use \Jesh\Operations\Helpers\MemberOperations;

use \Jesh\Models\BatchModel;
use \Jesh\Models\BatchMemberModel;

use \Jesh\Repository\SystemAdministratorActionOperationsRepository;

class SystemAdministratorActionOperations
{
    private $repository;

    private $batch_member;
    private $committee;
    private $member;

    public function __construct()
    {
        $this->repository = new SystemAdministratorActionOperationsRepository;
        $this->batch_member = new BatchMemberOperations;
        $this->committee = new CommitteeOperations;
        $this->member = new MemberOperations;
    }

    public function SetLoggedInState()
    {
        return Session::Set("admin_data", "TRUE");
    }

    public function SetLoggedOutState()
    {
        return Session::End();
    }

    public function ValidateUpdatePasswordData($input_data)
    {
        $validation = new ValidationDataBuilder;

        foreach($input_data as $name => $value) 
        {
            if(strtolower(gettype($value)) === "string") 
            {
                $validation->CheckString($name, $value);
            }
        }
        
        return array(
            "status" => $validation->GetStatus(),
            "data"   => $validation->GetValidationData()
        );
    }

    public function MatchingPassword($password)
    {
        return Security::CheckPassword($password, $this->repository->GetPassword());
    }

    public function ChangePassword($password)
    {
        return $this->repository->ChangePassword(Security::GenerateHash($password));
    }

    public function GetBatches()
    {
        $activeBatch = $this->repository->GetActiveBatch();

        $batches = array();
        foreach($this->repository->GetBatches("DESC") as $batch)
        {
            $batch["IsActive"] = ($batch["BatchID"] == $activeBatch);
            $batches[] = $batch;
        }
        return (sizeof($batches) != 0) ? $batches : false;
    }

    public function CheckAcadYearFormat($input)
    {
        $isValidFormat = filter_var(
            preg_match("/[0-9]{4}-[0-9]{4}/", $input), 
            FILTER_VALIDATE_BOOLEAN
        );

        if($isValidFormat) 
        {
            $years = explode("-", $input);
            return (int)$years[1] - (int)$years[0] == 1;
        }
        else {
            return false;
        }
    }

    public function ExistingBatchByID($batch_id)
    {
        return $this->repository->ExistingBatchByID($batch_id);
    }

    public function ExistingBatchByYear($acad_year)
    {
        return $this->repository->ExistingBatchByYear($acad_year);
    }

    public function CreateBatch(Batchmodel $batch)
    {
        return $this->repository->InsertBatchToDatabase($batch);
    }

    public function HasFirstFrontman($batch_id)
    {
        return $this->repository->HasFirstFrontman(
            $this->repository->GetFirstFrontmanTypeID(), $batch_id
        );
    }

    public function ActivateBatch($batch_id)
    {
        return $this->repository->UpdateActiveBatch($batch_id);
    }

    public function IsActiveBatch($batch_id)
    {
        return $this->repository->GetActiveBatch() == $batch_id;
    }

    public function DeleteBatch($batch_id)
    {
        return $this->repository->DeleteBatchByID($batch_id);
    }

    public function GetBatchDetails($batch_id)
    {
        return array(
            "batch" => array(
                "name" => $this->repository->GetBatchAcadYear($batch_id),
                "committees" => $this->GetBatchCommittees($batch_id),
                "nonMembers" => $this->GetBatchNonMembers($batch_id)
            )
        );
    }

    private function GetBatchCommittees($batch_id)
    {
        $batch_members = $this->GetUnsortedBatchMembers($batch_id);

        $committees = array(
            array(
                "committee" => array(
                    "id" => "-1",
                    "name" => "Unassigned"
                ),
                "members" => $this->GetCommitteeMembers(
                    $batch_members, "Unassigned"
                )
            ),
            array(
                "committee" => array(
                    "id" => "0",
                    "name" => "Frontman"
                ),
                "members" => $this->GetCommitteeMembers(
                    $batch_members, "Frontman"
                )
            )
        );
        foreach($this->committee->GetCommittees() as $committee) {
            
            $committees[] = array(
                "committee" => array(
                    "id" => $committee["CommitteeID"],
                    "name" => $committee["CommitteeName"]
                ),
                "members" => $this->GetCommitteeMembers(
                    $batch_members, $committee["CommitteeName"]
                )
            );
        }

        return $committees;
    }

    private function GetCommitteeMembers($batch_members, $committee_name)
    {
        $committee_members = array();
        foreach($batch_members as $member)
        {
            if($member["committee"] == $committee_name) 
            {
                $committee_members[] = array(
                    "id" => $member["id"],
                    "name" => $member["name"],
                    "position" => $member["position"]
                );
            }
        }
        return $committee_members;
    }

    private function GetUnsortedBatchMembers($batch_id)
    {
        $members = array();
        foreach(
            $this->batch_member->GetBatchMembers($batch_id) as $batch_member
        ) {
            $members[] = array(
                "id" => $batch_member["BatchMemberID"],
                "member_type_id" => $batch_member["MemberTypeID"],
                "name" => $this->member->GetMemberName(
                    $batch_member["MemberID"]
                ),
                "committee" => $this->member->GetMemberCommittee(
                    $batch_member["BatchMemberID"], 
                    $batch_member["MemberTypeID"]
                ),
                "position" => $this->member->GetMemberPosition(
                    $batch_member["MemberTypeID"]
                )
            );
        }
        return Sort::AssociativeArray($members, "member_type_id");
    }

    private function GetBatchNonMembers($batch_id)
    {
        $member_ids = $this->batch_member->GetMemberIDList($batch_id);

        $members = array();
        foreach($this->member->GetMembers() as $member)
        {
            if(!in_array($member["MemberID"], $member_ids)) 
            {
                $members[] = array(
                    "id" => $member["MemberID"],
                    "name" => str_replace(
                        "  ", " ", sprintf("%s %s %s", 
                            $member["FirstName"], 
                            $member["MiddleName"], 
                            $member["LastName"]
                        )
                    )
                );
            }
        }
        return $members;
    }

    public function MemberInBatch($batch_id, $member_id)
    {
        return false;
    }

    public function AddMemberToBatch(BatchMemberModel $batch_member)
    {
        return $this->repository->AddMemberToBatch($batch_member);
    }

    public function BatchMemberInBatch($batch_member_id)
    {
        return true;
    }

    public function RemoveMemberFromBatch($batch_member_id)
    {
        return $this->repository->RemoveBatchMember($batch_member_id);
    }
}