<?php
session_start();
include "koneksi.php";

// Pastikan user sudah login
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit;
}

// Ambil fotoid dari URL
$fotoid = $_GET['fotoid'];

// Ambil data foto berdasarkan fotoid
$sql = mysqli_query($conn, "SELECT * FROM foto WHERE fotoid='$fotoid'");
$data = mysqli_fetch_array($sql);

// Jika foto tidak ada, redirect
if (!$data) {
    header("Location: foto.php");
    exit;
}

// Periksa apakah yang login adalah admin atau pemilik foto
$loggedInUserId = $_SESSION['userid'];
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

// Jika yang login bukan admin atau pemilik foto, redirect
if (!$isAdmin && $loggedInUserId != $data['userid']) {
    header("Location: foto.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Foto</title>
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>

    <center><h1>Halaman Edit Foto</h1></center>
    <p>Selamat datang <b><?=$_SESSION['namalengkap']?></b></p>
    
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="album.php">Album</a></li>
        <li><a href="foto.php">Foto</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>

    <form action="update_foto.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="fotoid" value="<?=$data['fotoid']?>">

        <table>
            <tr>
                <td>Judul</td>
                <td><input type="text" name="judul" value="<?=$data['judul']?>" required></td>
            </tr>
            <tr>
                <td>Deskripsi</td>
                <td><input type="text" name="deskripsi" value="<?=$data['deskripsi']?>" required></td>
            </tr>
            <tr>
                <td>Lokasi File</td>
                <td><input type="file" name="lokasifile"></td>
            </tr>
            <tr>
                <td>Album</td>
                <td>
                    <select name="albumid">
                        <?php
                        $sql2 = mysqli_query($conn, "SELECT * FROM album WHERE userid='$loggedInUserId'");
                        while ($data2 = mysqli_fetch_array($sql2)) {
                        ?>
                            <option value="<?=$data2['albumid']?>" <?php if ($data2['albumid'] == $data['albumid']) { echo 'selected'; } ?>><?=$data2['namaalbum']?></option>
                        <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Ubah"></td>
            </tr>
        </table>
    </form>

</body>
</html>
