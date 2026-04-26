<?php
// ============================================================
// STEP 4 - CRUD ARTIKEL
// File: hapus_artikel.php
// Fungsi: Menghapus artikel + file gambar dari server
// ============================================================

header('Content-Type: application/json');
require 'koneksi.php';

$id = (int) ($_POST['id'] ?? 0);

if ($id <= 0) {
    echo json_encode(['status' => 'error', 'pesan' => 'ID tidak valid.']);
    exit;
}

// --- Ambil nama gambar sebelum dihapus ---
$stmt_gambar = $koneksi->prepare("SELECT gambar FROM artikel WHERE id = ?");
$stmt_gambar->bind_param('i', $id);
$stmt_gambar->execute();
$row = $stmt_gambar->get_result()->fetch_assoc();
$stmt_gambar->close();

// --- Hapus dari database ---
$stmt = $koneksi->prepare("DELETE FROM artikel WHERE id = ?");
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    // Hapus file gambar dari server
    if ($row && $row['gambar']) {
        $path = __DIR__ . '/uploads_artikel/' . $row['gambar'];
        if (file_exists($path)) unlink($path);
    }
    echo json_encode(['status' => 'sukses', 'pesan' => 'Artikel berhasil dihapus.']);
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Gagal menghapus artikel.']);
}

$stmt->close();
$koneksi->close();
