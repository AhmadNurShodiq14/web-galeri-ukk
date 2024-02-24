<?php
include "koneksi.php";

$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$namalengkap = $_POST['namalengkap'];
$alamat = $_POST['alamat'];
$jeniskelamin = $_POST['jeniskelamin'];

$sql = mysqli_query($conn, "INSERT INTO user (username, password, email, namalengkap, alamat, jeniskelamin)
                            VALUES ('$username', '$password', '$email', '$namalengkap', '$alamat', '$jeniskelamin')");

if ($sql) {
    echo "<script>
        alert('Pendaftaran akun berhasil');
        location.href='login.php';
        </script>";
} else {
    echo "<script>
        alert('Pendaftaran akun tidak berhasil');
        location.href='register.php';
        </script>";
}
?>