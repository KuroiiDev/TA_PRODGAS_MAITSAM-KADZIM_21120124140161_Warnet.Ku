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

    function notRenting($id)
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
        if ($count==0){
            return true;
        } else {
            return false;
        }
    }
}