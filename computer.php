<?php
require_once 'ComputerManager.php';

$computerManager = new ComputerManager();
$computers = $computerManager->getComputers();
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

        nav {
            text-align: center;
            background-color: #14171a;
        }

        nav a {
            text-decoration: none;
            color: white;
            background-color: #4caf50;
            padding: 10px 20px;
            margin: 5px;
            border-radius: 5px;
        }

        nav a.active {
            background-color: #456e47;
        }

        nav a:hover {
            background-color: #45a049;
        }

        footer {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            background-color: #14171a;
            color: white;
        }

        div.computer {
            background-color: #14171a;
        }

        img.logo {
            height: 100px;
        }
    </style>
</head>

<body class="bg-dark text-light">
    <header>
        <nav class="navbar navbar-expand-lg" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="/warnet.ku">Warnet.Ku</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link" href="/warnet.ku">Home</a>
                        <a class="nav-link active" aria-current="page" href="/warnet.ku/computer.php">Komputer</a>
                        <a class="nav-link disabled" aria-disabled="true">Admin</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Daftar Komputer</h1>
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible show d-flex justify-content-between align-items-center"
                role="alert">
                <span>Status berhasil diubah!</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible show d-flex justify-content-between align-items-center"
                role="alert">
                <span>Terjadi kesalahan saat mengubah status.</span>
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
            }, 3000);
        </script>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php
            foreach ($computers as $computer):
                $statusColor = $computer['status'] === 'available' ? 'success' : 'danger';
                $statusText = $computer['status'] === 'available' ? 'Tersedia' : 'Digunakan';
                ?>
                <div class="col">
                    <div class="card text-light computer">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <?php if ($computer['status'] == 'available'): ?>
                                        <img class="logo" src="computer_image.png" alt="Available">
                                    <?php else: ?>
                                        <img class="logo" src="computer_image_error.png" alt="Unavailable">
                                    <?php endif; ?>
                                </div>
                                <div class="col">
                                    <h5 class="card-title"><?= $computer['name']; ?></h5>
                                    <p class="card-text">Status: <span
                                            class="badge bg-<?= $statusColor; ?>"><?= $statusText; ?></span></p>
                                    <?php if ($computer['status'] === 'available'): ?>
                                        <form action="update_status.php" method="POST">
                                            <input type="hidden" name="computer_id" value="<?= $computer['id']; ?>">
                                            <input type="hidden" name="computer_status" value="disable">
                                            <button type="submit" class="btn btn-primary btn-sm">Pilih</button>
                                        </form>
                                    <?php else: ?>
                                        <form action="update_status.php" method="POST" id="stop-form-<?= $computer['id']; ?>">
                                            <input type="hidden" name="computer_id" value="<?= $computer['id']; ?>">
                                            <input type="hidden" name="computer_status" value="enable">
                                            <button type="submit" class="btn btn-danger btn-sm">Hentikan!</button>
                                        </form>
<!-- 
                                        <p id="timer-<?= $computer['id']; ?>" class="text-danger mt-2"></p>
                                        <script>
                                            let timer<?= $computer['id']; ?> = 5;
                                            const timerElement<?= $computer['id']; ?> = document.getElementById('timer-<?= $computer['id']; ?>');

                                            const countdown<?= $computer['id']; ?> = setInterval(() => {
                                                if (timer<?= $computer['id']; ?> <= 0) {
                                                    clearInterval(countdown<?= $computer['id']; ?>);
                                                    document.getElementById('stop-form-<?= $computer['id']; ?>').submit();
                                                } else {
                                                    timer<?= $computer['id']; ?>--;
                                                    timerElement<?= $computer['id']; ?>.textContent = `Waktu: ${timer<?= $computer['id']; ?>} detik`;
                                                }
                                            }, 1000);
                                        </script> -->

                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer class="text-center mt-5">
        <p>&copy; 2024 KuroiiDev</p>
    </footer>
</body>

</html>