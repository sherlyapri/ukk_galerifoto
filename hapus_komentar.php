<?php
include "koneksi.php";
session_start();

// Pastikan ada session dan komentarid
if (isset($_SESSION['userid']) && isset($_GET['komentarid'])) {
    $komentarid = $_GET['komentarid'];
    $userid = $_SESSION['userid'];

    // Cek apakah pengguna adalah admin atau pemilik komentar
    // Query untuk mendapatkan komentar berdasarkan komentarid
    $sql = mysqli_query($conn, "SELECT * FROM komentar WHERE komentarid='$komentarid'");
    $data = mysqli_fetch_array($sql);

    if ($data) {
        // Cek apakah user yang login adalah admin atau pemilik komentar
        $isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
        $ownerId = $data['userid']; // Pengguna yang memposting komentar

        if ($isAdmin || $userid == $ownerId) {
            // Jika admin atau pemilik komentar, hapus komentar
            $deleteQuery = mysqli_query($conn, "DELETE FROM komentar WHERE komentarid='$komentarid'");

            if ($deleteQuery) {
                // Jika berhasil menghapus komentar
                header("Location: komentar.php?status=success");
            } else {
                // Jika gagal menghapus komentar
                header("Location: komentar.php?status=error");
            }
        } else {
            // Jika user yang login bukan admin dan bukan pemilik komentar
            header("Location: komentar.php?status=unauthorized");
        }
    } else {
        // Jika komentar tidak ditemukan
        header("Location: komentar.php?status=notfound");
    }
} else {
    // Jika tidak ada session atau komentarid tidak ada
    header("Location: komentar.php?status=invalidrequest");
}
exit;
?>
