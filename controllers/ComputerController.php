<?php

class ComputerController
{
    function getComputers()
    {
        include 'ConnectionController.php';

        $query = "SELECT * FROM computers ORDER BY name";
        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $computers[] = $row;
            }
        }
        return $computers;
    }

    function addComputer($name)
    {
        include 'ConnectionController.php';

        try {
            if ($name != '') {
                $query = "INSERT INTO computers (name) VALUES ('$name')";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    $success = "Komputer Baru Berhasil Ditambahkan!";
                    header("Location: /warnet.ku/views/computer_admin.php?success=$success");
                } else {
                    $error = mysqli_error($conn);
                    header("Location: /warnet.ku/views/computer_admin.php?error=$error");
                }
            } else {
                $error = "Tolong isi Nama Komputer!";
                header("Location: /warnet.ku/views/computer_admin.php?error=$error");
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
            header("Location: /warnet.ku/views/computer_admin.php?error=$error");
        }
    }

    function deleteComputer($id)
    {
        include 'ConnectionController.php';

        try {
            $query = "DELETE FROM computers WHERE id = '$id'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                $success = "Komputer Berhasil Dihapus!";
                header("Location: /warnet.ku/views/computer_admin.php?success=$success");
            } else {
                $error = mysqli_error($conn);
                header("Location: /warnet.ku/views/computer.php?error=$error");
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
            header("Location: /warnet.ku/views/computer_admin.php?error=$error");
        }
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

    function changeStatus($id, $status, $billing)
    {
        include 'ConnectionController.php';
        date_default_timezone_set('Asia/Jakarta');
        $uid = $_SESSION['id'];

        try {
            if ($status == 'unavailable') {
                if ($billing == '') {
                    $error = "Billing tidak Boleh Kosong!";
                    header("Location: /warnet.ku/views/computer.php?error=$error");
                    exit();
                } else {
                    $time = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) + 60 * $billing);
                }
                $success = "Mulai Menggunakan Komputer";
                $query = "SELECT * FROM computers WHERE id = '$id'";
                $result = mysqli_query($conn, $query);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    if ($row['user'] != 0) {
                        $error = "Komputer sudah dipinjam!";
                        header("Location: /warnet.ku/views/computer.php?error=$error");
                        exit();
                    }
                }
            } else {
                $query = "SELECT * FROM computers WHERE id = '$id'";
                $result = mysqli_query($conn, $query);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    if ($row['user'] == 0) {
                        $error = "Komputer telah Dihentikan Admin!";
                        header("Location: /warnet.ku/views/computer.php?error=$error");
                        exit();
                    } else if ($row['user'] != $uid) {
                        $error = "Hanya bisa mengedit komputer anda!";
                        header("Location: /warnet.ku/views/computer.php?error=$error");
                        exit();
                    }
                }
                $success = "Selesai Menggunakan Komputer";
                $uid = 0;
                $time = null;
            }

            $query = "UPDATE computers SET status = '$status', user = $uid, time = '$time' WHERE id = '$id'";
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

    function stopComputerEnd($id)
    {
        include 'ConnectionController.php';
        $time = null;
        try {
            $query = "UPDATE computers SET status = 'available', user = 0, time = '$time' WHERE id = '$id'";
            $result = mysqli_query($conn, $query);
        } catch (\Exception $e) {
        }
    }

    function stopComputer($id)
    {
        include 'ConnectionController.php';
        $time = null;
        try {
            $query = "UPDATE computers SET status = 'available', user = 0, time = '$time' WHERE id = '$id'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                $success = "Komputer Berhasil Diberhentikan!";
                header("Location: /warnet.ku/views/computer_admin.php?success=$success");
            } else {
                $error = mysqli_error($conn);
                header("Location: /warnet.ku/views/computer_admin.php?error=$error");
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
            header("Location: /warnet.ku/views/computer_admin.php?error=$error");
        }
    }
}