<?php
session_start();
include "koneksi.php";  // Pastikan koneksi database

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['isikomentar']) && isset($_GET['fotoid'])) {
    // Ambil data dari form
    $fotoid = $_GET['fotoid'];
    $userid = $_SESSION['userid']; // ID pengguna yang login
    $isikomentar = mysqli_real_escape_string($conn, $_POST['isikomentar']);
    $tanggalkomentar = date('Y-m-d H:i:s'); // Format tanggal dan waktu

    // Query untuk menambahkan komentar ke database
    $sql = "INSERT INTO komentar (fotoid, userid, isikomentar, tanggalkomentar) 
            VALUES ('$fotoid', '$userid', '$isikomentar', '$tanggalkomentar')";

    if (mysqli_query($conn, $sql)) {
        // Redirect setelah berhasil menambah komentar
        header("Location:komentar.php?fotoid=$fotoid");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn); // Tampilkan pesan error jika query gagal
    }
} else {
    echo "Data tidak lengkap.";
}
?>
