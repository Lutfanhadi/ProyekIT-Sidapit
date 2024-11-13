<?php
include 'config/koneksi.php'; // Menghubungkan ke database
$error = '';

if ($_POST) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = sha1($_POST['password']); // Menggunakan hashing SHA1 untuk password

    // Cek apakah email sudah digunakan
    $check = "SELECT * FROM user WHERE email='$email'";
    $result = mysqli_query($conn, $check);

    if (mysqli_num_rows($result) == 0) {
        $sql = "INSERT INTO user (nama, email, password) VALUES ('$nama', '$email', '$password')";
        if (mysqli_query($conn, $sql)) {
            // Jika pendaftaran berhasil
            echo json_encode(['status' => 'success', 'message' => 'Akun berhasil dibuat!']);
            exit();
        } else {
            // Jika gagal membuat akun
            echo json_encode(['status' => 'error', 'message' => 'Gagal membuat akun, coba lagi nanti!']);
            exit();
        }
    } else {
        // Jika email sudah digunakan
        echo json_encode(['status' => 'error', 'message' => 'Email sudah digunakan!']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SIDAPIT</title>
    <link rel="icon" href="img/logo_icon.jpeg">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h2 class="text-2xl font-bold text-gray-800 mb-5 text-center">Register</h2>
        <form id="registerForm" method="post">

            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama:</label>
                <input type="text" id="nama" name="nama" placeholder="Masukan Nama Lengkap" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                <input type="email" id="email" name="email" placeholder="Masukan Email" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
                <input type="password" id="password" name="password" placeholder="Masukan Password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <input type="submit" value="Register" name="regis" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-sky-600">
            <p class="mt-4 text-gray-600">Sudah punya akun? <a href="login.php" class="text-blue-500 hover:underline">Login</a></p>
        </form>
    </div>

    <script>
        document.getElementById('registerForm').onsubmit = function(event) {
            event.preventDefault(); // Mencegah form dari submit default

            // Mengambil data dari form
            var formData = new FormData(this);

            // Mengirim data ke server menggunakan fetch
            fetch('', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                                                title: 'Berhasil!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = 'login.php'; // Redirect ke halaman login
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => console.error('Error:', error));
        };
    </script>
</body>
</html>