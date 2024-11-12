<?php
include "koneksi.php";
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

// Pastikan Anda menggunakan teknik yang aman untuk menangani password, seperti hashing
// $password = md5($password); // Contoh hashing (jangan gunakan md5 di produksi, lebih baik gunakan password_hash() dan password_verify())

$sql = mysqli_query($conn, "SELECT * FROM user WHERE username='$username' AND password='$password'");

$cek = mysqli_num_rows($sql);

if ($cek == 1) {
    while ($data = mysqli_fetch_array($sql)) {
        // Simpan data yang diperlukan di sesi
        $_SESSION['userid'] = $data['userid'];
        $_SESSION['namalengkap'] = $data['namalengkap'];
        $_SESSION['role'] = $data['role'];  // Simpan role pengguna, misalnya 'admin' atau 'user'
    }

    // Redirect ke halaman utama atau halaman sesuai role
    if ($_SESSION['role'] == 'admin') {
        header("location: index.php"); // Halaman admin
    } else {
        header("location: index.php"); // Halaman untuk pengguna biasa
    }
} else {
    // Jika username atau password tidak cocok
    header("location: login.php?error=1");
}
?>
