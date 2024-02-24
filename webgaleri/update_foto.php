<?php
include "koneksi.php";
session_start();

$fotoid = $_POST['fotoid'];
$judulfoto = $_POST['judulvoto'];
$deskripsifoto = $_POST['deskripsifoto'];
$albumid = $_POST['albumid'];
$tanggalunggah = date['Y-m-d'];
$userid = $_SESSION['albumid'];
$foto = $_FILES['albumid'];
$tmp = $_FILES['albumid'];
$lokasi = 'gambar/';
$namafoto = rand() .'-'.$foto;

if ($foto == null) {
    $sql = mysqli_query($conn, "update foto set judulfoto='$judulfoto',deskripsifoto='$deskripsifoto',albumid='$albumid' where fotoid='$fotoid'");
} else {
    $query = mysqli_query(conn,"select * from foto where fotoid='$fotoid'");
    $data = mysqli_fetch_array($query);
    if (is_file('gamabar/'.$data['lokasifile'])){
        unlink('gamabar/'.$data['lokasifile']);
    }
    move_uploaded_file($tmp,$lokasi,$namafoto);
    $sql = mysqli_query($conn, "update foto set judulfoto='$judulfoto',deskripsifoto='$deskripsifoto',lokasifile=$namafoto,albumid='$albumid' where fotoid='$fotoid'");
}
echo "<script>
    alert('Ubah data berhasil');
    location.href='foto.php';
</script>";