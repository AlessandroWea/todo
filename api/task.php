<?php

include_once 'db.php';

class Task extends Db
{
    public $text;

    public function read_one()
    {
        $query = "SELECT * FROM todos WHERE text=?";

        $stmt = $this->conn->stmt_init();
        $stmt->prepare($query);
        
        $stmt->bind_param('s', $this->text);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if($row)
        {
            return json_encode($row);
        }

        return false;

    }

    public function read_all()
    {
        $result = $this->conn->query("SELECT * FROM todos");

        $data = [];

        while ($row = $result->fetch_assoc()) {
            array_push($data, array('text' => $row['text']));
        }
        
        return json_encode($data);
    }

    public function delete()
    {
        $query = "DELETE FROM todos WHERE text=?";

        $stmt = $this->conn->stmt_init();
        $stmt->prepare($query);
        
        $stmt->bind_param('s', $this->text);
        $stmt->execute();

        if($this->conn->affected_rows > 0)
        {
            return true;
        }
        
        return false;
    }

    public function add()
    {
        $query = "INSERT INTO todos(text) VALUES(?)";

        $stmt = $this->conn->stmt_init();
        $stmt->prepare($query);
        
        $stmt->bind_param('s', $this->text);
        $stmt->execute();
        
        if($this->conn->affected_rows > 0)
        {
            return true;
        }
        
        return false;
    }
}