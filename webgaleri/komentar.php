<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("location:login.php");
    exit(); // Stop further execution
}

include "koneksi.php"; // Include database connection

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if isikomentar is set and not empty
    if (isset($_POST['isikomentar']) && !empty($_POST['isikomentar'])) {
        // Insert the comment
        $isikomentar = $_POST['isikomentar'];
        $fotoid = $_POST['fotoid'];
        $userid = $_SESSION['userid'];
        $insert_comment = mysqli_prepare($conn, "INSERT INTO komentarfoto (fotoid, userid, isikomentar) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($insert_comment, "iis", $fotoid, $userid, $isikomentar);
        mysqli_stmt_execute($insert_comment);
        mysqli_stmt_close($insert_comment);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WEBSITE GALERI</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Website Gallery</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto">
                    <?php
                    if (!isset($_SESSION['userid'])) {
                    ?>
                        <a href="register.php" class="btn btn-outline-primary m-1">Register</a>
                        <a href="login.php" class="btn btn-outline-primary m-1">Login</a>
                    <?php
                    } else {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="album.php">Album</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="foto.php">Foto</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php
                    }
                    ?>
                </div>

            </div>
        </div>
    </nav>
    <form action="tambah_komentar.php" method="post">
        <?php
        $fotoid = $_GET['fotoid'];
        $select_foto = mysqli_prepare($conn, "SELECT * FROM foto WHERE fotoid = ?");
        mysqli_stmt_bind_param($select_foto, "i", $fotoid);
        mysqli_stmt_execute($select_foto);
        $result = mysqli_stmt_get_result($select_foto);
        while ($data = mysqli_fetch_array($result)) {
        ?>
        <input type="hidden" name="fotoid" value="<?= $data['fotoid'] ?>">
        <table>
            <tr>
                <td>Judul</td>
                <td><input type="text" name="judulfoto" value="<?= $data['judulfoto'] ?>"></td>
            </tr>
            <tr>
                <td>Deskripsi</td>
                <td><input type="text" name="deskripsifoto" value="<?= $data['deskripsifoto'] ?>"></td>
            </tr>
            <tr>
                <td>Foto</td>
                <td><img src="gambar/<?= $data['lokasifile'] ?>" width="200px"></td>
            </tr>
            <tr>
                <td>Komentar</td>
                <td><input type="text" name="isikomentar"></td> <!-- Fixed typo here -->
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Tambah"></td>
            </tr>
        </table>
        <?php
        }
        ?>
    </form>

    <table width="100%" border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Komentar</th>
            <th>Tanggal</th>
        </tr>
        <?php
        $userid = $_SESSION['userid'];
        $select_comments = mysqli_prepare($conn, "SELECT k.komentarid, u.namalengkap, k.isikomentar, k.tanggalkomentar FROM komentarfoto k JOIN user u ON k.userid = u.userid WHERE k.userid = ?");
        mysqli_stmt_bind_param($select_comments, "i", $userid);
        mysqli_stmt_execute($select_comments);
        $result = mysqli_stmt_get_result($select_comments);
        while ($data = mysqli_fetch_array($result)) {
        ?>
            <tr>
                <td><?= $data['komentarid'] ?></td>
                <td><?= $data['namalengkap'] ?></td>
                <td><?= $data['isikomentar'] ?></td>
                <td><?= $data['tanggalkomentar'] ?></td>
            </tr>
        <?php
        }
        ?>
    </table>
    
</body>
</html>