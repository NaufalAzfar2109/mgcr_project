<?php
$server = "localhost";
$pengguna = "root";
$password = "";
$db_name = "meteor_garden";

try {
    $koneksi = new PDO(
        "mysql:host=$server;dbname=$db_name;charset=utf8mb4",
        $pengguna,
        $password
    );

    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Koneksi Gagal: " . $e->getMessage());
}
?>