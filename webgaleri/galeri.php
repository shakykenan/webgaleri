<?php
error_reporting(0);
include 'db.php';
$kontak = mysqli_query($conn, "SELECT admin_telp, admin_email, admin_address FROM tb_admin WHERE admin_id = 2");
$a = mysqli_fetch_object($kontak);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WEB GALERI FOTO</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <!-- header -->
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

    <div class="search">
        <div class="container">
            <form action="galeri.php" method="GET"> <!-- Added method attribute -->
                <input type="text" name="search" placeholder="Cari Foto" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <input type="hidden" name="kat" value="<?php echo isset($_GET['kat']) ? htmlspecialchars($_GET['kat']) : ''; ?>" />
                <input type="submit" name="cari" value="Cari Foto" />
            </form>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <h3>Galeri Foto</h3>
            <div class="box">
                <?php
                $where = ""; // Initialize $where variable
                if(isset($_GET['search']) && $_GET['search'] != ''){
                    $where .= " AND image_name LIKE '%" . mysqli_real_escape_string($conn, $_GET['search']) . "%' ";
                }
                if(isset($_GET['kat']) && $_GET['kat'] != ''){
                    $where .= " AND category_id LIKE '%" . mysqli_real_escape_string($conn, $_GET['kat']) . "%' ";
                }

                $foto = mysqli_query($conn, "SELECT * FROM tb_image WHERE image_status = 1 $where ORDER BY image_id DESC");
                if(mysqli_num_rows($foto) > 0){
                    while($p = mysqli_fetch_array($foto)){
                ?>
                        <a href="detail-image.php?id=<?php echo $p['image_id']; ?>">
                            <div class="col-4">
                                <img src="foto/<?php echo $p['image']; ?>" height="130px" />
                                <p class="nama"><?php echo substr($p['image_name'], 0, 30); ?></p>
                                <p class="harga"><?php echo $p['admin_name']; ?></p>
                                <p class="admin">Nama User: <?php echo $p['admin_name']; ?></p>
                                <p class="nama"><?php echo $p['date_created']; ?></p>
                            </div>
                        </a>
                <?php
                    }
                } else {
                ?>
                    <p>Foto tidak ada</p>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
