<?php
// koneksi.php
 $host = "localhost";
 $username = "root"; // Ganti dengan username database Anda
 $password = ""; // Ganti dengan password database Anda
 $database = "events"; // Ganti dengan nama database Anda

 $conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>