<?php

include 'config/connectDb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$username = $_POST["username"];
$password = $_POST["password"];

$sql = "SELECT password FROM user WHERE username = '$username'";
$result = $con->query($sql);
$hashed_password_from_database = $result->fetch_assoc()["password"];

if (password_verify($password, $hashed_password_from_database)) {
    session_start();
    $_SESSION["username"] = $username;

    header("Location: index.php");
    } else {
        echo "Username atau password salah. Coba lagi.";
    }
}
?>