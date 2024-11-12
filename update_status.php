<?php
require_once 'ComputerManager.php';

if (isset($_POST['computer_id'])) {
    $computerManager = new ComputerManager();
    $computerId = intval($_POST['computer_id']);
    $computerStatus = $_POST['computer_status'];

    if($computerStatus == "disable") {
        if ($computerManager->updateStatus($computerId, 'in-use')) {
            header('Location: computer.php?success=1');
            exit;
        } else {
            header('Location: computer.php?error=1');
            exit;
        }
    } elseif ($computerStatus == "enable") {
        if ($computerManager->updateStatus($computerId, 'available')) {
            header('Location: computer.php?success=1');
            exit;
        } else {
            header('Location: computer.php?error=1');
            exit;
        }
    } else {
        header('Location: computer.php?error=1');
        exit;
    }
}