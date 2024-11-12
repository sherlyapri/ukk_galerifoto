<?php
include "koneksi.php";
session_start();

// Mengecek apakah user sudah login
if (!isset($_SESSION['userid'])) {
    header("location: login.php");
    exit;
}

// Mengambil data dari form
$namaalbum = mysqli_real_escape_string($conn, $_POST['namaalbum']);
$deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
$tanggaldibuat = date("Y-m-d");
$userid = $_SESSION['userid'];

// Validasi input
if (empty($namaalbum) || empty($deskripsi)) {
    $_SESSION['error_message'] = "Nama album dan deskripsi tidak boleh kosong!";
    header("location: album.php");
    exit;
}

// Menyusun query SQL untuk menambahkan album
$sql = "INSERT INTO album (namaalbum, deskripsi, tanggal, userid) VALUES ('$namaalbum', '$deskripsi', '$tanggaldibuat', '$userid')";

// Menjalankan query dan memeriksa apakah berhasil
if (mysqli_query($conn, $sql)) {
    $_SESSION['success_message'] = "Album berhasil ditambahkan!";
} else {
    // Menampilkan error jika query gagal
    $_SESSION['error_message'] = "Gagal menambahkan album: " . mysqli_error($conn);
}

header("location: album.php");
exit;
?>
