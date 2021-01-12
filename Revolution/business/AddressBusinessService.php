<?php

session_start();
include_once '../../data/AddressDataService.php';

class AddressBusinessService
{
    private $service;
    
    function __construct()
    {
        $dateService = new AddressDataService();
        $this->service = $dateService;
    }
    
    public function createAddress(Address $address)
    {
        $currentUser = $_SESSION['currentUser'];
        $userID = $currentUser->getIdNum();
        
        return $this->service->createAddress($address, $userID);
    }
    
    public function updateAddress(Address $address, int $addressID)
    {
        return $this->service->updateAddress($address, $addressID);
    }
    
    public function deleteAddress(int $addressID)
    {
        return $this->service->deleteAddress($addressID);
    }
    
    public function viewAllAddress()
    {
        return $this->service->viewAllAddress();
    }
    
    public function viewAddressById(int $addressId)
    {
        return $this->service->viewAddressById($addressId);
    }
    
    public function viewAddressByUserId(int $userId)
    {
        return $this->service->viewAddressByUserId($userId);
    }
}