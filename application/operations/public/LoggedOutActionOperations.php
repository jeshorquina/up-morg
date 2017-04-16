<?php
namespace Jesh\Operations\LoggedOut;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;
use \Jesh\Helpers\ValidationDataBuilder;

use \Jesh\Models\MemberModel;

use \Jesh\Operations\Repository\MemberOperations;

class LoggedOutActionOperations
{
    private $member;

    public function __construct()
    {
        $this->member = new MemberOperations;
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
        return $this->member->HasEmailAddress($username);
    }

    public function MatchingPassword($username, $password) 
    {
        return Security::CheckPassword($password, 
            $this->member->GetPasswordByEmailAddress($username)
        );
    }

    public function SetLoggedInState($username)
    {
        $member_details = $this->member->GetMember(
            $this->member->GetMemberIDByEmailAddress($username)
        );

        return Session::Set("user_data", json_encode(
            array(
                "id"            => $member_details->MemberID, // should be batch member id
                "first_name"    => $member_details->FirstName,
                "middle_name"   => $member_details->MiddleName,
                "last_name"     => $member_details->LastName,
                "email_address" => $member_details->EmailAddress,
                "phone_number"  => $member_details->PhoneNumber
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

    public function CreateMember(
        $first_name, $middle_name, $last_name, $email, $phone, $password
    )
    {
        $member_details = new MemberModel(
            array(
                "FirstName"    => $first_name,
                "MiddleName"   => $middle_name,
                "LastName"     => $last_name,
                "EmailAddress" => $email,
                "PhoneNumber"  => $phone,
                "Password"     => Security::GenerateHash($password),
            )
        );

        if(!$this->member->Add($member_details))
        {
            return array(
                "status" => false,
                "data" => "Member has not been successfully created."
            );
        }
        else
        {
            return array(
                "status" => true,
                "data" => "Member has been successfully created."
            );
        }
    }

    public function SetLoggedOutState()
    {
        return Session::End();
    }
}
