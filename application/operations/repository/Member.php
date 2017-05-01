<?php
namespace Jesh\Operations\Repository;

use \Jesh\Helpers\StringHelper;

use \Jesh\Models\MemberModel;

use \Jesh\Repository\MemberRepository;

class Member
{
    const FIRST_FRONTMAN = "First Frontman";
    const SECOND_FRONTMAN = "Second Frontman";
    const THIRD_FRONTMAN = "Third Frontman";
    const COMMITTEE_HEAD = "Committee Head";
    const COMMITTEE_MEMBER = "Committee Member";

    private $repository;

    public function __construct()
    {
        $this->repository = new MemberRepository;
    }

    public function GetMembers()
    {
        $members = array();
        foreach($this->repository->GetMembers() as $member)
        {
            $members[] = new MemberModel($member);
        }
        return $members;
    }

    public function GetMember($member_id)
    {
        $member = $this->repository->GetMember($member_id);

        if(sizeof($member) === 1) 
        {
            return new MemberModel($member[0]);
        }
        else
        {
            throw new \Exception(
                sprintf(
                    StringHelper::NoBreakString(
                        "Member with member id = %s was not found in 
                        the database"
                    ), $member_id
                )
            );
        }
    }

    public function GetMemberType($member_type_id)
    {
        $member_type = $this->repository->GetMemberType($member_type_id);

        if(sizeof($member_type) === 1) 
        {
            return $member_type[0]["MemberType"];
        }
        else 
        {
            throw new \Exception(
                sprintf(
                    StringHelper::NoBreakString(
                        "Member type for member type id = %s was not found in 
                        the database"
                    ), $member_type_id
                )
            );
        }
    }

    public function GetMemberTypeID($member_type)
    {
        $member_type_id = $this->repository->GetMemberTypeID($member_type);

        if(sizeof($member_type_id) === 1) 
        {
            return $member_type_id[0]["MemberTypeID"];
        }
        else 
        {
            throw new \Exception(
                sprintf(
                    StringHelper::NoBreakString(
                        "Member type ID for member type = %s was not found in 
                        the database"
                    ), $member_type
                )
            );
        }
    }

    public function GetMemberIDByEmailAddress($email_address)
    {
        $member = $this->repository->GetMemberIDByEmailAddress($email_address);

        if(sizeof($member) === 1) 
        {
            return $member[0]["MemberID"];
        }
        else 
        {
            throw new \Exception(
                sprintf(
                    StringHelper::NoBreakString(
                        "Member with email address = %s was not found in 
                        the database"
                    ), $email_address
                )
            );
        }
    }

    public function GetPasswordByEmailAddress($email_address)
    {
        $member = $this->repository->GetMemberPasswordByEmail($email_address);

        if(sizeof($member) === 1) 
        {
            return $member[0]["Password"];
        }
        else 
        {
            throw new \Exception(
                sprintf(
                    StringHelper::NoBreakString(
                        "Member with email address = %s was not found in 
                        the database"
                    ), $email_address
                )
            );
        }
    }

    public function HasMember($member_id)
    {
        return $this->repository->HasMember($member_id);
    }

    public function HasEmailAddress($email_address)
    {
        return $this->repository->HasEmailAddress($email_address);
    }

    public function Add(MemberModel $member)
    {
        $is_added = $this->repository->InsertMember($member);

        if(!$is_added)
        {
            throw new \Exception("Member was not added to database.");
        }

        return $is_added;
    }

    public function Update($member_id, MemberModel $member)
    {
        $is_updated = $this->repository->UpdateMember($member_id, $member);

        if(!$is_updated)
        {
            throw new \Exception(
                sprintf(
                    StringHelper::NoBreakString(
                        "Member with member id = %s was not modified."
                    ), $member_id
                )
            );
        }

        return $is_updated;
    }

    public function Delete($member_id)
    {
        $is_deleted = $this->repository->DeleteMemberByID($member_id);

        if(!$is_deleted)
        {
            throw new \Exception(
                sprintf(
                    StringHelper::NoBreakString(
                        "Member with member id = %s was not deleted."
                    ), $member_id
                )
            );
        }

        return $is_deleted;
    }
}
