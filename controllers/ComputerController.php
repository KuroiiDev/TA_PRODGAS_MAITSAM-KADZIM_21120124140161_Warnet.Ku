<?php

class ComputerController
{
    function getComputers()
    {
        include 'ConnectionController.php';

        $query = "SELECT * FROM computers";
        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $computers[] = $row;
            }
        }
        return $computers;
    }

    function notRenting()
    {
        include 'ConnectionController.php';

        $count = 0;
        $query = "SELECT * FROM computers";
        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $computers[] = $row;
                if ($row['user'] == $_SESSION['id']) {
                    $count++;
                }
            }
        }
        if ($count == 0) {
            return true;
        } else {
            return false;
        }
    }

    function changeStatus($id, $status)
    {
        include 'ConnectionController.php';
        $uid = $_SESSION['id'];

        try {
            if ($status == 'unavailable') {
                $success = "Mulai Menggunakan Komputer";
            } else {
                $success = "Selesai Menggunakan Komputer";
                $uid = 0;
            }

            $query = "UPDATE computers SET status = '$status', user = $uid WHERE id = '$id'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                header("Location: /warnet.ku/views/computer.php?success=$success");
            } else {
                $error = mysqli_error($conn);
                header("Location: /warnet.ku/views/computer.php?error=$error");
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
            header("Location: /warnet.ku/views/computer.php?error=$error");
        }
    }
}