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

    function changeStatus($id, $status)
    {
        include 'ConnectionController.php';
        $uid = $_SESSION['id'];

        try {
            if ($status == 'unavailable') {
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

    function stopComputer($id)
    {
        include 'ConnectionController.php';

        try {
            $query = "UPDATE computers SET status = 'available', user = 0 WHERE id = '$id'";
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