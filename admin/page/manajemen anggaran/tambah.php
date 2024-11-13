<?php
session_start();
include '../../../config/koneksi.php'; // Connect to the database

// Redirect if not logged in
if (!isset($_SESSION['sudahLogin']) || !$_SESSION['sudahLogin']) {
    header('Location: ./login.php');
    exit();
}

// Variables for session info
$nama = isset($_SESSION['nama']) ? $_SESSION['nama'] : 'User';
$profile_picture = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : '../img/undraw_profile.svg';

// Initialize error message
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_proyek = $_POST['id_proyek'];
    $anggaran = $_POST['anggaran'];
 

    // SQL to insert data into management team table
    $sql = "INSERT INTO manajemen_anggaran (id_proyek, anggaran) VALUES ('$id_proyek', '$anggaran')";
   
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Anggaran berhasil ditambahkan!']);
        exit();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan: ' . $conn->error]);
        exit();
    }
}

// Fetch project data
$tampilProyek = $conn->query("SELECT * FROM manajemen_proyek ORDER BY nama_proyek") or die($conn->error);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tambah Anggaran - SIDAPIT</title>
    <link rel="icon" href="../../img/logo_icon.jpeg">
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center" href="../../admin_index.php">
                <div>
                    <img src="../../img/logo.png" alt="" style="width: 60px; margin-left: 6px; margin-right: 1px;">
                </div>
                <div class="sidebar-brand-text mx-1">SIDAPIT<sup></sup></div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item">
                <a class="nav-link" href="../../admin_index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="../manajemen Proyek/data.php">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Manajemen Proyek</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="../manajemen tim/data.php" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Manajemen Tim</span>
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Manajemen Anggaran</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../laporan/data.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Laporan</span>
                </a>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>

        <div class="container">
            <h2 class="mt-4">Tambah Anggaran</h2>
            <form id="tambahForm" method="post" class="mt-4" action="">
                <div class="form-group">
                    <label class="small mb-1" for="id_proyek">Nama Proyek :</label>
                    <select name="id_proyek" id="id_proyek" class="form-control" required>
                        <option value="">-- Pilih Proyek --</option>
                        <?php 
                        while ($pecahProyek = $tampilProyek->fetch_assoc()) {
                            echo "<option value='$pecahProyek[id_proyek].$pecahProyek[nama_proyek]'>$pecahProyek[nama_proyek]</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="small mb-1" for="anggaran">Anggaran :</label>
                    <input type="number" class="form-control" id="anggaran" name="anggaran" required min="0">
                </div>
                <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                <a href="data.php" class="btn btn-secondary">Kembali</a>
            </form>

            <script>
                document.getElementById('tambahForm').onsubmit = function(event) {
                    event.preventDefault(); // Prevent default form submission

                    var formData = new FormData(this);

                    fetch('', { // Use the correct PHP file
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
                                window.location.href = 'data.php'; // Redirect to the data page
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
        </div>

        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <script src="../../vendor/jquery/jquery.min.js"></script>
        <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="../../js/sb-admin-2.min.js"></script>
        <script src="../../vendor/chart.js/Chart.min.js"></script>
        <script src="../../js/demo/chart-area-demo.js"></script>
        <script src="../../js/demo/chart-pie-demo.js"></script>
    </div>
</body>
</html>
