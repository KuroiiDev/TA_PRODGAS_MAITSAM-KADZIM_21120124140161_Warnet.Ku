<?php
$user = "-";
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: /warnet.ku/views/login.php");
    exit();
}

include_once '../controllers/AccountController.php';
$account = new AccountController();
$account->routeAdmin('computer_admin.php');
$user = $account->getUsername($_SESSION['id']);
if (isset($_POST['logout'])) {
    $account->logout();
}

include_once '../controllers/ComputerController.php';
$com = new ComputerController();
if (isset($_POST['submit'])) {
    $com->changeStatus($_POST['computer_id'], $_POST['computer_status'], $_POST['computer_time']);
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
            }, 10000);
        </script>
        <div class="row row-cols-lg-3 g-4 computer-container">
            <!-- Diisi Pake Js -->
        </div>
    </div>

    <script>
        function loadComputers() {
            fetch('/warnet.ku/models/getComputers.php')
                .then(response => response.json())
                .then(data => {
                    const computerContainer = document.querySelector('.computer-container');
                    computerContainer.innerHTML = '';

                    if (data.length === 0) {
                        computerContainer.innerHTML = '<h3 class="m-1">Mohon maaf, belum terdapat Komputer</h3>';
                    } else {
                        data.forEach(computer => {
                            const statusColor = computer.status === 'available' ? 'success' : 'danger';
                            const statusText = computer.status === 'available' ? 'Tersedia' : 'Digunakan';

                            let actionButtons = '';
                            if (computer.status === 'available' && computer.notRenting) {
                                actionButtons = `
                                <input type="hidden" name="computer_status" value="unavailable">
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control bg-dark text-light" name="computer_time" aria-describedby="basic-addon2">
                                    <span class="input-group-text bg-dark text-light" id="basic-addon2">Menit</span>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm" name="submit">Pilih</button>
                            `;
                            } else if (computer.isCurrentUser) {
                                actionButtons = `
                                <input type="hidden" name="computer_status" value="available">
                                <button type="submit" class="btn btn-danger btn-sm" name="submit">Hentikan!</button>
                            `;
                            }

                            computerContainer.innerHTML += `
                            <div class="col">
                                <div class="card text-light computer">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <img class="logo" src="../assets/${computer.status === 'available' ? 'computer_image.png' : 'computer_image_error.png'}" alt="${statusText}">
                                            </div>
                                            <div class="col">
                                                <h5 class="card-title">${computer.name}</h5>
                                                <p class="card-text">Status: <span class="badge bg-${statusColor}">${statusText}</span></p>
                                                <form method="POST">
                                                    <input type="hidden" name="computer_id" value="${computer.id}">
                                                    ${actionButtons}
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        setInterval(loadComputers, 10000);
        loadComputers();
    </script>


    <footer class="text-center mt-5">
        <p>&copy; 2024 KuroiiDev</p>
    </footer>
</body>

</html>