<?php

include_once 'task.php';

$task = new Task();

echo($task->read_all());
