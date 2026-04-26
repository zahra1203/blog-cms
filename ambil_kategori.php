<?php
// ============================================================
// STEP 3 - CRUD KATEGORI ARTIKEL
// File: ambil_kategori.php
// Fungsi: Mengambil seluruh data kategori artikel
// ============================================================

header('Content-Type: application/json');
require 'koneksi.php';

$sql    = "SELECT id, nama_kategori, keterangan FROM kategori_artikel ORDER BY nama_kategori ASC";
$result = $koneksi->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode(['status' => 'sukses', 'data' => $data]);
$koneksi->close();
