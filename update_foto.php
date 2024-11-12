<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("location:login.php");
    exit;
}

include "koneksi.php";

// Ambil data dari form
$fotoid = $_POST['fotoid'];
$judul = $_POST['judul'];
$deskripsi = $_POST['deskripsi'];
$albumid = $_POST['albumid'];

// Handle file upload (jika ada perubahan file)
$lokasifile = $_FILES['lokasifile']['name'];
$lokasifile_tmp = $_FILES['lokasifile']['tmp_name'];
$lokasifile_error = $_FILES['lokasifile']['error'];
$lokasifile_size = $_FILES['lokasifile']['size'];

// Jika ada file baru, upload dan update lokasi file
if ($lokasifile_error === UPLOAD_ERR_OK) {
    // Tentukan nama file baru
    $lokasifile_baru = uniqid() . "_" . basename($lokasifile);
    $target_dir = "gambar/" . $lokasifile_baru;

    // Pindahkan file ke folder yang sesuai
    if (move_uploaded_file($lokasifile_tmp, $target_dir)) {
        // Update query untuk mengubah data foto dan file
        $sql = "UPDATE foto SET judul='$judul', deskripsi='$deskripsi', albumid='$albumid', lokasifile='$lokasifile_baru' WHERE fotoid='$fotoid'";
    } else {
        echo "File gagal diupload.";
        exit;
    }
} else {
    // Jika tidak ada file yang diupload, hanya update judul, deskripsi, dan album
    $sql = "UPDATE foto SET judul='$judul', deskripsi='$deskripsi', albumid='$albumid' WHERE fotoid='$fotoid'";
}

// Eksekusi query update
if (mysqli_query($conn, $sql)) {
    header("Location: foto.php?status=success");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
?>
