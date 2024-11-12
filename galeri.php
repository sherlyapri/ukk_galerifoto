<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Foto</title>
    <link href="css/st.css" rel="stylesheet">
</head>

<body>

    <div class="section">
        <div class="container">
            <h2>Galeri Foto</h2>

            <a href="javascript:history.back()" class="back-button">
                <i class="fas fa-chevron-left"></i> Kembali
            </a>
            <a href="foto.php" class="add-button">Unggah Foto</a>

            <div class="box">
                <?php
                include 'koneksi.php';
                session_start();
                $data = $_GET["kat"];
                $sql = mysqli_query($conn, "SELECT foto.*, user.namalengkap FROM foto JOIN user ON foto.userid = user.userid WHERE foto.albumid='$data' ORDER BY fotoid DESC");

                if(mysqli_num_rows($sql) > 0) {
                    $counter = 0;
                    while($data = mysqli_fetch_array($sql)) {
                        $counter++;
                        if ($counter <= 10) {
                ?>
                        <div class="slide">
                            <img src="gambar/<?=$data['lokasifile']?>" alt="<?=$data['deskripsi']?>" onclick="openModal('gambar/<?=$data['lokasifile']?>', '<?=$data['deskripsi']?>')">
                            <div class="keterangan">
                                <h3>Nama Foto:</h3>
                                <p><?=$data['judul']?></p>
                                <h3>Tanggal Unggah:</h3>
                                <p><?=$data['tanggal']?></p>
                                <h3>Deskripsi:</h3>
                                <p><?=$data['deskripsi']?></p>
                                <h3>Ditambahkan Oleh:</h3>
                                <p><?=$data['namalengkap']?></p>
                            </div>
                            <div class="aksi">
                                <a href="like.php?fotoid=<?=$data['fotoid']?>" class="like">Like</a>
                                <a href="komentar.php?fotoid=<?=$data['fotoid']?>" class="komentar">Komentar</a>
                                <?php
                                // Memastikan sesi login dan role admin
                                $isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
                                $userid = $_SESSION['userid']; // Pastikan session user_id ada
                                ?>
                                <?php if ($isAdmin || $userid == $data['userid']): ?>
                                    <a href="hapus_foto.php?fotoid=<?=$data['fotoid']?>" class="hapus">Hapus</a>
                                    <a href="edit_foto.php?fotoid=<?=$data['fotoid']?>" class="edit">Edit</a>
                                <?php endif; ?>
                            </div>
                            <div class="info">
                                <p>Total Like: <?php echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid='{$data['fotoid']}'")); ?></p>
                                <p>Total Komentar: <?php echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM komentar WHERE fotoid='{$data['fotoid']}'")); ?></p>
                            </div>
                        </div>
                <?php 
                        } else {
                            break;
                        }
                    }
                } else { 
                ?>
                    <p class="no-data">Foto tidak ada</p>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- Modal for Image Preview -->
    <div id="myModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
        <div class="modal-content">
            <img id="modalImg" src="" alt="">
            <div id="caption" class="caption"></div>
        </div>
    </div>

    <script>
        var slideIndex = 0;

        function openModal(imgSrc, imgDesc) {
            slideIndex = findIndex(imgSrc);
            document.getElementById('myModal').style.display = "block";
            document.getElementById('modalImg').src = imgSrc;
            document.getElementById('caption').innerHTML = '<p>' + imgDesc + '</p>';
        }

        function closeModal() {
            document.getElementById('myModal').style.display = "none";
        }

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function showSlides(n) {
            var slides = document.getElementsByClassName("slide");
            if (n >= slides.length) {
                slideIndex = 0;
            }
            if (n < 0) {
                slideIndex = slides.length - 1;
            }
            var imgSrc = slides[slideIndex].querySelector('img').src;
            var imgDesc = slides[slideIndex].querySelector('.keterangan p').textContent;
            document.getElementById('modalImg').src = imgSrc;
            document.getElementById('caption').innerHTML = '<p>' + imgDesc + '</p>';
        }

        function findIndex(imgSrc) {
            var slides = document.getElementsByClassName("slide");
            for (var i = 0; i < slides.length; i++) {
                var src = slides[i].querySelector('img').src;
                if (src === imgSrc) {
                    return i;
                }
            }
            return 0;
        }

        showSlides(slideIndex);
    </script>
</body>

</html>
