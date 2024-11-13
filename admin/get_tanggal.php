<?php
session_start();
include '../config/koneksi.php'; // Menghubungkan ke database

if (isset($_GET['id_proyek'])) {
    $id_proyek = $_GET['id_proyek'];

    // Query untuk mengambil tanggal mulai, tanggal selesai, status, dan progres
    $sql = "SELECT tanggal_mulai, tanggal_selesai, status, progres FROM laporan WHERE id_proyek = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_proyek);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Mengembalikan data dalam format JSON
        echo json_encode([
            'tanggal_mulai' => $row['tanggal_mulai'],
            'tanggal_selesai' => $row['tanggal_selesai'],
            'status' => $row['status'],
            'progres' => $row['progres']
        ]);
    } else {
        // Jika tidak ada data ditemukan, kembalikan null
        echo json_encode(['tanggal_mulai' => null, 'tanggal_selesai' => null, 'status' => null, 'progres' => null]);
    }

    $stmt->close();
} else {
    // Jika id_proyek tidak diberikan, kembalikan error
    echo json_encode(['error' => 'ID Proyek tidak diberikan']);
}

$conn->close();
?>