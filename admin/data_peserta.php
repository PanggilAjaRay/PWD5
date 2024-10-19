<?php
session_start();
include '../config/db.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Ambil data peserta yang belum dihapus
$stmt = $conn->prepare("SELECT * FROM registration WHERE is_deleted = 0");
$stmt->execute();
$registrations = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <h2>Admin Dashboard - Manage Registrations</h2>
    <a href="add.php" class="btn btn-success mb-3">Tambahkan Peserta</a>
    <a href="../public/index.php" class="btn btn-danger mb-3">Logout</a>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Name</th>
            <th>Institution</th>
            <th>Country</th>
            <th>Address</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($registrations as $registration): ?>
            <tr>
                <td><?php echo $registration['id']; ?></td>
                <td><?php echo $registration['email']; ?></td>
                <td><?php echo $registration['nama']; ?></td>
                <td><?php echo $registration['institusi']; ?></td>
                <td><?php echo $registration['country']; ?></td>
                <td><?php echo $registration['address']; ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $registration['id']; ?>" class="btn btn-warning">Edit</a> |
                    <a href="delete.php?id=<?php echo $registration['id']; ?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>
