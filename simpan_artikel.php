<?php
// ============================================================
// STEP 4 - CRUD ARTIKEL
// File: simpan_artikel.php
// Fungsi: Menyimpan artikel baru ke database + upload gambar
// ============================================================

header('Content-Type: application/json');
require 'koneksi.php';

// --- Ambil & validasi input ---
$judul       = trim($_POST['judul']       ?? '');
$isi         = trim($_POST['isi']         ?? '');
$id_penulis  = (int) ($_POST['id_penulis']  ?? 0);
$id_kategori = (int) ($_POST['id_kategori'] ?? 0);

if (!$judul || !$isi || $id_penulis <= 0 || $id_kategori <= 0) {
    echo json_encode(['status' => 'error', 'pesan' => 'Semua field wajib diisi.']);
    exit;
}

// --- Upload gambar (wajib) ---
if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['status' => 'error', 'pesan' => 'Gambar artikel wajib diunggah.']);
    exit;
}

$file  = $_FILES['gambar'];
$maks  = 2 * 1024 * 1024;

if ($file['size'] > $maks) {
    echo json_encode(['status' => 'error', 'pesan' => 'Ukuran gambar maksimal 2 MB.']);
    exit;
}

$finfo     = new finfo(FILEINFO_MIME_TYPE);
$mime      = $finfo->file($file['tmp_name']);
$tipe_izin = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

if (!in_array($mime, $tipe_izin)) {
    echo json_encode(['status' => 'error', 'pesan' => 'Tipe file tidak diizinkan.']);
    exit;
}

$ekstensi  = pathinfo($file['name'], PATHINFO_EXTENSION);
$nama_file = uniqid('artikel_', true) . '.' . $ekstensi;
$tujuan    = __DIR__ . '/uploads_artikel/' . $nama_file;

if (!move_uploaded_file($file['tmp_name'], $tujuan)) {
    echo json_encode(['status' => 'error', 'pesan' => 'Gagal menyimpan gambar.']);
    exit;
}

// --- Generate hari_tanggal dari server (timezone Asia/Jakarta) ---
date_default_timezone_set('Asia/Jakarta');
$hari   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
$bulan  = [
    1=>'Januari',  2=>'Februari', 3=>'Maret',
    4=>'April',    5=>'Mei',      6=>'Juni',
    7=>'Juli',     8=>'Agustus',  9=>'September',
    10=>'Oktober', 11=>'November',12=>'Desember'
];
$sekarang    = new DateTime();
$nama_hari   = $hari[$sekarang->format('w')];
$tanggal     = $sekarang->format('j');
$nama_bulan  = $bulan[(int) $sekarang->format('n')];
$tahun       = $sekarang->format('Y');
$jam         = $sekarang->format('H:i');
$hari_tanggal = "$nama_hari, $tanggal $nama_bulan $tahun | $jam";

// --- Simpan ke database ---
$stmt = $koneksi->prepare(
    "INSERT INTO artikel (id_penulis, id_kategori, judul, isi, gambar, hari_tanggal) VALUES (?, ?, ?, ?, ?, ?)"
);
$stmt->bind_param('iissss', $id_penulis, $id_kategori, $judul, $isi, $nama_file, $hari_tanggal);

if ($stmt->execute()) {
    echo json_encode(['status' => 'sukses', 'pesan' => 'Artikel berhasil disimpan.']);
} else {
    // Hapus gambar yang sudah terlanjur diupload
    if (file_exists($tujuan)) unlink($tujuan);
    echo json_encode(['status' => 'error', 'pesan' => 'Gagal menyimpan artikel.']);
}

$stmt->close();
$koneksi->close();
