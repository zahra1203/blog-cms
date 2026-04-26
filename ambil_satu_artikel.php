<?php
// ============================================================
// STEP 4 - CRUD ARTIKEL
// File: ambil_satu_artikel.php
// Fungsi: Mengambil satu data artikel berdasarkan ID (untuk form edit)
// ============================================================

header('Content-Type: application/json');
require 'koneksi.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    echo json_encode(['status' => 'error', 'pesan' => 'ID tidak valid.']);
    exit;
}

$stmt = $koneksi->prepare(
    "SELECT id, judul, isi, gambar, hari_tanggal, id_penulis, id_kategori FROM artikel WHERE id = ?"
);
$stmt->bind_param('i', $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if ($data) {
    echo json_encode(['status' => 'sukses', 'data' => $data]);
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Data artikel tidak ditemukan.']);
}

$stmt->close();
$koneksi->close();
