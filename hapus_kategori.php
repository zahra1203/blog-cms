<?php
// ============================================================
// STEP 3 - CRUD KATEGORI ARTIKEL
// File: hapus_kategori.php
// Fungsi: Menghapus kategori (dicegah jika masih ada artikel)
// ============================================================

header('Content-Type: application/json');
require 'koneksi.php';

$id = (int) ($_POST['id'] ?? 0);

if ($id <= 0) {
    echo json_encode(['status' => 'error', 'pesan' => 'ID tidak valid.']);
    exit;
}

// --- Cek apakah kategori masih digunakan oleh artikel ---
$cek = $koneksi->prepare("SELECT COUNT(*) AS jumlah FROM artikel WHERE id_kategori = ?");
$cek->bind_param('i', $id);
$cek->execute();
$jumlah = $cek->get_result()->fetch_assoc()['jumlah'];
$cek->close();

if ($jumlah > 0) {
    echo json_encode([
        'status' => 'error',
        'pesan'  => 'Kategori tidak dapat dihapus karena masih digunakan oleh artikel.'
    ]);
    exit;
}

$stmt = $koneksi->prepare("DELETE FROM kategori_artikel WHERE id = ?");
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'sukses', 'pesan' => 'Kategori berhasil dihapus.']);
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Gagal menghapus kategori.']);
}

$stmt->close();
$koneksi->close();
