<?php
$user = "-";
session_start();

if (!(isset($_SESSION['id']))) {
    header("Location: /warnet.ku/views/login.php");
    exit();
}

include_once '../controllers/AccountController.php';
$account = new AccountController();
$account->routeUser('computer.php');
$user = $account->getUsername();
if (isset($_POST['logout'])) {
    $account->logout();
}

include '../controllers/ComputerController.php';
$com = new ComputerController();
$computers = $com->getComputers();
if (isset($_POST['submit-add'])) {
    $com->addComputer($_POST['computer_name']);
}
if (isset($_POST['submit-del'])) {
    $com->deleteComputer($_POST['computer_id']);
}
if (isset($_POST['submit-stop'])) {
    $com->stopComputer($_POST['computer_id']);
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
    <link rel="stylesheet" href="../css/computerStyle.css">
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
                        <a class="nav-link" href="/warnet.ku/views/dashboard.php">Home</a>
                        <a class="nav-link active" aria-current="page" href="/warnet.ku/views/computer.php">Komputer</a>
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

    <div class="container mt-5">
        <h1 class="text-center mb-4">Daftar Komputer</h1>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible show d-flex justify-content-between align-items-center">
                <span><strong>Eror!</strong><br> <?php echo $_GET['error']; ?></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible show d-flex justify-content-between align-items-center">
                <span><strong>Sukses!</strong><br> <?php echo $_GET['success']; ?></span>
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
            }, 5000);
        </script>
        <div class="row row-cols-lg-3 g-4">
            <?php if (!isset($computers)): ?>
                <h3 class="m-1">Mohon masukan Komputer!</h3>
            <?php else:
                foreach ($computers as $computer):
                    $statusColor = $computer['status'] === 'available' ? 'success' : 'danger';
                    $statusText = $computer['status'] === 'available' ? 'Tersedia' : 'Digunakan';
                    ?>
                    <div class="col">
                        <div class="card text-light computer">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <?php switch ($computer['status']):
                                            case 'available': ?>
                                                <img class="logo" src="../assets/computer_image.png" alt="Available">
                                                <?php break;
                                            default: ?>
                                                <img class="logo" src="../assets/computer_image_error.png" alt="Unavailable">
                                                <?php break;
                                        endswitch; ?>
                                    </div>
                                    <div class="col">
                                        <h5 class="card-title"><?= $computer['name']; ?></h5>
                                        <p class="card-text">Status: <span
                                                class="badge bg-<?= $statusColor; ?>"><?= $statusText; ?></span></p>
                                        <?php if ($computer['status'] == 'available'): ?>
                                            <form method="POST">
                                                <input type="hidden" name="computer_id" value="<?= $computer['id']; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm" name="submit-del">Hapus</button>
                                            </form>
                                        <?php else: ?>
                                            <form method="POST" id="stop-form-<?= $computer['id']; ?>">
                                                <input type="hidden" name="computer_id" value="<?= $computer['id']; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    name="submit-stop">Hentikan!</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                endforeach;
            endif;
            ?>
            <div class="col">
                <div class="card text-light computer">
                    <div class="card-body">
                        <form method="POST">
                            <h5 class="card-title text-center">Add Computer</h5>
                            <div class="row justify-content-center">
                                <div class="col">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="name">Computer Name:</label>
                                            <input type="text"
                                                class="form-control bg-dark text-light border-secondary m-1"
                                                name="computer_name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-primary m-2" name="submit-add">+</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center mt-5">
        <p>&copy; 2024 KuroiiDev</p>
    </footer>
</body>

</html>