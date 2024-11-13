<?php
session_start();
include '../config/koneksi.php'; // Menghubungkan ke database
$error = '';

// Cek session login
if (!isset($_SESSION['sudahLogin']) || !$_SESSION['sudahLogin']) {
    header('Location: ./login.php');
    exit();
}

// Menghitung total proyek
$total_sql = "SELECT COUNT(*) as total_proyek FROM manajemen_proyek";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_proyek = $total_row['total_proyek'];

// Ambil ID proyek dari parameter GET
$id_proyek = isset($_GET['id_proyek']) ? intval($_GET['id_proyek']) : 0;

// Ambil anggaran untuk proyek yang dipilih (jika ada)
$anggaran = 0; // Default jika tidak ada anggaran
if ($id_proyek > 0) {
    // Ambil anggaran untuk proyek yang dipilih
    $sqlAnggaran = "SELECT anggaran FROM manajemen_anggaran WHERE id_proyek = ?";
    $stmtAnggaran = $conn->prepare($sqlAnggaran);
    $stmtAnggaran->bind_param("i", $id_proyek);
    $stmtAnggaran->execute();
    $resultAnggaran = $stmtAnggaran->get_result();
    if ($resultAnggaran && $rowAnggaran = $resultAnggaran->fetch_assoc()) {
        $anggaran = $rowAnggaran['anggaran'];
    }

    // Ambil tanggal mulai, tanggal selesai, status, dan progres
    $sql = "SELECT tanggal_mulai, tanggal_selesai, status, progres FROM laporan WHERE id_proyek = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_proyek);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $tanggal_mulai = $row['tanggal_mulai'];
        $tanggal_selesai = $row['tanggal_selesai'];
        $status = $row['status'];
        $progres = $row['progres'];
    } else {
        $tanggal_mulai = null;
        $tanggal_selesai = null;
        $status = null;
        $progres = null;
    }
} else {
    $tanggal_mulai = null;
    $tanggal_selesai = null;
    $status = null;
    $progres = null;
}

// Ambil anggaran untuk proyek pertama (jika ada)
$sqlAnggaran = "SELECT anggaran FROM manajemen_anggaran WHERE id_proyek = (SELECT id_proyek FROM manajemen_proyek LIMIT 1)";
$resultAnggaran = $conn->query($sqlAnggaran);
if ($resultAnggaran && $rowAnggaran = $resultAnggaran->fetch_assoc()) {
    $anggaran = $rowAnggaran['anggaran'];
} else {
    $anggaran = 0; // Default jika tidak ada anggaran
}

