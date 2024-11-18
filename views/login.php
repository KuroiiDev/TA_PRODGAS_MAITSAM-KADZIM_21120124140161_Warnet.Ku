<?php
session_start();

if (isset($_SESSION['id'])) {
    header('Location: /warnet.ku/views/dashboard.php');
    exit;
}
include '../controller/ConnectionController.php';

if (isset($_POST['submit'])) {

    $user = $_POST['user'];
    $pass = $_POST['pass'];

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
        }

    } else {
        $error = "Tolong isi Semua Data!";
    } 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warnet.Ku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1F1F1F;
        }

        .container {
            max-width: 400px;
            margin-top: 100px;
            padding: 20px;
            background-color: #14171a;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
        }

        h2 {
            color: white;
        }

        label {
            color: #bdbdbd;
        }

        p {
            color: #bdbdbd;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            height: 40px;
            padding: 10px;
            font-size: 16px;
        }

        .btn-success {
            padding: 10px 20px;
            font-size: 16px;
        }

        .btn-success:hover {
            background-color: #23527c;
        }

        .text-center {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h2 class="text-center">Login</h2>
                <form method="POST">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control bg-dark text-light border-secondary" id="username"
                            name="user">
                    </div>
                    <div class="form-group">
                        <label for="password" class="text-light">Password:</label>
                        <input type="password" class="form-control bg-dark text-light border-secondary" id="password"
                            name="pass">
                    </div>

                    <div class="text-center">
                        <input type="submit" name="submit" class="btn btn-success" value="Login" />
                    </div>
                    <?php if (isset($error)): ?>
                        <div
                            class="alert alert-danger alert-dismissible show d-flex justify-content-between align-items-center">
                            <span><strong>Eror!</strong><br> <?php echo $error; ?></span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <script>
                        setTimeout(function () {
                            const alerts = document.querySelectorAll('.alert');
                            alerts.forEach(alert => {
                                alert.classList.remove('show');
                                alert.classList.add('fade');
                                setTimeout(() => alert.remove(), 500);
                            });
                        }, 6000);
                    </script>
                </form>
                <p class="text-center">Tidak Punya Akun? <a href="/warnet.ku/views/register.php">Register</a></p>
            </div>
        </div>
    </div>
</body>

</html>