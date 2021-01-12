<?php

Class Order
{
    private $number;
    private $address;
    private $cardNumber;
    private $user;
    private $totalPrice;
    private $numberOfProducts;
    
    function __construct($number, $address, $cardNumber, $user, $totalPrice, $numberOfProducts) 
    {
        $this->number = $number;
        $this->address = $address;
        $this->cardNumber = $cardNumber;
        $this->user = $user;
        $this->totalPrice = $totalPrice;
        $this->numberOfProducts = $numberOfProducts;
    }
    
    public function getNumber()
    {
        return $this->number;
    }
    
    public function getAddresss()
    {
        return $this->address;
    }
    
    public function getCardNumber()
    {
        return $this->cardNumber;
    }
    
    public function getUser()
    {
        return $this->user;
    }
    
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }
    
    public function getNumberOfProducts()
    {
        return $this->numberOfProducts;
    }
    
    public function setNumber($number)
    {
        $this->number = $number;
    }
    
    public function setAddress($address)
    {
        $this->address = $address;
    }
    
    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;
    }
    
    public function setUser($user)
    {
        $this->user = $user;
    }
    
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;
    }
    
    public function setNumberOfProducts($numberOfProducts)
    {
        $this->numberOfProducts = $numberOfProducts;
    }
}