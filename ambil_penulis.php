<?php
// ============================================================
// STEP 2 - CRUD PENULIS
// File: ambil_penulis.php
// Fungsi: Mengambil seluruh data penulis dari database
// ============================================================

header('Content-Type: application/json');
require 'koneksi.php';

$sql    = "SELECT id, nama_depan, nama_belakang, user_name, password, foto FROM penulis ORDER BY id ASC";
$result = $koneksi->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode(['status' => 'sukses', 'data' => $data]);
$koneksi->close();
