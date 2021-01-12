<?php
Class User
{
    private $idNum;
    private $firstName;
    private $lastName;
    private $userName;
    private $password; 
    private $email;
    private $phoneNumber;
    private $priority;
    
    function __construct($idNum, $firstName, $lastName, $userName, $password, $email, $phoneNumber, $priority)
    {
        $this->idNum = $idNum;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->userName = $userName;
        $this->password = $password;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->priority = $priority;
    }
    
    public function getIdNum()
    {
        return $this->idNum;
    }
    
    public function getFirstName()
    {
        return $this->firstName;
    }
    
    public function getLastName()
    {
        return $this->lastName;
    }
    
    public function getUserName()
    {
        return $this->userName;
    }
    
    public function getPassword()
    {
        return $this->password;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }
    
    public function getPriority()
    {
        return $this->priority;
    }
    
    public function setIdNum($idNum)
    {
        $this->idNum = $idNum;
    }
    
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }
    
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }
    
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }
    
    public function setPassword($password)
    {
        $this->password = $password;
    }
    
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }
    
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }
}