<?php
include "koneksi.php";
session_start();

// Pastikan user sudah login
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit;
}

$fotoid = $_GET['fotoid']; // Mendapatkan fotoid dari URL
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Komentar</title>
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
    <center><h1>Halaman Komentar</h1></center>
    <p>Selamat datang <b><?=$_SESSION['namalengkap']?></b></p>

    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="album.php">Album</a></li>
        <li><a href="foto.php">Foto</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>

    <form action="tambah_komentar.php?fotoid=<?=$_GET['fotoid']?>" method="post">
        <table>
            <tr>
                <td>Komentar</td>
                <td><input type="text" name="isikomentar" required></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Tambah"></td>
            </tr>
        </table>

        <?php
        // Menampilkan informasi foto
        if (!isset($fotoid)) {
            die("Foto ID tidak ditemukan.");
        }

        $fotoid = mysqli_real_escape_string($conn, $_GET['fotoid']);
        $sql = $conn->prepare("SELECT * FROM foto WHERE fotoid = ?");
        $sql->bind_param("i", $fotoid); 
        $sql->execute();
        $result = $sql->get_result();
        if ($data = $result->fetch_array(MYSQLI_ASSOC)) {
            echo "<h2>Judul: " . htmlspecialchars($data['judul']) . "</h2>";
            echo "<p>Deskripsi: " . htmlspecialchars($data['deskripsi']) . "</p>";
            echo "<img src='gambar/" . htmlspecialchars($data['lokasifile']) . "' alt='Foto' width='200px'>";
        } else {
            echo "<p>Foto tidak ditemukan.</p>";
        }
        $sql->close();
        ?>
    </form>

    <table width="100%" border="1" cellpadding=5 cellspacing=0>
        <tr>
            <th>Nama</th>
            <th>Komentar</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
        <?php
        // Menampilkan komentar
        $result = mysqli_query($conn, 
        "SELECT komentar.*, user.namalengkap 
         FROM komentar 
         JOIN user ON komentar.userid = user.userid 
         WHERE komentar.fotoid = '$fotoid'");

        while ($data = mysqli_fetch_array($result)) {
            $komentarid = $data['komentarid'];
            $namalengkap = $data['namalengkap'];
            $isikomentar = $data['isikomentar'];
            $tanggalkomentar = $data['tanggalkomentar'];
        ?>
            <tr>
                <td><?=$namalengkap?></td>
                <td><?=$isikomentar?></td>
                <td><?=$tanggalkomentar?></td>
                <td>
                    <?php
                    // Menampilkan tombol Hapus jika user adalah admin atau pemilik komentar
                    if ($_SESSION['role'] == 'admin' || $_SESSION['userid'] == $data['userid']) {
                    ?>
                        <a href="hapus_komentar.php?komentarid=<?=$komentarid?>&fotoid=<?=$fotoid?>" onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini?')">Hapus</a>
                    <?php
                    }
                    ?>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
</body>
</html>
