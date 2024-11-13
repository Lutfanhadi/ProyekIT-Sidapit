<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['sudahLogin']) || !$_SESSION['sudahLogin']) {
    header('Location: ./login.php');
    exit();
}

$nama = isset($_SESSION['nama']) ? $_SESSION['nama'] : 'User';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $profile_picture = $_FILES['profile_picture'];
    $upload_dir = 'img/';

    // Check if no file is selected
    if (empty($profile_picture['name'])) {
        $error = "Tidak ada berkas yang dipilih.";
    } else {
        // Ensure the upload directory exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Sanitize the file name to prevent directory traversal attacks
        $upload_file = $upload_dir . basename(preg_replace("/[^a-zA-Z0-9\._-]/", "", $profile_picture['name']));

        // Check if the file is a valid image
        $check = getimagesize($profile_picture['tmp_name']);
        if ($check === false) {
            $error = "File bukan gambar.";
        } else {
            // Validate file size (max 5MB)
            if ($profile_picture['size'] > 5000000) {
                $error = "Maaf, file Anda terlalu besar.";
            } else {
                if (move_uploaded_file($profile_picture['tmp_name'], $upload_file)) {
                    // Update user profile picture in the database
                    $stmt = $conn->prepare("UPDATE user SET profile_picture = ? WHERE id_user = ?");
                    if ($stmt) {
                        $stmt->bind_param('si', $upload_file, $_SESSION['user_id']);
                        if ($stmt->execute()) {
                            // Update session with the new profile picture path
                            $_SESSION['profile_picture'] = $upload_file;
                            echo "<script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        Swal.fire({
                                            title: 'Berhasil!',
                                            text: 'Gambar profil berhasil diperbarui.',
                                            icon: 'success'
                                        }).then(function() {
                                            window.location = 'admin_index.php';
                                        });
                                    });
                                  </script>";
                        } else {
                            $error = "Kesalahan saat menjalankan pernyataan SQL.";
                        }
                        $stmt->close();
                    } else {
                        $error = "Terjadi kesalahan saat menyiapkan pernyataan SQL.";
                    }
                } else {
                    $error = "Maaf, terjadi kesalahan saat mengunggah file Anda.";
                }
            }
        }
    }

    if ($error) {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Gagal!',
                        text: '" . addslashes($error) . "',
                        icon: 'error'
                    });
                });
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta and Title -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Update - SIDAPIT</title>
    <link rel="icon" href="./img/logo_icon.jpeg">
    <!-- CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body id="page-top">
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <!-- Navbar -->
            </nav>
            <div class="container-fluid">
                <h1 class="h3 mb-4 text-gray-800">Profile</h1>
                <form action="profile.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="profile_picture">Profile Picture</label>
                        <input type="file" name="profile_picture" id="profile_picture" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='admin_index.php'">Cancel</button>
                </form>
            </div>
        </div>
        <footer class="sticky-footer bg-white">
            <!-- Footer -->
        </footer>
    </div>
    <!-- JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
