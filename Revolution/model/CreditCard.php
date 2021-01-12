<?php

class CreditCard {
    
    private $cardNumber;
    private $nameOnCard;
    private $experationDate;
    private $securityCode;
    
    function __construct($cardNumber, $nameOnCard, $experationDate, $securityCode)
    {
        $this->cardNumber = $cardNumber;
        $this->nameOnCard = $nameOnCard;
        $this->experationDate = $experationDate;
        $this->securityCode = $securityCode;
    }
    
    public function getCardNumber()
    {
        return $this->cardNumber;
    }
    
    public function getNameOnCard()
    {
        return $this->nameOnCard;
    }
    
    public function getExperationDate()
    {
        return $this->experationDate;
    }
    
    public function getSecurityCode()
    {
        return $this->securityCode;
    }
    
    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;
    }
    
    public function setNameOnCard($nameOnCard)
    {
        $this->nameOnCard = $nameOnCard;
    }
    
    public function setExperationDate($experationDate)
    {
        $this->experationDate = $experationDate;
    }
    
    public function setSecurityCode($securityCode)
    {
        $this->securityCode = $securityCode;
    }
}