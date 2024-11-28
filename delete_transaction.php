<?php
include 'config/connectDb.php';

$id = $_GET["id"];
$sql = $con->prepare("DELETE FROM tr_penjualan WHERE id_transaction=?");
$sql->bind_param("s", $id);
if ($sql->execute()) {
    header("location:penjualan.php");
} else {
    echo "error: " . $sql->error;
}
