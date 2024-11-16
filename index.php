<?php
$name = "-";
session_start();

if (!(isset($_SESSION['id']))) {
    header("Location: /warnet.ku/login.php");
    exit();
}

include 'connection.php';

$query = "SELECT * FROM account WHERE id = '" . $_SESSION['id'] . "'";
$result = mysqli_query($conn, $query);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
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

        nav a.account{
            background-color: #ff0000;
            color: white;
        }

        nav a.account:hover {
            background-color: #910000;
            color: white;
        }

        footer {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            background-color: #14171a;
            color: white;
        }
    </style>

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
                        <a class="nav-link active" aria-current="page" href="/warnet.ku">Home</a>
                        <a class="nav-link" href="/warnet.ku/computer.php">Komputer</a>
                    </div>
                    <div class="navbar-nav ms-auto">
                        <a class="nav-link account" href="/warnet.ku/logout.php">O <?php echo $name; ?></a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <footer>
        <p>&copy; 2024 KuroiiDev</p>
    </footer>
</body>

</html>