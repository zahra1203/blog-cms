<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

$conn = mysqli_connect("localhost", "root", "", "db_blog");
if (!$conn) {
    echo json_encode(["status"=>"error","pesan"=>"Koneksi gagal: ".mysqli_connect_error()]);
    exit;
}

$nama_depan    = $_POST['nama_depan'] ?? '';
$nama_belakang = $_POST['nama_belakang'] ?? '';
$username      = $_POST['user_name'] ?? '';
$password      = $_POST['password'] ?? '';

if ($nama_depan=='' || $nama_belakang=='' || $username=='' || $password=='') {
    echo json_encode(["status"=>"error","pesan"=>"Semua field wajib diisi!"]);
    exit;
}

$nama_foto = "default.png";

if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $nama_foto = uniqid("foto_") . "." . $ext;

    move_uploaded_file($_FILES['foto']['tmp_name'], "uploads_penulis/" . $nama_foto);
}

$sql = "INSERT INTO penulis (nama_depan, nama_belakang, user_name, password, foto)
        VALUES ('$nama_depan', '$nama_belakang', '$username', '$password', '$nama_foto')";

$query = mysqli_query($conn, $sql);

if ($query) {
    echo json_encode(["status"=>"sukses","pesan"=>"Berhasil disimpan"]);
} else {
    echo json_encode(["status"=>"error","pesan"=>"Gagal simpan: " . mysqli_error($conn)]);
}
?>