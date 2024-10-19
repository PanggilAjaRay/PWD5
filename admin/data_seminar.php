<?php
include '../config/db.php';

$sql = "SELECT * FROM seminars WHERE is_deleted = 0";
$stmt = $conn->prepare($sql);
$stmt->execute();
$seminars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Seminar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
<h3>Data Seminar</h3>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Judul Seminar</th>
            <th>Tanggal</th>
            <th>Kapasitas</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($seminars as $seminar): ?>
            <tr>
                <td><?php echo $seminar['id']; ?></td>
                <td><?php echo $seminar['nama']; ?></td>
                <td><?php echo $seminar['tanggal']; ?></td>
                <td><?php echo $seminar['kapasitas']; ?></td>
                <td>
                    <!-- Tombol untuk membuka modal -->
                    <button class="w3-button w3-blue" onclick="document.getElementById('modal<?php echo $seminar['id']; ?>').style.display='block'">Tambah Peserta</button>
                    <button class="w3-button w3-green" onclick="openModal('viewParticipantModal-<?php echo $seminar['id']; ?>')">Detail Peserta</button>
                </td>
            </tr>

            <!-- Modal untuk menambah peserta -->
            <div id="modal<?php echo $seminar['id']; ?>" class="w3-modal">
                <div class="w3-modal-content w3-animate-zoom">
                    <div class="w3-container">
                        <span onclick="document.getElementById('modal<?php echo $seminar['id']; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                        <h5>Tambah Peserta ke Seminar "<?php echo $seminar['nama']; ?>"</h5>
                        <form action="add_participant.php" method="POST">
                            <input type="hidden" name="seminar_id" value="<?php echo $seminar['id']; ?>">
                            <div class="form-group">
                                <label for="user_id">Pilih Peserta:</label>
                                <select name="user_id" class="w3-select" required>
                                    <?php
                                    // Mengambil data peserta dari tabel registration
                                    $userStmt = $conn->prepare("SELECT * FROM registration WHERE is_deleted = 0");
                                    $userStmt->execute();
                                    $users = $userStmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($users as $user) {
                                        echo "<option value='{$user['id']}'>{$user['nama']} ({$user['email']})</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type="submit" class="w3-button w3-green">Tambah Peserta</button>
                            <button type="button" class="w3-button w3-red" onclick="document.getElementById('modal<?php echo $seminar['id']; ?>').style.display='none'">Batal</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Detail Peserta -->
            <div id="viewParticipantModal-<?php echo $seminar['id']; ?>" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('viewParticipantModal-<?php echo $seminar['id']; ?>')">&times;</span>
                    <h3>Detail Peserta Seminar: <?php echo htmlspecialchars($seminar['nama']); ?></h3>
                    <ul>
                        <?php
                        // Ambil daftar peserta dari database
                        $participant_sql = "SELECT r.nama FROM user_seminar us 
                                            JOIN registration r ON us.user_id = r.id 
                                            WHERE us.seminar_id = :seminar_id AND r.is_deleted = 0";
                        $participant_stmt = $conn->prepare($participant_sql);
                        $participant_stmt->bindParam(':seminar_id', $seminar['id'], PDO::PARAM_INT);
                        $participant_stmt->execute();
                        $participants = $participant_stmt->fetchAll(PDO::FETCH_ASSOC);
                        
                        if (count($participants) > 0) {
                            foreach ($participants as $participant):
                        ?>
                            <li><?php echo htmlspecialchars($participant['nama']); ?></li>
                        <?php
                            endforeach;
                        } else {
                            echo "<p>Tidak ada peserta yang terdaftar untuk seminar ini.</p>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Modal CSS dan Script -->
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }
    .modal-content {
        background-color: #fff;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
    }
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<script>
    function openModal(modalId) {
        document.getElementById(modalId).style.display = "block";
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = "none";
    }
</script>
</body>
</html>
