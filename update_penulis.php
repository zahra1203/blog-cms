<?php
// ============================================================
// STEP 2 - CRUD PENULIS
// File: update_penulis.php
// Fungsi: Memperbarui data penulis yang sudah ada
// ============================================================

header('Content-Type: application/json');
require 'koneksi.php';

// --- Ambil & validasi input ---
$id            = (int) ($_POST['id']             ?? 0);
$nama_depan    = trim($_POST['nama_depan']        ?? '');
$nama_belakang = trim($_POST['nama_belakang']     ?? '');
$user_name     = trim($_POST['user_name']         ?? '');
$password_baru = $_POST['password_baru']          ?? '';

if ($id <= 0 || !$nama_depan || !$nama_belakang || !$user_name) {
    echo json_encode(['status' => 'error', 'pesan' => 'Data tidak lengkap.']);
    exit;
}

// --- Ambil data lama untuk foto ---
$stmt_lama = $koneksi->prepare("SELECT foto FROM penulis WHERE id = ?");
$stmt_lama->bind_param('i', $id);
$stmt_lama->execute();
$lama = $stmt_lama->get_result()->fetch_assoc();
$stmt_lama->close();

if (!$lama) {
    echo json_encode(['status' => 'error', 'pesan' => 'Data penulis tidak ditemukan.']);
    exit;
}

$nama_file = $lama['foto']; // Gunakan foto lama sebagai default

// --- Proses upload foto baru (jika ada) ---
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $file  = $_FILES['foto'];
    $maks  = 2 * 1024 * 1024;

    if ($file['size'] > $maks) {
        echo json_encode(['status' => 'error', 'pesan' => 'Ukuran file maksimal 2 MB.']);
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
    $nama_file_baru = uniqid('penulis_', true) . '.' . $ekstensi;
    $tujuan    = __DIR__ . '/uploads_penulis/' . $nama_file_baru;

    if (move_uploaded_file($file['tmp_name'], $tujuan)) {
        // Hapus foto lama jika bukan default
        if ($lama['foto'] !== 'default.png') {
            $path_lama = __DIR__ . '/uploads_penulis/' . $lama['foto'];
            if (file_exists($path_lama)) unlink($path_lama);
        }
        $nama_file = $nama_file_baru;
    } else {
        echo json_encode(['status' => 'error', 'pesan' => 'Gagal menyimpan foto baru.']);
        exit;
    }
}

// --- Bangun query UPDATE (password hanya diupdate jika diisi) ---
if ($password_baru !== '') {
    $hash = password_hash($password_baru, PASSWORD_BCRYPT);
    $stmt = $koneksi->prepare(
        "UPDATE penulis SET nama_depan=?, nama_belakang=?, user_name=?, password=?, foto=? WHERE id=?"
    );
    $stmt->bind_param('sssssi', $nama_depan, $nama_belakang, $user_name, $hash, $nama_file, $id);
} else {
    $stmt = $koneksi->prepare(
        "UPDATE penulis SET nama_depan=?, nama_belakang=?, user_name=?, foto=? WHERE id=?"
    );
    $stmt->bind_param('ssssi', $nama_depan, $nama_belakang, $user_name, $nama_file, $id);
}

if ($stmt->execute()) {
    echo json_encode(['status' => 'sukses', 'pesan' => 'Data penulis berhasil diperbarui.']);
} else {
    if ($koneksi->errno === 1062) {
        echo json_encode(['status' => 'error', 'pesan' => 'Username sudah digunakan.']);
    } else {
        echo json_encode(['status' => 'error', 'pesan' => 'Gagal memperbarui data.']);
    }
}

$stmt->close();
$koneksi->close();
