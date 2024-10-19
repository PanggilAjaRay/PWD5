<?php
session_start();
include '../config/db.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Ambil ID
$id = $_GET['id'];

// Soft delete (ubah is_deleted menjadi 1)
$stmt = $conn->prepare("UPDATE registration SET is_deleted = 1 WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();

// Arahkan kembali ke dashboard setelah menghapus
header("Location: dashboard.php");
exit();
?>
