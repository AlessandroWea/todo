<?php

class Db
{
    protected $conn;
    
    public function __construct()
    {
        $this->conn = $this->connect();
    }

    private function connect()
    {
        $host = 'localhost';
        $dbname = 'todo_app';
        $user = 'root';
        $password = '';

        $conn = new mysqli($host,$user,$password,$dbname);

        // Check connection
        if ($conn->connect_errno) {
            echo "Failed to connect to MySQL: " . $conn->connect_error;
            exit();
        }
        
        return $conn;
    }
}

