<?php

include_once '../../model/CreditCard.php';

class CreditCardDataService
{
    private $connection;
    
    function __construct()
    {
        $database = new Database();
        $this->connection = $database->getConnection();
    }
    
    public function createCreditCard(CreditCard $card, int $userID)
    {
        $sql_query = "SELECT * FROM CREDIT_CARD WHERE USER_ID = $userID";
        $results = mysqli_query($this->connection, $sql_query);
        $numOfRows = mysqli_num_rows($results);
        
        if($numOfRows < 1)
        {
            $sql_statement = "INSERT INTO `CREDIT_CARD` (`ID`, `NAME_ON_CARD`, `NUMBER`, `EXPERATION_DATE`, `SECURITY_CODE`, `USER_ID`) VALUES (NULL, '{$card->getNameOnCard()}', '{$card->getCardNumber()}', '{$card->getExperationDate()}', '{$card->getSecurityCode()}', '$userID');";
            return mysqli_query($this->connection, $sql_statement);
        }
        
        else
        {
            $row = $results->fetch_assoc();
            $cardID = $row['ID'];
            
            return $this->updateCard($card, $cardID);
        }
    }
    
    public function updateCard(CreditCard $card, int $cardID)
    {
        $sql_statement = "UPDATE CREDIT_CARD SET NAME_ON_CARD = '{$card->getNameOnCard()}', NUMBER = '{$card->getCardNumber()}', EXPERATION_DATE = '{$card->getExperationDate()}', SECURITY_CODE = '{$card->getSecurityCode()}' WHERE ID = $cardID";
        return mysqli_query($this->connection, $sql_statement);
    }
    
    public function deleteCard(int $cardID)
    {
        $sql_statement = "DELETE FROM CREDIT_CARD WHERE ID = $cardID";
        return mysqli_query($this->connection, $sql_statement);
    }
    
    public function viewAllCards()
    {
        $cardList = array();
        $index = 0;
        
        $sql_query = "SELECT * FROM CREDIT_CARD";
        $results = mysqli_query($this->connection, $sql_query);
        
        while($row = $results->fetch_assoc())
        {
            $nameOnCard = $row['NAME_ON_CARD'];
            $number = $row['NUMBER'];
            $experationDate = $row['EXPERATION_DATE'];
            $securityCode = $row['SECURITY_CODE'];
            
            $card = new CreditCard($number, $nameOnCard, $experationDate, $securityCode);
        
            $cardList[$index] = $card;
            $index++;
        }
        
        return $cardList;
    }
    
    public  function viewCardByID($cardID)
    {
        $sql_query = "SELECT * FROM CREDIT_CARD WHERE ID = $cardID";
        $results = mysqli_query($this->connection, $sql_query);
        
        $row = $results->fetch_assoc();
        $nameOnCard = $row['NAME_ON_CARD'];
        $number = $row['NUMBER'];
        $experationDate = $row['EXPERATION_DATE'];
        $securityCode = $row['SECURITY_CODE'];
            
        $card = new CreditCard($number, $nameOnCard, $experationDate, $securityCode);
            
        return $card;
    }
    
    public function viewCardByUserID(int $userID)
    {
        $sql_query = "SELECT * FROM CREDIT_CARD WHERE USER_ID = $userID";
        $results = mysqli_query($this->connection, $sql_query);
        
        $row = $results->fetch_assoc();
        $nameOnCard = $row['NAME_ON_CARD'];
        $number = $row['NUMBER'];
        $experationDate = $row['EXPERATION_DATE'];
        $securityCode = $row['SECURITY_CODE'];
        
        $card = new CreditCard($number, $nameOnCard, $experationDate, $securityCode);
        
        return $card;
    }
}