<?php
include '../../../config/koneksi.php';

if (isset($_GET['id_tim'])) {
    $id_tim = $_GET['id_tim'];

    // Query untuk menghapus data
    $sql = "DELETE FROM manajemen_tim WHERE id_tim = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_tim);

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
