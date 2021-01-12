<?php
include_once 'Database.php';
include_once '../../model/User.php';

session_start();

Class UserDataService
{
     private $connection;
    
    function __construct() 
    {
        $database = new Database();
        $this->connection = $database->getConnection();
    }
    
    public function createUser(User $user)
    {
       $sql_query = "SELECT * FROM USER WHERE USER_NAME='{$user->getUserName()}';";
       $results = mysqli_query($this->connection, $sql_query);
       $numOfRows = mysqli_num_rows($results);
       
       if($numOfRows == 0)
       {
           $sql_statement = "INSERT INTO `USER` (`ID`, `FIRST_NAME`, `LAST_NAME`, `USER_NAME`, `PASSWORD`, `EMAIL`, `PHONE_NUMBER`, `USER_ROLE_ID`) VALUES (NULL, '{$user->getFirstName()}', '{$user->getLastName()}', '{$user->getUserName()}', '{$user->getPassword()}', '{$user->getEmail()}', '{$user->getPhoneNumber()}', '2');";
                      
           $result = $this->connection->query($sql_statement);
           
           $userID = mysqli_insert_id($this->connection);
           
           $user->setIdNum($userID);
           $user->setPriority(2);
           
           $_SESSION['currentUser'] = $user;
       }
       
       else
       {
           $result = false;
       }
       
       return $result;
    }
    
    public function updateUser(User $user, int $id)
    {
        $result = false;

        $sql_statement = "UPDATE `USER` SET `FIRST_NAME` = '{$user->getFirstName()}', `LAST_NAME` = '{$user->getLastName()}', `USER_NAME` = '{$user->getUserName()}', `PASSWORD` = '{$user->getPassword()}', `EMAIL` = '{$user->getEmail()}', `PHONE_NUMBER` = '{$user->getPhoneNumber()}' WHERE `USER`.`ID` = $id;";
        
        $result =  $this->connection->query($sql_statement);
        
        return $result;
    }
    
    public function deleteUser(int $id)
    {
        //Delete all addresss assigned to user
        $sql_query = "SELECT * FROM ADDRESS WHERE USER_ID = $id;";
        $results = mysqli_query($this->connection, $sql_query);
        
        while($row = $results->fetch_assoc())
        {
            $currentID = $row['ID'];
            $sql_statement = "DELETE FROM `ADRESS` WHERE `ID`= $currentID;";
            mysqli_query($this->connection, $sql_statement);
        }
        
        //Delete all cards assigned to user
        $sql_query = "SELECT * FROM CREDIT_CARD WHERE USER_ID = $id;";
        $results = mysqli_query($this->connection, $sql_query);
        
        while($row = $results->fetch_assoc())
        {
            $currentID = $row['ID'];
            $sql_statement = "DELETE FROM `CREDIT_CARD` WHERE `ID`= $currentID;";
            mysqli_query($this->connection, $sql_statement);
        }
        
        //Delete user itself
        $sql_statement = "DELETE FROM `USER` WHERE `USER`.`ID` = $id;";

        return mysqli_query($this->connection, $sql_statement);
    }
    
    public function viewUsers()
    {
        $users = array();
        $index = 0;
        
        $sql_query = "SELECT * FROM USER";
        $results = mysqli_query($this->connection, $sql_query);
        
        while($row = $results->fetch_assoc())
        {
            $id = $row['ID']; 
            $firstName = $row['FIRST_NAME']; 
            $lastName = $row['LAST_NAME']; 
            $userName = $row['USER_NAME']; 
            $password = $row['PASSWORD']; 
            $email = $row['EMAIL']; 
            $phoneNumber = $row['PHONE_NUMBER']; 
            $userRole = $row['USER_ROLE_ID'];
            
            $currentUser = new User($id, $firstName, $lastName, $userName, $password, $email, $phoneNumber, $userRole);
           
            $users[$index] = $currentUser;
            $index++;
        }
        
        return $users;
    }
    
    public function getPermission(int $userId)
    {
        $sql_query = "SELECT USER_ROLE_ID FROM USER WHERE ID = $userId";
        $results = mysqli_query($this->connection, $sql_query);
        $row = $results->fetch_assoc();
        
        $permissionID = $row['USER_ROLE_ID'];
        
        $sql_statement = "SELECT * FROM USER_ROLE WHERE ID = $permissionID";
        $results = mysqli_query($this->connection, $sql_statement);
        $row = $results->fetch_assoc();
        
        $permission = $row['PRIORITY'];
        
        return $permission;
    }
}