<?php
session_start();
include '../../../config/koneksi.php';

$id_tim = $_GET['id_tim'];
$sql = "SELECT * FROM manajemen_tim WHERE id_tim = $id_tim";
$result = $conn->query($sql);
$row = $result->fetch_assoc();



$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_tim = $_POST['id_tim'];
    $id_proyek = $_POST['id_proyek'];
    $proyek_manager = $_POST['proyek_manager'];
    $anggota_team = $_POST['anggota_team'];

    $sql = "UPDATE manajemen_tim SET id_proyek='$id_proyek', proyek_manager='$proyek_manager', anggota_team='$anggota_team' WHERE id_tim=$id_tim";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Tim berhasil diubah!']);
        exit();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan: ' . $conn->error]);
        exit();
    }
}

$tampilProyek = $conn->query("SELECT * FROM manajemen_proyek ORDER BY id_proyek") or die($conn->error);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ubah Tim - SIDAPIT</title>
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
            <li class="nav-item">
                <a class="nav-link collapsed" href="../manajemen proyek/data.php" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Manajemen Proyek</span>
                </a>
            </li>

            <!-- Nav Item - Manajemen Tim -->
            <li class="nav-item active">
                <a class="nav-link collapsed" href="#" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
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

                    <h2 class="form-title">Ubah Tim</h2>
                    <form id="ubahForm" action="ubahForm" method="post">
                        <input type="hidden" name="id_tim" value="<?php echo $row['id_tim']; ?>">
                        <div class="form-group">
                            <label class="small mb-1" for="id_proyek">Nama Proyek :</label>
                            <select name="id_proyek" id="id_proyek" class="form-control" required>
                                <option value="">-- Pilih Proyek --</option>
                                <?php
                                $sqlProyek = "SELECT id_proyek, nama_proyek FROM manajemen_proyek";
                                $tampilProyek = $conn->query($sqlProyek);
                                while ($pecahProyek = $tampilProyek->fetch_assoc()) {
                                    $selected = $row['id_proyek'] == $pecahProyek['id_proyek'] ? 'selected' : '';
                                    echo "<option value='{$pecahProyek['id_proyek']}.{$pecahProyek['nama_proyek']}' $selected>{$pecahProyek['nama_proyek']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="small mb-1" for="proyek_manager">Proyek Manager :</label>
                            <input type="text" class="form-control" id="proyek_manager" name="proyek_manager" value="<?php echo $row['proyek_manager']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="small mb-1" for="anggota_team">Anggota Tim :</label>
                            <input type="text" class="form-control" id="anggota_team" name="anggota_team" value="<?php echo $row['anggota_team']; ?>" required>
                        </div>
                        <button type="submit" name="ubah" class="btn btn-primary">Ubah</button>
                        <a href="data.php" class="btn btn-secondary">Kembali</a>
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
