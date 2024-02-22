<?php
session_start();
include 'db.php';
if ($_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>';
}
$query = mysqli_query($conn, "SELECT * FROM tb_admin WHERE admin_id = '" . $_SESSION['id'] . "'");
$d = mysqli_fetch_object($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Galeri Foto</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="index.php">WEB GALERI FOTO</a></h1>
            <ul>
                <li><a href="galeri.php">Galeri</a></li>
                <li><a href="registrasi.php">Registrasi</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </div>
    </header>
    <div class="section">
        <div class="container">
            <h3>Profil</h3>
            <div class="box">
                <form action="" method="POST">
                    <input type="text" name="nama" placeholder="Nama Lengkap" class="input-control" value="<?php echo $d->admin_name ?>" required>
                    <input type="text" name="user" placeholder="Username" class="input-control" value="<?php echo $d->username ?>" required>
                    <input type="text" name="hp" placeholder="No Hp" class="input-control" value="<?php echo $d->admin_telp ?>" required>
                    <input type="email" name="email" placeholder="Email" class="input-control" value="<?php echo $d->admin_email ?>" required>
                    <input type="text" name="alamat" placeholder="Alamat" class="input-control" value="<?php echo $d->admin_address ?>" required>
                    <input type="submit" name="submit" value="Ubah Profil" class="btn">
                </form>
                <?php
                if (isset($_POST['submit'])) {
                    $nama = $_POST['nama'];
                    $user = $_POST['user'];
                    $hp = $_POST['hp'];
                    $email = $_POST['email'];
                    $alamat = $_POST['alamat'];

                    // Prepare the SQL statement and check for errors
                    $stmt = mysqli_prepare($conn, "UPDATE tb_admin SET 
                        admin_name = ?, 
                        username = ?, 
                        admin_telp = ?, 
                        email = ?, 
                        admin_address = ? 
                        WHERE admin_id = ?");
                    
                    if ($stmt) {
                        // Bind parameters and execute the statement
                        mysqli_stmt_bind_param($stmt, "sssssi", $nama, $user, $hp, $email, $alamat, $d->admin_id);
                        $update = mysqli_stmt_execute($stmt);

                        if ($update) {
                            echo '<script>alert("Ubah data berhasil")</script>';
                            echo '<script>window.location="profil.php"</script>';
                        } else {
                            echo 'gagal ' . mysqli_error($conn);
                        }
                    } else {
                        echo 'Prepare statement error: ' . mysqli_error($conn);
                    }
                }
                ?>
            </div>
            <h3>Ubah password</h3>
            <div class="box">
                <form action="" method="POST">
                    <input type="password" name="pass1" placeholder="Password Baru" class="input-control" required>
                    <input type="password" name="pass2" placeholder="Konfirmasi Password Baru" class="input-control" required>
                    <input type="submit" name="ubah_password" class="btn">
                </form>
                <?php
                if (isset($_POST['ubah_password'])) {
                    $pass1 = $_POST['pass1'];
                    $pass2 = $_POST['pass2'];

                    if ($pass2 != $pass1) {
                        echo '<script>alert("Konfirmasi Password Baru tidak sesuai")</script>';
                    } else {
                        $hashed_password = password_hash($pass1, PASSWORD_DEFAULT);

                        // Prepare the SQL statement and check for errors
                        $stmt = mysqli_prepare($conn, "UPDATE tb_admin SET 
                            password = ? 
                            WHERE admin_id = ?");
                        
                        if ($stmt) {
                            // Bind parameters and execute the statement
                            mysqli_stmt_bind_param($stmt, "si", $hashed_password, $d->admin_id);
                            $u_pass = mysqli_stmt_execute($stmt);

                            if ($u_pass) {
                                echo '<script>alert("berhasil")</script>';
                                echo '<script>window.location="profil.php"</script>';
                            } else {
                                echo 'gagal ' . mysqli_error($conn);
                            }
                        } else {
                            echo 'Prepare statement error: ' . mysqli_error($conn);
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
