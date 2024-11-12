<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi Hendrik</title>
    <link rel="icon" type="imagejpg/" href="logolink.jpeg">
    <link href="css/styles.css" rel="stylesheet">
    
</head>
<body style="background-image: url('rezero.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center center;">
<div id="wrapper">
    <div id="header">
  <center><h1 >Halaman Registrasi</h1></center>
    <?php
        if(!isset($_SESSION['userid'])) {
    ?>
    <div style="text-align: center; margin-bottom: 10px;">
       
    </div>
    <?php } ?>
    <form action="proses_register.php" method="post" onsubmit="return validateForm()">
        <table>
     <center>  <a href="login.php" style="text-decoration:">Sudah punya akun? Login di sini!</a> </center> 
            <tr>
                <td style="color: #336633">Username</td>
                <td><input type="text" name="username" id="username"></td>
            </tr>
            <tr>
                <td style="color: #336633">Password</td>
                <td><input type="password" name="password" id="password"></td>
            </tr>
            <tr>
                <td style="color: #336633">Email</td>
                <td><input type="email" name="email" id="email"></td>
            </tr>
            <tr>
                <td style="color: #336633">Nama Lengkap</td>
                <td><input type="text" name="namalengkap" id="namalengkap"></td>
            </tr>
            <tr>
                <td style="color: #336633">Alamat</td>
                <td><input type="text" name="alamat" id="alamat"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="submit" value="Register"></td>
            </tr>
        </table>
    </form>
    <div id="footer">
    </div>
</div>

<script>
    function validateForm() {
        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;
        var email = document.getElementById("email").value;
        var namalengkap = document.getElementById("namalengkap").value;
        var alamat = document.getElementById("alamat").value;

        if (username === "" || password === "" || email === "" || namalengkap === "" || alamat === "") {
            alert("Semua kolom harus diisi!");
            return false;
        }
        return true;
    }
</script>

</body>
</html>
