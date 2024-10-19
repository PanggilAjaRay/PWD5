<?php
session_start();
include '../config/db.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Ambil data peserta yang belum dihapus
$stmt = $conn->prepare("SELECT * FROM seminars WHERE is_deleted = 0");
$stmt->execute();
$seminars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Admin Dashboard - Manage Seminar</h2>
    <a href="add_seminars.php" class="btn btn-success mb-3">Tambahkan Seminar</a>
    <a href="index.php" class="btn btn-danger mb-3">Logout</a>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nama Seminar</th>
            <th>Tanggal</th>
            <th>Kapasitas</th>
            <th>Lokasi</th>
            <th>Deskripsi</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($seminars as $seminar): ?>
            <tr>
            <td><?php echo $seminar['id']; ?></td>
                <td><?php echo $seminar['nama']; ?></td>
                <td><?php echo $seminar['tanggal']; ?></td>
                <td><?php echo $seminar['kapasitas']; ?></td>
                <td><?php echo $seminar['lokasi']; ?></td>
                <td><?php echo $seminar['deskripsi']; ?></td>
                <td>

                
                    <a href="edit.php?id=<?php echo $seminar['id']; ?>" class="btn btn-warning">Edit</a> |
                    <a href="delete_seminar.php?id=<?php echo $seminar['id']; ?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>
