<?php

$config = include 'config.php';
extract($config);


if(isset($_GET['read']))
{
    $data = [
        [
            'text' => 'Hello',
            'id' => '1',
        ],
        [
            'text' => 'Buy',
            'id' => '2',
        ]
    ];

 
    $conn = new mysqli($HOST,$USER,$PASSWORD,$DBNAME);

    // Check connection
    if ($mysqli -> connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
    }

    echo json_encode($data);
}
else if(isset($_GET['add']))
{

}
else if(isset($_GET['delete']))
{

}
else
{
    die;
}

