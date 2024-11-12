<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Landing - Galeri</title>
    <link href="css/styl.css" rel="stylesheet">
    <style>
        /* Modal Styles */
        .modal {
            display: none; /* Modal disembunyikan secara default */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8); /* Latar belakang gelap */
            overflow: auto;
            padding-top: 60px;
        }

        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        /* Gambar dalam modal */
        .modal img {
            width: 100%;
            height: auto;
        }

        /* Close Button */
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #fff;
            font-size: 40px;
            font-weight: bold;
            background-color: transparent;
            border: none;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <header>
        <h1>Galeri</h1>
    </header>

    <!-- Navigasi atau Menu -->
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

    <!-- Div container untuk galeri -->
    <div class="gallery-container">
        <?php
        include "koneksi.php";
        $sql = mysqli_query($conn, "SELECT * FROM foto JOIN user ON foto.userid = user.userid");
        while($data = mysqli_fetch_array($sql)){
        ?>
        <!-- Setiap foto ditampilkan dalam div dengan class "gallery-item" -->
        <div class="gallery-item">
            <!-- Gambar menjadi clickable, memanggil fungsi modal() -->
            <img src="gambar/<?=$data['lokasifile']?>" alt="<?=$data['judul']?>" class="gallery-img" onclick="openModal('gambar/<?=$data['lokasifile']?>')">
            <h3><?=$data['judul']?></h3>
        </div>
        <?php
        }
        ?>
    </div>

    <!-- Modal untuk gambar besar -->
    <div id="myModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="modalImg">
    </div>

    <script>
        // Fungsi untuk membuka modal dan menampilkan gambar besar
        function openModal(src) {
            document.getElementById("myModal").style.display = "block";
            document.getElementById("modalImg").src = src;
        }

        // Fungsi untuk menutup modal
        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }

        // Menutup modal ketika klik di luar gambar
        window.onclick = function(event) {
            if (event.target == document.getElementById("myModal")) {
                closeModal();
            }
        }
    </script>

</body>

</html>
