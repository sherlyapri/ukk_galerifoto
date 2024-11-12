<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Landing - Galeri</title>
    <link href="css/styl.css" rel="stylesheet">
</head>

<body>

    <header>
        <h1>Galeri</h1>
    </header>

    <nav>
        <?php
        session_start();
        if(!isset($_SESSION['userid'])){
        ?>
        <?php
        } else {
        ?>
        <p>Selamat datang, <b><?=$_SESSION['namalengkap']?></b></p>
        <ul class="menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="allgaleri.php">Galeri</a></li>
            <li><a href="album.php">Album</a></li>
            <li><a href="foto.php">Foto</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
        <?php
        }
        ?>
    </nav>

    <div class="gallery-container">
        <?php
        if (isset($_SESSION['userid'])) {
        ?>
        <div class="section">
            <div class="container">
                <center> 
                    <h2 class="section-title">Kategori Album</h2>
                </center>
                <link href="css/ly.css" rel="stylesheet">
                <div class="category-container">
                    <?php
                    include "koneksi.php";
                    $sql = mysqli_query($conn, "SELECT * FROM album, user WHERE album.userid = user.userid");
                    if (mysqli_num_rows($sql) > 0) {
                        while ($data = mysqli_fetch_array($sql)) {
                    ?>
                    <div class="category-item">
                        <a href="galeri.php?kat=<?php echo $data['albumid'] ?>" class="category-link">
                            <img src="gambar/galeri.png" alt="<?php echo $data['namaalbum'] ?>" class="category-icon">
                            <p class="category-name"><?php echo $data['namaalbum'] ?></p>
                            <p class="category-description"><?php echo $data['deskripsi'] ?></p>
                        </a>
                    </div>
                    <?php
                        }
                    } else {
                    ?>
                        <p class="no-data">Belum ada Album</p>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>

</body>

</html>
