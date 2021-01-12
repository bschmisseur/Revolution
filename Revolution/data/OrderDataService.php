<?php

include_once '../../model/Order.php';

class OrderDataService
{
    private $connection;
    
    function __construct()
    {
        $database = new Database();
        $this->connection = $database->getConnection();
    }
    
    public function viewAllOrders()
    {
        $orderList = array();
        $index = 0;
        
        $sql_statement = "SELECT * FROM `ORDER` ORDER BY `ORDER`.`DATE` ASC";
        $results = mysqli_query($this->connection, $sql_statement);
        
        while($row = $results->fetch_assoc())
        {
            $orderID = $row['ID'];
            $number = $row['CONFIRMATION_NUMBER'];
            $address = $row['ADRESS'];
            $cardNumber = $row['CARD_NUMBER'];
            $user = $row['USER_ID'];
            $totalPrice = $row['TOTAL_PRICE'];
            $numberOfProducts = 0;
            
            $sql_query = "SELECT * FROM ORDER_has_PRODUCT WHERE ORDER_ID = '$orderID'";
            $result = mysqli_query($this->connection, $sql_query);
            $numberOfProducts = mysqli_num_rows($result);
            
            $order = new Order($number, $address, $cardNumber, $user, $totalPrice, $numberOfProducts);
            
            $orderList[$index] = $order;
            $index++;
        }
        
        return $orderList;
    }
}