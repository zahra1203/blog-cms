<?php
// ============================================================
// STEP 4 - CRUD ARTIKEL
// File: update_artikel.php
// Fungsi: Memperbarui data artikel (gambar opsional diganti)
// ============================================================

header('Content-Type: application/json');
require 'koneksi.php';

$id          = (int) ($_POST['id']          ?? 0);
$judul       = trim($_POST['judul']         ?? '');
$isi         = trim($_POST['isi']           ?? '');
$id_penulis  = (int) ($_POST['id_penulis']  ?? 0);
$id_kategori = (int) ($_POST['id_kategori'] ?? 0);

if ($id <= 0 || !$judul || !$isi || $id_penulis <= 0 || $id_kategori <= 0) {
    echo json_encode(['status' => 'error', 'pesan' => 'Data tidak lengkap.']);
    exit;
}

// --- Ambil gambar lama ---
$stmt_lama = $koneksi->prepare("SELECT gambar FROM artikel WHERE id = ?");
$stmt_lama->bind_param('i', $id);
$stmt_lama->execute();
$lama = $stmt_lama->get_result()->fetch_assoc();
$stmt_lama->close();

if (!$lama) {
    echo json_encode(['status' => 'error', 'pesan' => 'Artikel tidak ditemukan.']);
    exit;
}

$nama_gambar = $lama['gambar'];

// --- Upload gambar baru (jika ada) ---
if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
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

    $ekstensi       = pathinfo($file['name'], PATHINFO_EXTENSION);
    $nama_gambar_baru = uniqid('artikel_', true) . '.' . $ekstensi;
    $tujuan         = __DIR__ . '/uploads_artikel/' . $nama_gambar_baru;

    if (move_uploaded_file($file['tmp_name'], $tujuan)) {
        // Hapus gambar lama
        $path_lama = __DIR__ . '/uploads_artikel/' . $lama['gambar'];
        if (file_exists($path_lama)) unlink($path_lama);
        $nama_gambar = $nama_gambar_baru;
    } else {
        echo json_encode(['status' => 'error', 'pesan' => 'Gagal menyimpan gambar baru.']);
        exit;
    }
}

// --- Update database ---
$stmt = $koneksi->prepare(
    "UPDATE artikel SET id_penulis=?, id_kategori=?, judul=?, isi=?, gambar=? WHERE id=?"
);
$stmt->bind_param('iisssi', $id_penulis, $id_kategori, $judul, $isi, $nama_gambar, $id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'sukses', 'pesan' => 'Artikel berhasil diperbarui.']);
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Gagal memperbarui artikel.']);
}

$stmt->close();
$koneksi->close();
