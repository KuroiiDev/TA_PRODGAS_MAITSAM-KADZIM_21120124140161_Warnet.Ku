<?php
include '../controllers/ComputerController.php';
$com = new ComputerController();

if (isset($_POST['computer_id'])) {
    $computerId = $_POST['computer_id'];
    $com->stopComputerEnd($computerId);

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Butuh Id']);
}