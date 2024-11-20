<?php
$name = "-";
$user = "-";
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: /warnet.ku/views/login.php");
    exit();
}

include_once '../controllers/AccountController.php';
$account = new AccountController();
$user = $account->getUsername($_SESSION['id']);
$name = $account->getName($_SESSION['id']);
if (isset($_POST['logout'])) {
    $account->logout();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warnet.ku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/dashboardStyle.css">
</head>

<body class="bg-dark text-light">
    <header>
        <nav class="navbar navbar-expand-lg" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand">Warnet.Ku</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link active" aria-current="page" href="/warnet.ku/views/dashboard.php">Home</a>
                        <a class="nav-link" href="/warnet.ku/views/computer.php">Komputer</a>
                    </div>
                    <div class="navbar-nav ms-auto">
                        <form method="POST">
                            <button type="submit" class="nav-link account" name="logout">👤
                                <?php echo $user; ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <div class="container">
        <h1 class="text-center">Selamat Datang <b><?php echo $name; ?></b></h1>
    </div>
    <footer>
        <p>&copy; 2024 KuroiiDev</p>
    </footer>
</body>

</html>