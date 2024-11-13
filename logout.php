<?php
session_start();
if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - SIDAPIT</title>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
   <script>
        Swal.fire({
            title: "Apakah anda yakin ingin keluar?",
            text: "Keluar dari halaman admin!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika tombol "Yes" diklik, arahkan ke halaman logout dengan parameter confirm=yes
                window.location.href = '?confirm=yes';
            } else {
                // Jika tombol "Cancel" diklik, tetap di halaman admin_index.php
                window.location.href = 'admin/admin_index.php';
            }
        });
    </script>
</body>
</html>


