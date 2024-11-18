<?php
session_start();

if (isset($_SESSION['id'])) {
    header('Location: /warnet.ku/views/dashboard.php');
    exit;
}
include '../controllers/ConnectionController.php';

if (isset($_POST['submit'])) {
    $user = $_POST['user'];
    $name = $_POST['name'];
    $pass = $_POST['pass'];

    if ($user != "" || $name != "" || $pass != "") {

        $query = "INSERT INTO account (username, name, password, role) VALUES ('$user', '$name', '$pass', 'user')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $success = "Registrasi Sukses!";
        } else {
            $error = mysqli_error($conn);
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
    <link rel="stylesheet" href="../css/signStyle.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h2 class="text-center">Register</h2>
                <form method="POST">
                    <div class="form-group">
                        <label for="name">Nama:</label>
                        <input type="text" class="form-control bg-dark text-light border-secondary" id="name"
                            name="name">
                    </div>
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
                        <input type="submit" name="submit" class="btn btn-success" value="Register" />
                    </div>
                    <?php if (isset($error)): ?>
                        <div
                            class="alert alert-danger alert-dismissible show d-flex justify-content-between align-items-center">
                            <span><strong>Eror!</strong><br> <?php echo $error; ?></span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php elseif (isset($success)): ?>
                        <div
                            class="alert alert-success alert-dismissible show d-flex justify-content-between align-items-center">
                            <span><strong>Sukses!</strong><br> <?php echo $success; ?></span>
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
                <p class="text-center">Sudah Punya Akun? <a href="/warnet.ku/views/login.php">Login</a></p>
            </div>
        </div>
    </div>
</body>

</html>