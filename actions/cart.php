<?php
session_start();

// Siapkan 2 keranjang: produk dan layanan
if (!isset($_SESSION['cart']))    { $_SESSION['cart'] = []; }
if (!isset($_SESSION['layanan'])) { $_SESSION['layanan'] = []; }

$aksi  = $_GET['aksi']  ?? '';
$jenis = $_GET['jenis'] ?? 'produk';   // produk atau layanan
$id    = (int) ($_GET['id'] ?? 0);

// Tentukan mau mengubah keranjang yang mana
if ($jenis == 'layanan') {
    $key = 'layanan';
} else {
    $key = 'cart';
}

if ($aksi == 'tambah') {
    if (isset($_SESSION[$key][$id])) {
        $_SESSION[$key][$id]++;
    } else {
        $_SESSION[$key][$id] = 1;
    }
}

if ($aksi == 'kurang') {
    if (isset($_SESSION[$key][$id])) {
        $_SESSION[$key][$id]--;
        if ($_SESSION[$key][$id] <= 0) {
            unset($_SESSION[$key][$id]);
        }
    }
}

if ($aksi == 'hapus') {
    unset($_SESSION[$key][$id]);
}

// Kembali ke halaman sebelumnya
$kembali = $_SERVER['HTTP_REFERER'] ?? '../mainpage.php';
header("Location: " . $kembali);
exit;