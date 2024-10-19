<?php
session_start();
include('../config/db.php'); // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $seminar_id = $_POST['seminar_id'];
    $user_id = $_POST['user_id'];

    // Check if the user is already registered for the seminar
    $check_sql = "SELECT * FROM user_seminar WHERE seminar_id = :seminar_id AND user_id = :user_id";
    $stmt = $conn->prepare($check_sql);
    $stmt->bindParam(':seminar_id', $seminar_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    
    if ($stmt->rowCount() == 0) {
        // Insert into user_seminar table
        $sql = "INSERT INTO user_seminar (seminar_id, user_id) VALUES (:seminar_id, :user_id)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':seminar_id', $seminar_id);
        $stmt->bindParam(':user_id', $user_id);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Peserta berhasil ditambahkan ke seminar.";
        } else {
            $_SESSION['message'] = "Gagal menambahkan peserta.";
        }
    } else {
        $_SESSION['message'] = "Peserta sudah terdaftar di seminar ini.";
    }
    
    header("Location: ../admin/dashboard.php?page=data_seminar");
    exit();
}
?>
