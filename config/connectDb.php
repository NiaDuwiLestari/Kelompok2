<?php
$server = 'localhost';
$user = 'root';
$password = '';
$database = "sistem_pencatatan_penjualan";

$con = mysqli_connect($server, $user, $password, $database);

if (!$con) {
    die("connection failed" . mysqli_connect_error());
}
//  else {
//     echo "berhasil terhubung";
// }
