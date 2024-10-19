<?php
session_start();
include '../config/db.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Ambil data berdasarkan ID
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM registration WHERE id = :id AND is_deleted = 0");
$stmt->bindParam(':id', $id);
$stmt->execute();
$registration = $stmt->fetch(PDO::FETCH_ASSOC);

// Jika data tidak ditemukan, arahkan ke dashboard
if (!$registration) {
    header("Location: dashboard.php");
    exit();
}

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $nama = $_POST['nama'];
    $institusi = $_POST['institusi'];
    $country = $_POST['country'];
    $address = $_POST['address'];

    // Cek apakah email sudah ada pada data lain
    $stmt = $conn->prepare("SELECT * FROM registration WHERE email = :email AND id != :id AND is_deleted = 0");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $error = "Email anda sudah digunakan!";
    } else {
        // Update data
        $sql = "UPDATE registration SET email = :email, nama = :nama, institusi = :institusi, country = :country, address = :address WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':institusi', $institusi);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':id', $id);
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
    <title>Edit Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Edit Registration</h2>
    <form method="POST">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" value="<?php echo $registration['email']; ?>" required>
        </div>
        <div class="form-group">
            <label for="nama">Name:</label>
            <input type="text" class="form-control" name="nama" value="<?php echo $registration['nama']; ?>" required>
        </div>
        <div class="form-group">
            <label for="institusi">Institution:</label>
            <input type="text" class="form-control" name="institusi" value="<?php echo $registration['institusi']; ?>">
        </div>
        <div class="form-group">
            <label for="country">Country:</label>
            <input type="text" class="form-control" name="country" value="<?php echo $registration['country']; ?>">
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <textarea class="form-control" name="address"><?php echo $registration['address']; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Registration</button>
    </form>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
    <?php endif; ?>
</div>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>
