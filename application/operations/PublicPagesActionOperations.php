<?php
namespace Jesh\Operations;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;
use \Jesh\Helpers\ValidationDataBuilder;

use \Jesh\Models\MemberModel;
use \Jesh\Repository\PublicPagesActionOperationsRepository;

class PublicPagesActionOperations
{
    private $repository;

    public function __construct()
    {
        $this->repository = new PublicPagesActionOperationsRepository;
    }

    public function ValidateLoginData($username, $password)
    {
        $validation = new ValidationDataBuilder;

        $validation->CheckString("username", $username);
        $validation->CheckString("password", $password);
        $validation->CheckEmail("username", $username);
                
        return array(
            "status"  => $validation->GetStatus(),
            "message" => $validation->GetValidationData()
        );
    }

    public function ExistingUsername($username)
    {
        return $this->repository->GetUsernameExists($username);
    }

    public function MatchingPassword($username, $password) 
    {
        return Security::CheckPassword($password, 
            $this->repository->GetPassword($username)
        );
    }

    public function SetLoggedInState($username)
    {
        $member = $this->repository->GetMemberData($username);

        return Session::Set("user_data", json_encode(
            array(
                "id"            => $member->MemberID,
                "first_name"    => $member->FirstName,
                "middle_name"   => $member->MiddleName,
                "last_name"     => $member->LastName,
                "email_address" => $username,
                "phone_number"  => $member->PhoneNumber
            )
        ));
    }

    public function ValidateRegistrationData($registration_data)
    {
        $validation = new ValidationDataBuilder;

        foreach($registration_data as $name => $value)
        {
            if(strtolower(gettype($value)) === "string") 
            {
                $validation->CheckString($name, $value);
            }
            if($name === "email_address") 
            {
                $validation->CheckEmail($name, $value);
            }
        }
        
        return array(
            "status"  => $validation->GetStatus(),
            "message" => $validation->GetValidationData()
        );
    }

    public function CreateMember(MemberModel $member)
    {
        if($this->repository->InsertMemberToDatabase($member))
        {
            return array(
                "status" => true,
                "data" => "Member has been successfully created."
            );
        }
        else
        {
            return array(
                "status" => false,
                "data" => "Member has not been successfully created."
            );
        }
    }

    public function SetLoggedOutState()
    {
        return Session::End();
    }
}
