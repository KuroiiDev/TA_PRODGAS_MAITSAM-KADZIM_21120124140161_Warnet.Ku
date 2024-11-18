<?php
class AccountController
{
    function logout()
    {
        session_start();
        session_destroy();
        header('Location: /warnet.ku/views/login.php');
    }

    function login($user, $pass)
    {
        try{
            session_start();

            include 'ConnectionController.php';
    
            if ($user != "" || $pass != "") {
                $query = "SELECT * FROM account WHERE username  = '$user' AND password = '$pass'";
                $result = mysqli_query($conn, $query);
    
                if ($result->num_rows > 0) {
    
                    $row = $result->fetch_assoc();
    
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['id'] = $row['id'];
    
                    header('Location: /warnet.ku/views/dashboard.php');
                } else {
                    $error = "Username atau Password Salah!";
                    header("Location: /warnet.ku/views/login.php?error=$error");
                }
    
            } else {
                $error = "Tolong isi Semua Data!";
                header("Location: /warnet.ku/views/login.php?error=$error");
            }
        } catch(Exception $e){
            $error = $e->getMessage();
            header("Location: /warnet.ku/views/login.php?error=$error");
        }
    }

    function register($name, $user, $pass)
    {
        try{
            include 'ConnectionController.php';

            if ($user != "" || $name != "" || $pass != "") {
    
                $query = "INSERT INTO account (username, name, password, role) VALUES ('$user', '$name', '$pass', 'user')";
                $result = mysqli_query($conn, $query);
    
                if ($result) {
                    $success = "Registrasi akun Sukses!";
                    header("Location: /warnet.ku/views/login.php?success=$success");
                } else {
                    $error = mysqli_error($conn);
                    header("Location: /warnet.ku/views/register.php?error=$error");
                }
            } else {
                $error = "Tolong isi Semua Data!";
                header("Location: /warnet.ku/views/register.php?error=$error");
            }
        } catch(Exception $e){
            $error = $e->getMessage();
            header("Location: /warnet.ku/views/register.php?error=$error");
        }
    }
        
}
