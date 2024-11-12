<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("location:login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Album</title>
    <link href="css/styles.css" rel="stylesheet">
</head>

<body>

    <header>
        <h1>Halaman Album</h1>
    </header>

    <p>Selamat datang <b><?=$_SESSION['namalengkap']?></b></p>
    
    <ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="allgaleri.php">galeri</a></li>
        <li><a href="album.php">Album</a></li>
        <li><a href="foto.php">Foto</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>

    <!-- Menampilkan pesan jika ada -->
    <?php
    if (isset($_SESSION['success_message'])) {
        echo "<div class='message success'>".$_SESSION['success_message']."</div>";
        unset($_SESSION['success_message']);
    }
    ?>

    <form action="tambah_album.php" method="post">
        <table>
            <tr>
                <td>Nama Album</td>
                <td><input type="text" name="namaalbum" required></td>
            </tr>
            <tr>
                <td>Deskripsi</td>
                <td><input type="text" name="deskripsi" required></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Tambah"></td>
            </tr>
        </table>
    </form>

    <table>
        <tr>
         
            <th>Nama</th>
            <th>Deskripsi</th>
            <th>Tanggal dibuat</th>
            <th>Aksi</th>
        </tr>
        <?php
            include "koneksi.php";
            $userid = $_SESSION['userid'];
            $sql = mysqli_query($conn, "SELECT * FROM album WHERE userid='$userid'");
            while ($data = mysqli_fetch_array($sql)) {
        ?>
                <tr>
                  
                    <td><?=$data['namaalbum']?></td>
                    <td><?=$data['deskripsi']?></td>
                    <td><?=$data['tanggal']?></td>
                    <td>
                        <a href="hapus_album.php?albumid=<?=$data['albumid']?>">Hapus</a>
                        <a href="edit_album.php?albumid=<?=$data['albumid']?>">Edit</a>
                    </td>
                </tr>
        <?php
            }
        ?>
    </table>

</body>
</html>
