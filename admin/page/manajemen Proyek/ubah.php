<?php
session_start();
include '../../../config/koneksi.php'; 

$id_proyek = $_GET['id_proyek'];
$sql = "SELECT * FROM manajemen_proyek WHERE id_proyek = $id_proyek";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$error = '';
if ($_POST) {
    $id_proyek = $_POST['id_proyek'];
    $nama_proyek = $_POST['nama_proyek'];
    $pelanggan = $_POST['pelanggan'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];

    $sql = "UPDATE manajemen_proyek SET nama_proyek='$nama_proyek', pelanggan='$pelanggan', tanggal_mulai='$tanggal_mulai', tanggal_selesai='$tanggal_selesai' WHERE id_proyek=$id_proyek";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Proyek berhasil diubah!']);
        exit();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan: ' . $conn->error]);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ubah Proyek - SIDAPIT</title>
    <link rel="icon" href="../../img/logo_icon.jpeg">

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom styles for the form -->
    <style>
        .form-container {
            margin-top: 20px;
        }
        .form-title {
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: bold;
        }
        .btn-container {
            margin-top: 20px;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center" href="../../admin_index.php">
                <div>
                    <img src="../../img/logo.png" alt="" style="width: 60px; margin-left: 6px; margin-right: 1px;">
                </div>
                <div class="sidebar-brand-text mx-1">SIDAPIT<sup></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="../../admin_index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Nav Item - Manajemen Proyek -->
            <li class="nav-item active">
                <a class="nav-link collapsed" href="data.php" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Manajemen Proyek</span>
                </a>
            </li>

            <!-- Nav Item - Manajemen Tim -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="../manajemen tim/data.php" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Manajemen Tim</span>
                </a>
            </li>

            <!-- Nav Item - Manajemen Anggaran -->
            <li class="nav-item">
                <a class="nav-link" href="../manajemen anggaran/data.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Manajemen Anggaran</span></a>
            </li>

            <!-- Nav Item - Laporan -->
            <li class="nav-item">
                <a class="nav-link" href="../laporan/data.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Laporan</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid form-container">

                    <h2 class="form-title">Ubah Proyek</h2>
                    <form id="ubahForm" action="ubahForm" method="post">
                        <input type="hidden" name="id_proyek" value="<?php echo $row['id_proyek']; ?>">
                        <div class="form-group">
                            <label for="nama_proyek">Nama Proyek:</label>
                            <input type="text" class="form-control" id="nama_proyek" name="nama_proyek" value="<?php echo $row['nama_proyek']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="pelanggan">Pelanggan:</label>
                            <input type="text" class="form-control" id="pelanggan" name="pelanggan" value="<?php echo $row['pelanggan']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_mulai">Tanggal Mulai:</label>
                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?php echo $row['tanggal_mulai']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_selesai">Tanggal Selesai:</label>
                            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="<?php echo $row['tanggal_selesai']; ?>">
                        </div>
                        <div class="btn-container">
                            <button type="submit" name="ubah" class="btn btn-primary">Ubah</button>
                            <a href="data.php" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin-2.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    document.getElementById('ubahForm').onsubmit = function(event) {
        event.preventDefault(); // Prevent the form from submitting the default way

        // Get form data
        var formData = new FormData(this);

        // Send data to the server using fetch
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

</body>

</html>
