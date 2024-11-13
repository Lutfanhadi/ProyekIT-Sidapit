<?php
session_start();
include '../../../config/koneksi.php'; // Menghubungkan ke database
$error = '';

$sql = "SELECT * FROM manajemen_proyek";
$result = $conn->query($sql);

if (!isset($_SESSION['sudahLogin']) || !$_SESSION['sudahLogin']) {
    header('Location: ./login.php');
    exit();
}
if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
    session_destroy();
    header("Location: data.php");
    exit();
}

$nama = isset($_SESSION['nama']) ? $_SESSION['nama'] : 'User';
$profile_picture = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : '../img/undraw_profile.svg';



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manajemen Proyek - SIDAPIT</title>
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

    <style>
        .table td, .table th {
            text-align: center; 
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
                <a class="nav-link" href="../manajemen tim/data.php">
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

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
    
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                           <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 fs-5"><?php echo htmlspecialchars($nama); ?></span> 
                                <img class="img-profile rounded-circle" src="../../<?php echo $profile_picture; ?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="../../profile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../../../logout.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Manajemen Proyek</h1>
                    <p class="mb-4">Tampilan ini menyajikan data proyek secara rinci dan terstruktur, memungkinkan anda dengan mudah menambah dan mengubah perkembangan setiap tahap proyek.</p>
                    <div class="col-md-12">
                        <a href="tambah.php" class="btn btn-primary mb-3 mr-2"><i class="fa fa-plus"></i> Tambah Proyek</a>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Manajemen Proyek</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Proyek</th>
                                            <th>Pelanggan</th>
                                            <th>Tanggal mulai</th>
                                            <th>Tanggal selesai</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($result->num_rows > 0) {
                                            $index = 1;
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . $index . "</td>";
                                                echo "<td>" . $row["nama_proyek"] . "</td>";
                                                echo "<td>" . $row["pelanggan"] . "</td>";
                                                echo "<td>" . $row["tanggal_mulai"] . "</td>";
                                                echo "<td>" . $row["tanggal_selesai"] . "</td>";
                                                echo '<td>
                                                        <a href="ubah.php?id_proyek=' . $row["id_proyek"] . '"><i class="fa fa-edit"></i></a>
                                                        <a href="#" onclick="confirmDeletion(' . $row["id_proyek"] . ')" ><i class="fa fa-trash"></i></a>
                                                      </td>'; 
                                                echo "</tr>";
                                                $index++;
                                            }
                                        } else {
                                            echo "<tr><td colspan='7'>No data available</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
             <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; SIDAPIT - 2024</span>
                    </div>
                </div>
            </footer>
            <!-- ... (footer code) ... -->

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

    <!-- Page level plugins -->
    <script src="../../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "paging": true,
                "ordering": true,
                "info": true
            });
        });

        function confirmDeletion(id_proyek) {
            Swal.fire({
                title: "Apakah anda yakin ingin menghapus data ini?",
                text: "Data ini akan dihapus dan tidak bisa dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Iya",
                cancelButtonText: "Tidak"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika tombol "Yes" diklik, arahkan ke halaman hapus dengan parameter id_proyek
                    window.location.href = 'hapus.php?id_proyek=' + id_proyek;
                }
            });
        }
    </script>
</body>

</html>
