<?php

class Address {
    
    private $streetName;
    private $city;
    private $state;
    private $zipCode;
    private $country;
    
    function __construct($streetName, $city, $state, $zipCode, $country)
    {
        $this->streetName = $streetName;
        $this->city = $city;
        $this->state = $state;
        $this->zipCode = $zipCode;
        $this->country = $country;
    }
    
    public function getStreetName()
    {
        return $this->streetName;
    }
    
    public function getCity()
    {
        return $this->city;
    }
    
    public function getState()
    {
        return $this->state;
    }
    
    public function getZipCode()
    {
        return $this->zipCode;
    }
    
    public function getCountry()
    {
        return $this->country;
    }
    
    public function setStreetName($streetName)
    {
        $this->streetName = $streetName;
    }
    
    public function setCity($city)
    {
        $this->city = $city;
    }
    
    public function setState($state)
    {
        $this->state = $state;
    }
    
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }
    
    public function setCountry($country)
    {
        $this->country = $country;
    }
}