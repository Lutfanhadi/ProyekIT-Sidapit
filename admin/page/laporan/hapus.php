<?php
include '../../../config/koneksi.php';

if (isset($_GET['id_laporan'])) {
    $id_laporan = $_GET['id_laporan'];

    // Query untuk menghapus data
    $sql = "DELETE FROM laporan WHERE id_laporan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_laporan);

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
