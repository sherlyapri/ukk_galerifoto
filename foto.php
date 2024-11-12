<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("location:login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Foto</title>
    <link href="css/styles.css" rel="stylesheet">
</head>

<body>

    <header>
        <h1>Halaman Foto</h1>
    </header>

    <p>Selamat datang <b><?=$_SESSION['namalengkap']?></b></p>
    
    <ul>
    <li><a href="index.php">Home</a></li>
        <li><a href="album.php">Album</a></li>
        <li><a href="foto.php">Foto</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>

    <form action="tambah_foto.php" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td>Judul</td>
                <td><input type="text" name="judul" required></td>
            </tr>
            <tr>
                <td>Deskripsi</td>
                <td><input type="text" name="deskripsi" required></td>
            </tr>
            <tr>
                <td>Lokasi File</td>
                <td><input type="file" name="lokasifile" required></td>
            </tr>
            <tr>
                <td>Album</td>
                <td>
                    <select name="albumid" required>
                    <?php
                        include "koneksi.php";
                        $userid = $_SESSION['userid'];
                        $sql = mysqli_query($conn, "SELECT * FROM album WHERE userid = '$userid'");
                        while ($data = mysqli_fetch_array($sql)) {
                    ?>
                            <option value="<?=$data['albumid']?>"><?=$data['namaalbum']?></option>
                    <?php
                        }
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Tambah"></td>
            </tr>
        </table>
    </form>

    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Tanggal Unggah</th>
            <th>Lokasi File</th>
            <th>Album</th>
            <th>Disukai</th>
            <th>Aksi</th>
        </tr>
        <?php
        include "koneksi.php";
        $userid = $_SESSION['userid'];

        $sql = mysqli_query($conn, "
            SELECT foto.*, album.namaalbum 
            FROM foto
            INNER JOIN album ON foto.albumid = album.albumid
            WHERE foto.userid = '$userid'
        ");

        while ($data = mysqli_fetch_array($sql)) {
        ?>
                <tr>

                    <td><?=$data['judul']?></td>
                    <td><?=$data['deskripsi']?></td>
                    <td><?=$data['tanggal']?></td>
                    <td>
                        <img src="gambar/<?=$data['lokasifile']?>" alt="Foto" width="200px">
                    </td>
                    <td><?=$data['namaalbum']?></td>
                    <td>
                        <?php
                            $fotoid = $data['fotoid'];
                            $sql2 = mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid = '$fotoid'");
                            echo mysqli_num_rows($sql2);
                        ?>
                    </td>
                    <td>
                        <a href="hapus_foto.php?fotoid=<?=$data['fotoid']?>">Hapus</a>
                        <a href="edit_foto.php?fotoid=<?=$data['fotoid']?>">Edit</a>
                    </td>
                </tr>
        <?php
            }
        ?>
    </table>
</body>

</html>
