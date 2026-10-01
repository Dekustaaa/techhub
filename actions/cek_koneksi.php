<?php
$host = "localhost";
$root = "root";
$pass = "";
$dbname = "techhub";

$conn = mysqli_connect($host, $root, $pass, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}