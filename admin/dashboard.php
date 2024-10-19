<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom styling for the sidebar */
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: #ffffff;
            display: block;
        }
        .sidebar a:hover {
            background-color: #007bff;
            color: #ffffff;
        }
        .content {
            margin-left: 260px;
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h4 class="text-light text-center">Admin Dashboard</h4>
    <a href="dashboard.php?page=data_peserta">Data Peserta</a>
    <a href="dashboard.php?page=seminar_detail">Data Seminar</a>
    <a href="dashboard.php?page=data_seminar">Tambah Peserta ke seminar</a>
</div>

<div class="content">
    <div class="container">
        <h2>Welcome to the Admin Dashboard</h2>
        <p>Manage data using the sidebar.</p>

        <?php
        // Check if 'page' parameter is set in URL
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            if ($page == "data_peserta") {
                include 'data_peserta.php';
            } elseif ($page == "seminar_detail") {
                include 'seminar_detail.php';
            } elseif ($page == "data_seminar") {
                include 'data_seminar.php';
            } else {
                echo "<p>Page not found.</p>";
            }
        }
        ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
