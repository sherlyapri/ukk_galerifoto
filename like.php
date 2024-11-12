<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

include "koneksi.php";  
$fotoid = $_GET['fotoid'];
$userid = $_SESSION['userid'];

$sql_check_like = mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid = '$fotoid' AND userid = '$userid'");
if (mysqli_num_rows($sql_check_like) == 0) {
$sql_like = "INSERT INTO likefoto (fotoid, userid) VALUES ('$fotoid', '$userid')";
    if (mysqli_query($conn, $sql_like)) {
        echo "Like berhasil ditambahkan!";
    } else {
        echo "Gagal menambahkan like. Coba lagi.";
    }
} else {
    echo "Anda sudah memberi like pada foto ini!";
}

exit();
?>