// Mendapatkan nama pengguna dan gambar profil
$nama = isset($_SESSION['nama']) ? $_SESSION['nama'] : 'User ';
$profile_picture = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : 'img/undraw_profile.svg';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard - SIDAPIT</title>
    <link rel="icon" href="./img/logo_icon.jpeg">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center" href="#">
                <div>
                    <img src="img/logo.png" alt="" style="width: 60px; margin-left: 6px; margin-right: 1px;">
                </div>
                <div class="sidebar-brand-text mx-1">SIDAPIT</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item active">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="page/manajemen Proyek/data.php" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Manajemen Proyek</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="page/manajemen tim/data.php" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Manajemen Tim</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="page/manajemen anggaran/data.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Manajemen Anggaran</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="page/laporan/data.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Laporan</span></a>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 fs-5"><?php echo htmlspecialchars($nama); ?></span>
                                <img class="img-profile rounded-circle" src="<?php echo htmlspecialchars($profile_picture); ?>">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../logout.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                      <a id="export-pdf" href="#" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm">Print Laporan</a>
                    </div>

                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Proyek
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $total_proyek; ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-cog fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <form action="proyek_detail.php" method="GET">
                                            <div class="form-group">
                                                <label class="small mb-1" for="id_proyek">Nama Proyek :</label>
                                                <select name="id_proyek" id="id_proyek" class="form-control" required onchange="getAnggaran(this.value); getTanggal(this.value); getAnggaran(this.value); updateExportLink(this.value);">
                                                    <option value="">-- Pilih Proyek --</option>
                                                    <?php 
                                                    $sqlProyek = "SELECT id_proyek, nama_proyek FROM manajemen_proyek";
                                                    $tampilProyek = $conn->query($sqlProyek);
                                                    while ($pecahProyek = $tampilProyek->fetch_assoc()) {
                                                        echo "<option value='{$pecahProyek['id_proyek']}'>{$pecahProyek['nama_proyek']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Jadwal
                                            </div>
                                           <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                Tanggal Mulai: <span id="tanggal-mulai">-</span>
                                            </div><br>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                Tanggal Selesai: <span id="tanggal-selesai">-</span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Anggaran Proyek
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id ="anggaran-amount">
                                                Rp.0,00
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Status dan Progres</div>
                                              <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                Status : <span id="status-progres">-</span>
                                            </div><br>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                Progres : <span id="progres-amount">-</span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                    </div>

                    <div class="row">
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a ```html
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myPieChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-primary"></i> Direct
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> Social
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-info"></i> Referral
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <footer class="sticky-footer bg-white">
                        <div class="container my-auto">
                            <div class="copyright text-center my-auto">
                                <span>Copyright &copy; SIDAPIT - 2024</span>
                            </div>
                        </div>
                    </footer>
                    <!-- End of Footer -->

                </div>
                <!-- End of Content Wrapper -->

            </div>
            <!-- End of Page Wrapper -->

            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

            <script>
                function getAnggaran(id_proyek) {
                    if (id_proyek) {
                        fetch(`get_anggaran.php?id_proyek=${id_proyek}`)
                            .then(response => response.json())
                            .then(data => {
                                // Format angka ke dalam format yang diinginkan
                                let formattedAmount = 'Rp.' + parseFloat(data).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                                document.getElementById('anggaran-amount').innerText = formattedAmount;
                            })
                            .catch(error => console.error('Error:', error));
                    } else {
                        document.getElementById('anggaran-amount').innerText = 'Rp.0,00';
                    }
                }

                function getTanggal(id_proyek) {
        if (id_proyek) {
            fetch(`get_tanggal.php?id_proyek=${id_proyek}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('tanggal-mulai').innerText = data.tanggal_mulai ? new Date(data.tanggal_mulai).toLocaleDateString('id-ID') : 'Tidak ada';
                    document.getElementById('tanggal-selesai').innerText = data.tanggal_selesai ? new Date(data.tanggal_selesai).toLocaleDateString('id-ID') : 'Tidak ada';
                    
                    // Update status dan progres
                    document.getElementById('status-progres').innerText = data.status ? data.status : 'Tidak ada';
                    document.getElementById('progres-amount').innerText = data.progres ? data.progres : 'Tidak ada';
                })
                .catch(error => console.error('Error:', error));
        } else {
            document.getElementById('tanggal-mulai').innerText = 'Tidak ada';
            document.getElementById('tanggal-selesai').innerText = 'Tidak ada';
            document.getElementById('status-progres').innerText = 'Tidak ada';
            document.getElementById('progres-amount').innerText = 'Tidak ada';
        }
    }

     function updateExportLink(selectedProjectId) {
    const exportLink = document.getElementById('export-pdf');
    if (selectedProjectId) {
        exportLink.href = 'generate_report.php?id_proyek=' + selectedProjectId;
        exportLink.classList.remove('d-none'); // Menampilkan tombol jika ada proyek yang dipilih
    } else {
        exportLink.href = '#';
        exportLink.classList.add('d-none'); // Menyembunyikan tombol jika tidak ada proyek yang dipilih
    }
}

            </script>
            <!-- Bootstrap core JavaScript-->
            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin-2.min.js"></script>

            <!-- Page level plugins -->
            <script src="vendor/chart.js/Chart.min.js"></script>

            <!-- Page level custom scripts -->
            <script src="js/demo/chart-area-demo.js"></script>
            <script src="js/demo/chart-pie-demo.js"></script>

        </body>

    </html>