<?php

include_once '../../model/Address.php';

class AddressDataService
{
    private $connection;
    
    function __construct()
    {
        $database = new Database();
        $this->connection = $database->getConnection();
    }
    
    public function createAddress(Address $address, int $userId)
    {
        $sql_query = "SELECT * FROM ADDRESS WHERE USER_ID = $userId";
        $results = mysqli_query($this->connection, $sql_query);
        $numOfRows = mysqli_num_rows($results);
        
        if($numOfRows < 1)
        {
            $sql_statement = "INSERT INTO `ADDRESS` (`ID`, `STREET_NAME`, `CITY`, `STATE`, `ZIP_CODE`, `COUNTRY`, `USER_ID`) VALUES (NULL, '{$address->getStreetName()}', '{$address->getCity()} ', '{$address->getState()}', '{$address->getZipCode()}', '{$address->getCountry()}', '$userId');";
            return mysqli_query($this->connection, $sql_statement);
        }
        
        else
        {
            $row = $results->fetch_assoc();
            $addressId = $row['ID'];
            
            return $this->updateAddress($address, $addressId);
        }
    }
    
    public function updateAddress(Address $address, int $addressID)
    {
        $sql_query = "SELECT * FROM ADDRESS WHERE ID = $addressID";
        $results = mysqli_query($this->connection, $sql_query);
        $row = $results->fetch_assoc();
        $addressId = $row['ID'];
        
        $sql_statement = "UPDATE `ADDRESS` SET `STREET_NAME` = '{$address->getStreetName()}', `CITY` = '{$address->getCity()}', `STATE` = '{$address->getState()}', `ZIP_CODE` = '{$address->getZipCode()}', `COUNTRY` = '{$address->getCountry()}' WHERE `ADDRESS`.`ID` = $addressId;";
        return mysqli_query($this->connection, $sql_statement);
    }
    
    public function deleteAddress(int $addressId)
    {
        $sql_statement = "DELETE FROM `ADDRESS` WHERE `ADDRESS`.`ID` = $addressId";
        return mysqli_query($this->connection, $sql_statement);
    }
    
    public function viewAllAddress()
    {
        $addressList = array();
        $index = 0;
        
        $sql_query = "SELECT * FROM ADDRESS";
        $results = mysqli_query($this->connection, $sql_query);
        
        while($row = $results->fetch_assoc())
        {
            $streetName = $row['STREET_NAME'];
            $city = $row['CITY'];
            $state = $row['STATE'];
            $zipCode = $row['ZIP_CODE'];
            $country = $row['COUNTRY']; 
            
            $address = new Address($streetName, $city, $state, $zipCode, $country);
            
            $addressList[$index] = $address;
            $index++;
        }
        
        return $addressList;
    }
    
    public function viewAddressById(int $addressId)
    {
        $sql_query = "SELECT * FROM ADDRESS WHERE ID = $addressId";
        $results = mysqli_query($this->connection, $sql_query);
        $row = $results->fetch_assoc();
        
        $streetName = $row['STREET_NAME'];
        $city = $row['CITY'];
        $state = $row['STATE'];
        $zipCode = $row['ZIP_CODE'];
        $country = $row['COUNTRY'];
        
        $address = new Address($streetName, $city, $state, $zipCode, $country);
        
        return $address; 
    }
    
    public function viewAddressByUserId($userId)
    {
        $sql_query = "SELECT * FROM ADDRESS WHERE USER_ID = $userId";
        $results = mysqli_query($this->connection, $sql_query);
        $row = $results->fetch_assoc();
        
        $streetName = $row['STREET_NAME'];
        $city = $row['CITY'];
        $state = $row['STATE'];
        $zipCode = $row['ZIP_CODE'];
        $country = $row['COUNTRY'];
        
        $address = new Address($streetName, $city, $state, $zipCode, $country);
        
        return $address; 
    }
}