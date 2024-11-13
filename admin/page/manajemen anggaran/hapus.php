<?php
include '../../../config/koneksi.php';

if (isset($_GET['id_anggaran'])) {
    $id_anggaran = $_GET['id_anggaran'];

    // Query untuk menghapus data
    $sql = "DELETE FROM manajemen_anggaran WHERE id_anggaran = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_anggaran);

    if ($stmt->execute()) {
        // Penghapusan berhasil
        header('Location: data.php?status=success');
    } else {
        // Penghapusan gagal
        header('Location: data.php?status=error');
    }

    $stmt->close();
    $conn->close();
} else {
    header('Location: data.php');
}
