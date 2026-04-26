<?php
// ============================================================
// STEP 2 - CRUD PENULIS
// File: hapus_penulis.php
// Fungsi: Menghapus data penulis (dicegah jika masih punya artikel)
// ============================================================

header('Content-Type: application/json');
require 'koneksi.php';

$id = (int) ($_POST['id'] ?? 0);

if ($id <= 0) {
    echo json_encode(['status' => 'error', 'pesan' => 'ID tidak valid.']);
    exit;
}

// --- Cek apakah penulis masih memiliki artikel ---
$cek = $koneksi->prepare("SELECT COUNT(*) AS jumlah FROM artikel WHERE id_penulis = ?");
$cek->bind_param('i', $id);
$cek->execute();
$jumlah = $cek->get_result()->fetch_assoc()['jumlah'];
$cek->close();

if ($jumlah > 0) {
    echo json_encode([
        'status' => 'error',
        'pesan'  => 'Penulis tidak dapat dihapus karena masih memiliki artikel.'
    ]);
    exit;
}

// --- Ambil nama foto sebelum dihapus ---
$stmt_foto = $koneksi->prepare("SELECT foto FROM penulis WHERE id = ?");
$stmt_foto->bind_param('i', $id);
$stmt_foto->execute();
$row = $stmt_foto->get_result()->fetch_assoc();
$stmt_foto->close();

// --- Hapus data dari database ---
$stmt = $koneksi->prepare("DELETE FROM penulis WHERE id = ?");
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    // Hapus foto dari server jika bukan default
    if ($row && $row['foto'] !== 'default.png') {
        $path = __DIR__ . '/uploads_penulis/' . $row['foto'];
        if (file_exists($path)) unlink($path);
    }
    echo json_encode(['status' => 'sukses', 'pesan' => 'Data penulis berhasil dihapus.']);
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Gagal menghapus data.']);
}

$stmt->close();
$koneksi->close();
