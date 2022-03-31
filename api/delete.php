<?php

include_once 'task.php';

$obj = json_decode(file_get_contents("php://input"));

$message = '';
$ok = false;
    
$text = htmlspecialchars(strip_tags($obj->text));
$task = new Task();
$task->text = $text;

$res = $task->delete();

if($res)
{
    $ok = true;
}
else
{
    $message = 'Error';
}

echo json_encode(array('ok'=>$ok, 'message'=>$message));