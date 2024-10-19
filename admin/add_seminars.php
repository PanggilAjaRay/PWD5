<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $tanggal = $_POST['tanggal'];
    $kapasitas = $_POST['kapasitas'];
    $lokasi = $_POST['lokasi'];
    $deskripsi = $_POST['deskripsi'];

    // Cek apakah email sudah ada
    $stmt = $conn->prepare("SELECT * FROM seminars WHERE nama = :nama AND is_deleted = 0");
    $stmt->bindParam(':nama', $nama);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $error = "Nama already exists!";
    } else {
        // Insert data
        $sql = "INSERT INTO seminars (nama, tanggal, kapasitas, lokasi, deskripsi) VALUES (:nama, :tanggal, :kapasitas, :lokasi, :deskripsi)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':tanggal', $tanggal);
        $stmt->bindParam(':kapasitas', $kapasitas);
        $stmt->bindParam(':lokasi', $lokasi);
        $stmt->bindParam(':deskripsi', $deskripsi);
        $stmt->execute();

        header("Location: dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Seminar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
<h2>Tambahkan Seminar</h2>
<form method="POST" class="mb-4">
        <div class="form-group">
            <label for="nama">Name:</label>
            <input type="text" class="form-control" name="nama" required>
        </div>
        <div class="form-group">
            <label for="tanggal">Date:</label>
            <input type="date" class="form-control" name="tanggal" required>
        </div>
        <div class="form-group">
            <label for="kapasitas">Capacity:</label>
            <input type="number" class="form-control" name="kapasitas" required>
        </div>
        <div class="form-group">
            <label for="lokasi">Location:</label>
            <input type="text" class="form-control" name="lokasi" required>
        </div>
        <div class="form-group">
            <label for="deskripsi">Description:</label>
            <textarea class="form-control" name="deskripsi"></textarea>
        </div>
        <button type="submit" name="add_seminars" class="btn btn-primary">Add Seminar</button>
    </form>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
    <?php endif; ?>
</div>
</body>
</html>