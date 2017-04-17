<?php
namespace Jesh\Operations\User;

use \Jesh\Helpers\UserSession;

use \Jesh\Models\CommitteeMemberModel;

use \Jesh\Operations\Repository\CommitteeOperations;

class RequestActionOperations
{
    private $committee;

    public function __construct()
    {
        $this->committee = new CommitteeOperations;
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
        return $this->committee->UpdateMember(
            UserSession::GetBatchMemberID(),
            new CommitteeMemberModel(array("CommitteeID" => $committee_id))
        );
    }
}
