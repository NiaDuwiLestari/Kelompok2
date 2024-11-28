<?php
include 'config/connectDb.php';

$id = $_GET["id"];
$sql = $con->prepare("DELETE FROM sistem_pencatatan_penjualan WHERE id=?");
$sql->bind_param("i", $id);
if ($sql->execute()) {
    header("location:index.php");
} else {
    echo "error: " . $sql->error;
}
