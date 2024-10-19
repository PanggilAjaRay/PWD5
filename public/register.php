<?php
session_start();
include '../config/db.php';

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $institusi = $_POST['institusi'];
    $country = $_POST['country'];
    $address = $_POST['address'];
    $password = $_POST['password'];

    // Hash password sebelum menyimpan ke database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Cek apakah email sudah ada
    $stmt = $conn->prepare("SELECT * FROM registration WHERE email = :email AND is_deleted = 0");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $error = "Email already exists!";
    } else {
        // Insert data ke tabel registration
        $sql = "INSERT INTO registration (email, nama, institusi, country, address, password) VALUES (:email, :name, :institusi, :country, :address, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':institusi', $institusi);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->execute();
$_SESSION['nama'] = $name;
        header("Location: login_peserta.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
        <h2 class="text-center mt-5">Registrasi akun</h2>
    <form method="POST">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name" required>
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
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block mt-3">Register</button>
<br>
        <a href = "login_peserta.php">Sudah memiliki akun?</a>

        <br><br>
</form>



