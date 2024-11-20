<?php
include '../controllers/ComputerController.php';
include '../controllers/AccountController.php';

$com = new ComputerController();
$account = new AccountController();

$computers = $com->getComputers();

foreach ($computers as &$computer) {
    if ($computer['status'] !== 'available') {
        $computer['user_name'] = $account->getName($computer['user']);
    } else {
        $computer['user_name'] = null;
    }
}

header('Content-Type: application/json');
echo json_encode($computers);
