<?php
session_start();
include '../config/koneksi.php'; // Menghubungkan ke database

// Cek jika id_proyek diterima
if (isset($_GET['id_proyek'])) {
    $id_proyek = intval($_GET['id_proyek']); // Mengambil id_proyek dari query string dan mengkonversinya ke integer

    // Query untuk mendapatkan anggaran dari tabel manajemen_anggaran berdasarkan id_proyek
    $sql = "SELECT anggaran FROM manajemen_anggaran WHERE id_proyek = ?";
    
    // Persiapkan statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameter
        $stmt->bind_param("i", $id_proyek);
        
        // Eksekusi statement
        $stmt->execute();
        
        // Ambil hasil
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Ambil data anggaran
            $row = $result->fetch_assoc();
            $anggaran = $row['anggaran'];
        } else {
            $anggaran = 0.00; // Jika tidak ada anggaran ditemukan
        }

        // Tutup statement
        $stmt->close();
    } else {
        // Jika query gagal
        $anggaran = 0.00;
    }

    // Kembalikan data anggaran dalam format JSON dengan dua angka desimal
    echo json_encode(number_format($anggaran, 2, '.', ''));
} else {
    // Jika id_proyek tidak diterima
    echo json_encode("0.00"); // Kembalikan 0.00 jika tidak ada id_proyek
}

$conn->close();


?>