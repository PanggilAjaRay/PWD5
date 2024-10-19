<?php
session_start();
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query untuk mendapatkan data berdasarkan email
    $stmt = $conn->prepare("SELECT * FROM registration WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC); // Mengambil data user

    // Verifikasi password dan cek apakah email ditemukan
    if ($user && password_verify($password, $user['password'])) {
        // Simpan data ke dalam session
        $_SESSION['email'] = $user['email'];
        $_SESSION['name'] = $user['nama']; // Ambil nilai 'nama' dari database dan simpan di session

        // Redirect ke dashboard peserta
        header("Location: dashboard_peserta.php");
        exit;
    } else {
        $error = "Email dan password anda salah!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Peserta</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mt-5">Login Peserta</h2>
            <form method="POST" class="mt-4">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block mt-3">Login</button>
                <br>
                <a href = "register.php">Belum memiliki akun?</a>
            </form>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>