<?php
namespace Jesh\Operations\Admin;

use \Jesh\Helpers\StringHelper;
use \Jesh\Helpers\Sort;
use \Jesh\Helpers\ValidationDataBuilder;

use \Jesh\Operations\Repository\Member;

use \Jesh\Models\MemberModel;

class MemberActionOperations
{
    private $member;

    public function __construct()
    {
        $this->member = new Member;
    }

    public function GetMembers()
    {
        $members = array();
        foreach($this->member->GetMembers() as $member) {
            $members[] = $this->MutateMember($member);
        }

        return Sort::AssociativeArray(
            $members, "name", Sort::ASCENDING
        );
    }

    public function ExistingMemberByID($member_id)
    {
        return $this->member->HasMember($member_id);
    }

    public function DeleteMember($member_id)
    {
        return $this->member->Delete($member_id);
    }

    public function GetMemberDetails($member_id)
    {
        return array(
            "member" => $this->MutateMemberDetails(
                $this->member->GetMember($member_id)
            )
        );
    }

    public function ValidateMemberDetails($member_array) 
    {
        $validation = new ValidationDataBuilder;

        foreach($member_array as $name => $value) 
        {
            if($name === "email-address")
            {
                $validation->CheckEmail($name, $value);
            }
            else if(strtolower(gettype($value)) === "string")
            {
                $validation->CheckString($name, $value);
            }
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

    public function ModifyMemberDetails($member_array)
    {
        return $this->member->Update(
            $member_array["id"], new MemberModel(
                array(
                    "FirstName" => $member_array["first-name"],
                    "MiddleName" => $member_array["middle-name"],
                    "LastName" => $member_array["last-name"],
                    "EmailAddress" => $member_array["email-address"],
                    "PhoneNumber" => $member_array["phone-number"]
                )
            )
        );
    }

    private function MutateMemberDetails(MemberModel $member)
    {
        return array(
            "id"            => $member->MemberID,
            "first-name"    => $member->FirstName,
            "middle-name"   => $member->MiddleName,
            "last-name"     => $member->LastName,
            "email-address" => $member->EmailAddress,
            "phone-number"  => $member->PhoneNumber,
        );
    }

    private function MutateMember(MemberModel $member)
    {
        return array(
            "id" => $member->MemberID,
            "name" => str_replace(
                "  ", " ", sprintf("%s %s %s", 
                    $member->FirstName, 
                    $member->MiddleName, 
                    $member->LastName
                )
            )
        );
    }
}
