<?php

include_once 'task.php';

$obj = json_decode(file_get_contents("php://input"));

$message = '';
$ok = false;
    
$text = htmlspecialchars(strip_tags($obj->text));
$task = new Task();
$task->text = $text;

//here we check if task already exists in db
$res = $task->read_one();
//if task doesnt exist
if($res === false)
{
    $res = $task->add();
    if($res)
        $ok = true;
    else
        $message = 'Error occured';
}
else //task already exists
{
    $message = 'Already exists';
}

echo json_encode(array('ok'=>$ok, 'message'=>$message));