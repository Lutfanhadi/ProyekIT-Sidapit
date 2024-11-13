<?php
include '../../../config/koneksi.php';

if (isset($_GET['id_proyek'])) {
    $id_proyek = $_GET['id_proyek'];

    // Query untuk menghapus data
    $sql = "DELETE FROM manajemen_proyek WHERE id_proyek = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_proyek);

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
