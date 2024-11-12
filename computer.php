<?php
require_once 'ComputerManager.php';

// Create an instance of the ComputerManager class
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
            <div class="alert alert-success">Status berhasil diubah!</div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="alert alert-danger">Terjadi kesalahan saat mengubah status.</div>
        <?php endif; ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php
            foreach ($computers as $computer) {
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
                                        <img class="logo" src="computer_image.png" alt="Unavailable">
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
                                        <form action="update_status.php" method="POST">
                                            <input type="hidden" name="computer_id" value="<?= $computer['id']; ?>">
                                            <input type="hidden" name="computer_status" value="enable">
                                            <button type="submit" class="btn btn-danger btn-sm">Hentikan!</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>

    <footer class="text-center mt-5">
        <p>&copy; 2024 Manajemen Warnet Sederhana</p>
    </footer>
</body>

</html>