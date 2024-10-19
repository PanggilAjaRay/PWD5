<?php
include '../config/db.php';


// Ambil seminar yang diikuti oleh peserta tersebut
$stmt = $conn->prepare("SELECT s.* FROM seminars s
                        JOIN user_seminar us ON s.id = us.seminar_id
                        WHERE us.user_id = :user_id AND s.is_deleted = 0");
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$seminars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar seminar saya</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <a href="index.php" class="btn btn-danger mb-3">Logout</a>

    <!-- List of seminars -->
    <h4>Seminars List</h4>
    <?php if (count($seminars) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Capacity</th>
                    <th>Location</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($seminars as $seminar): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($seminar['nama']); ?></td>
                        <td><?php echo htmlspecialchars($seminar['tanggal']); ?></td>
                        <td><?php echo htmlspecialchars($seminar['kapasitas']); ?></td>
                        <td><?php echo htmlspecialchars($seminar['lokasi']); ?></td>
                        <td><?php echo htmlspecialchars($seminar['deskripsi']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada seminar yang diikuti.</p>
    <?php endif; ?>
</div>
</body>
</html>
