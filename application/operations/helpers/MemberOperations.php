<?php
namespace Jesh\Operations\Helpers;

use \Jesh\Helpers\StringHelper;

use \Jesh\Models\MemberModel;

use \Jesh\Repository\MemberOperationsRepository;

class MemberOperations
{
    private $repository;

    public function __construct()
    {
        $this->repository = new MemberOperationsRepository;
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

    public function GetMemberName($member_id)
    {
        $member = $this->repository->GetMemberName($member_id);
        if(sizeof($member) === 1) 
        {
            return str_replace(
                "  ", " ", sprintf("%s %s %s", 
                    $member[0]["FirstName"], 
                    $member[0]["MiddleName"], 
                    $member[0]["LastName"]
                )
            );
        }
        else 
        {
            throw new \Exception(
                sprintf(
                    StringHelper::NoBreakString(
                        "Member name for member id = %s was not found in 
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
        return $this->repository->InsertMember($member);
    }

    public function Update($member_id, MemberModel $member)
    {
        return $this->repository->UpdateMember($member_id, $member);
    }

    public function Delete($member_id)
    {
        return $this->repository->DeleteMemberByID($member_id);
    }
}
