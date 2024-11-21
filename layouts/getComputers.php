<?php
session_start();
include '../controllers/ComputerController.php';

$com = new ComputerController();
$computers = $com->getComputers();
$response = [];

foreach ($computers as $computer) {
    $response[] = [
        'id' => $computer['id'],
        'name' => $computer['name'],
        'status' => $computer['status'],
        'user_id' => $computer['user'],
        'notRenting' => $com->notRenting(),
        'isCurrentUser' => isset($_SESSION['id']) && $_SESSION['id'] == $computer['user'],
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
