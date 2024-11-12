<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Halaman Login</title>
    <link href="css/styles.css" rel="stylesheet">
</head>

<body style="background-image: url('rezero.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center center;">  
<div id="wrapper">
    <div id="header">
        <center><h1 style="color: #336633">Halaman Login</h1></center>
        <?php
            if(isset($_GET['error']) && !empty($_GET['error'])) {
                echo '<p style="color: red;">Username atau password salah!</p>';
            }
        ?>
        <form id="loginForm" action="proses_login.php" method="post" onsubmit="return validateForm()">
            <table>
                <tr>
                    <td style="color: #336633">Username</td>
                    <td><input type="text" name="username" id="username"></td>
                </tr>
                <tr>
                    <td style="color: #336633">Password</td>
                    <td><input type="password" name="password" id="password"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Login"></td>
                </tr>
              
            </table>
            <div style="text-align: center; margin-top: 10px;">
            <a href="register.php" style="text-decoration">Belum punya akun? Registrasi di sini!</a>
        </div>
        </form>
     
     
        <div id="footer">
        </div>
    </div>
</div>

<script>
    function validateForm() {
        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;

        if (username === "" || password === "") {
            alert("Username dan Password wajib diisi!");
            return false;
        }
        return true;
    }
</script>

</body>
</html>
