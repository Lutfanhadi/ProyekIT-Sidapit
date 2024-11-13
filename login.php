<?php
session_start();
include 'config/koneksi.php'; // Menghubungkan ke database
$error = '';

if ($_POST) {
    $email = $_POST['email'];
    $password = sha1($_POST['password']);

    $sql = "SELECT * FROM user WHERE  email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['sudahLogin'] = true;
        $_SESSION['nama'] = $user['nama'];
     
        // Jika login berhasil, kita akan mengembalikan JSON untuk SweetAlert2
        echo json_encode(['status' => 'success', 'message' => 'Login berhasil!']);
        exit();
    } else {
        // Jika login gagal, kita akan mengembalikan JSON untuk SweetAlert2
        echo json_encode(['status' => 'error', 'message' => 'Email atau Password salah!']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIDAPIT</title>
    <link rel="icon" href="img/logo_icon.jpeg">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <div class="max-w-md mx-auto bg-white shadow-md rounded-md p-6 mt-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-5 text-center">Login</h2>
            <form id="loginForm" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-600 mb-2" for="email">Email</label>
                    <input type="text" id="email" name="email" class="w-full p-3 border rounded-md" placeholder="Masukan Email" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-600 mb-2" for="password">Password</label>
                    <input type="password" id="password" name="password" class="w-full p-3 border rounded-md" placeholder="Masukan Password" required>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-md hover:bg-blue-700">Login</button>
            </form>
            <p class="mt-4 text-gray-600">Belum punya akun? <a href="register.php" class="text-blue-500 hover:underline">Register</a></p>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').onsubmit = function(event) {
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
                        window.location.href = 'admin/admin_index.php'; // Redirect ke halaman admin
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