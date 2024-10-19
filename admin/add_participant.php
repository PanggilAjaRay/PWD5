<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $seminar_id = $_POST['seminar_id'];

    // Insert ke tabel user_seminar
    $sql = "INSERT INTO user_seminar (user_id, seminar_id) VALUES (:user_id, :seminar_id)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':seminar_id', $seminar_id);
    $stmt->execute();

    // Redirect kembali ke halaman seminar_list.php
    header("Location: dashboard.php");
    exit();
}
?>
