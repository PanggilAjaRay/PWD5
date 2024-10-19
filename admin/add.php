<?php
session_start();
include '../config/db.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $nama = $_POST['nama'];
    $institusi = $_POST['institusi'];
    $country = $_POST['country'];
    $address = $_POST['address'];

    // Cek apakah email sudah ada
    $stmt = $conn->prepare("SELECT * FROM registration WHERE email = :email AND is_deleted = 0");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $error = "Email already exists!";
    } else {
        // Insert data
        $sql = "INSERT INTO registration (email, nama, institusi, country, address) VALUES (:email, :nama, :institusi, :country, :address)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':institusi', $institusi);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':address', $address);
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
    <title>Tambah Peserta</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Tambahkan Peserta</h2>
    <form method="POST">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="form-group">
            <label for="nama">Name:</label>
            <input type="text" class="form-control" name="nama" required>
        </div>
        <div class="form-group">
            <label for="institusi">Institution:</label>
            <input type="text" class="form-control" name="institusi">
        </div>
        <div class="form-group">
            <label for="country">Country:</label>
            <input type="text" class="form-control" name="country">
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <textarea class="form-control" name="address"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Tambah</button>
        <button a href = "dashboard.php" class="btn btn-danger">Cancel</button>
    </form>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
    <?php endif; ?>
</div>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>
