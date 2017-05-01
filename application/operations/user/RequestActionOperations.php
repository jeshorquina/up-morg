<?php
namespace Jesh\Operations\User;

use \Jesh\Helpers\UserSession;

use \Jesh\Models\CommitteeMemberModel;

use \Jesh\Operations\Repository\Committee;

class RequestActionOperations
{
    private $committee;

    public function __construct()
    {
        $this->committee = new Committee;
    }

    public function GetCommittees()
    {
        $batch_member_id = UserSession::GetBatchMemberID();

        $committees = array();
        foreach($this->committee->GetCommittees() as $committee)
        {
            $committees[] = array(
                "id" => $committee->CommitteeID,
                "name" => $committee->CommitteeName,
                "selected" => (
                    $this->committee->IsBatchMemberInCommittee(
                        $batch_member_id, $committee->CommitteeID
                    )
                )
            );
        }
        return $committees;
    }

    public function RequestCommittee($committee_id)
    {
        $batch_member_id = UserSession::GetBatchMemberID();
        if(!$this->committee->HasBatchMember($batch_member_id))
        {
            return $this->committee->AddMember(
                new CommitteeMemberModel(
                    array(
                        "BatchMemberID" => $batch_member_id,
                        "CommitteeID" => $committee_id,
                        "IsApproved" => false
                    )
                )
            );
        }
        else
        {
            return $this->committee->UpdateMember(
                $batch_member_id,
                new CommitteeMemberModel(
                    array("CommitteeID" => $committee_id)
                )
            );
        }
        
    }
}
