<?php
session_start();

$metode = htmlspecialchars($_POST['metode'] ?? 'Kartu kredit');

// Kosongkan keranjang setelah bayar
$_SESSION['cart']    = [];
$_SESSION['layanan'] = [];

echo "<script>
    alert('Pembayaran dengan $metode berhasil! Terima kasih.');
    window.location = '../mainpage.php';
</script>";