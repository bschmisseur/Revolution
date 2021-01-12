<?php
Class Database
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "root";
    private $database_name = "FinalShoeDatabase";
    
    function getConnection()
    {
        // Create connection
        $connection = mysqli_connect($this->servername, $this->username, $this->password, $this->database_name);
        
        // Check connection
        if (!$connection)
        {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        return $connection;
    }
}