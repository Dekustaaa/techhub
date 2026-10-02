<?php
session_start();
require __DIR__ . "/../actions/cek_koneksi.php";
require __DIR__ . "/../components/landing/header.php";

if (!isset($_SESSION['cart']))    { $_SESSION['cart'] = []; }
if (!isset($_SESSION['layanan'])) { $_SESSION['layanan'] = []; }

$subtotal_produk  = 0;
$subtotal_layanan = 0;
$jumlah_produk    = 0;
$jumlah_layanan   = 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang - Tech Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50 p-6 min-h-screen text-slate-800">
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-16">

<div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

    <!-- ================= KOLOM KIRI ================= -->
    <div class="lg:col-span-8 space-y-4">

        <div>
            <h1 class="text-2xl font-bold text-slate-900">Keranjang belanja</h1>
            <p class="text-slate-500 text-xs mt-1">Lengkapi pesanan produk dan layanan teknisi Anda.</p>
        </div>

        <!-- ---------- DAFTAR PRODUK ---------- -->
        <?php
        foreach ($_SESSION['cart'] as $id => $jumlah) {

            // Ambil data produk dari database
            $query  = mysqli_query($conn, "SELECT * FROM products WHERE product_id = $id");
            $produk = mysqli_fetch_assoc($query);
            if (!$produk) { continue; }

            $subtotal         = $produk['price'] * $jumlah;
            $subtotal_produk += $subtotal;
            $jumlah_produk++;
        ?>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-3 flex gap-4 items-center">

            <!-- Gambar -->
            <img src="<?php echo $produk['url']; ?>" alt="<?php echo $produk['product_name']; ?>"
                 class="w-20 h-20 rounded-xl object-cover shrink-0">

            <!-- Nama, deskripsi, tombol jumlah -->
            <div class="flex-1 min-w-0">
                <h3 class="font-bold text-sm text-slate-900"><?php echo $produk['product_name']; ?></h3>
                <p class="text-slate-500 text-[11px] truncate"><?php echo $produk['description']; ?></p>

                <div class="flex items-center gap-2 mt-2 text-xs">
                    <a href="../actions/cart.php?aksi=kurang&jenis=produk&id=<?php echo $id; ?>"
                       class="w-6 h-6 rounded-full border border-slate-200 flex items-center justify-center">&minus;</a>
                    <span class="font-semibold"><?php echo $jumlah; ?></span>
                    <a href="../actions/cart.php?aksi=tambah&jenis=produk&id=<?php echo $id; ?>"
                       class="w-6 h-6 rounded-full bg-slate-900 text-white flex items-center justify-center">+</a>
                </div>
            </div>

            <!-- Badge, hapus, harga -->
            <div class="flex flex-col items-end gap-2 shrink-0">
                <div class="flex items-center gap-2">
                    <span class="bg-indigo-50 text-indigo-600 text-[10px] font-semibold px-3 py-1 rounded-full">Produk</span>
                    <a href="../actions/cart.php?aksi=hapus&jenis=produk&id=<?php echo $id; ?>"
                       class="w-8 h-6 bg-slate-100 text-slate-500 hover:text-red-600 rounded-full flex items-center justify-center">
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
                <p class="font-bold text-slate-900">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></p>
            </div>
        </div>
        <?php } ?>


        <!-- ---------- DAFTAR LAYANAN ---------- -->
        <?php
        foreach ($_SESSION['layanan'] as $id => $jumlah) {

            // Ambil data layanan dari tabel services
            $query   = mysqli_query($conn, "SELECT * FROM services WHERE service_id = $id");
            $layanan = mysqli_fetch_assoc($query);
            if (!$layanan) { continue; }   // layanan tidak ada, lewati

            $subtotal          = $layanan['base_price'] * $jumlah;
            $subtotal_layanan += $subtotal;
            $jumlah_layanan++;
        ?>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 flex gap-4 items-center">

            <div class="w-9 h-9 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center shrink-0">
                <i data-lucide="wrench" class="w-4 h-4"></i>
            </div>

            <div class="flex-1 min-w-0">
                <h3 class="font-bold text-sm text-slate-900"><?php echo $layanan['service_name']; ?></h3>
                <p class="text-slate-500 text-[11px]"><?php echo $layanan['description']; ?></p>

                <div class="flex items-center gap-2 mt-2 text-xs">
                    <a href="../actions/cart.php?aksi=kurang&jenis=layanan&id=<?php echo $id; ?>"
                    class="w-6 h-6 rounded-full border border-slate-200 flex items-center justify-center">&minus;</a>
                    <span class="font-semibold"><?php echo $jumlah; ?></span>
                    <a href="../actions/cart.php?aksi=tambah&jenis=layanan&id=<?php echo $id; ?>"
                    class="w-6 h-6 rounded-full bg-slate-900 text-white flex items-center justify-center">+</a>
                </div>
            </div>

            <div class="flex flex-col items-end gap-2 shrink-0">
                <div class="flex items-center gap-2">
                    <span class="bg-indigo-50 text-indigo-600 text-[10px] font-semibold px-3 py-1 rounded-full">
                        Mulai Rp <?php echo number_format($layanan['base_price'], 0, ',', '.'); ?>
                    </span>
                    <a href="../actions/cart.php?aksi=hapus&jenis=layanan&id=<?php echo $id; ?>"
                    class="w-8 h-6 bg-slate-100 text-slate-500 hover:text-red-600 rounded-full flex items-center justify-center">
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
                <p class="font-bold text-slate-900">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></p>
            </div>
        </div>
        <?php } ?>


        <!-- Pesan kalau keranjang kosong -->
        <?php if ($jumlah_produk == 0 && $jumlah_layanan == 0) { ?>
            <div class="bg-white rounded-2xl border border-slate-100 p-10 text-center text-slate-500 text-sm">
                Keranjang masih kosong.
                <a href="../mainpage.php" class="text-indigo-600 font-medium">Belanja dulu</a>
            </div>
        <?php } ?>

        <!-- Tombol tambah layanan (diambil dari database) -->
        <?php
        $daftar = mysqli_query($conn, "SELECT * FROM services");
        while ($s = mysqli_fetch_assoc($daftar)) {
        ?>
            <a href="../actions/cart.php?aksi=tambah&jenis=layanan&id=<?php echo $s['service_id']; ?>"
            class="inline-block text-indigo-600 text-xs font-medium hover:underline mr-4">
                + Tambah <?php echo $s['service_name']; ?>
            </a>
        <?php } ?>
    </div>


    <div class="lg:col-span-4 space-y-4">

        <!-- Ringkasan pesanan -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 space-y-3">
            <div class="flex justify-between items-center">
                <h2 class="font-bold text-slate-900">Ringkasan pesanan</h2>
                <span class="text-indigo-600 text-[11px] font-medium">
                    <?php echo $jumlah_produk; ?> produk + <?php echo $jumlah_layanan; ?> layanan
                </span>
            </div>

            <div class="flex justify-between text-xs text-slate-500">
                <span>Subtotal produk</span>
                <span class="font-semibold text-slate-900">Rp <?php echo number_format($subtotal_produk, 0, ',', '.'); ?></span>
            </div>
            <div class="flex justify-between text-xs text-slate-500">
                <span>Subtotal layanan</span>
                <span class="font-semibold text-slate-900">Rp <?php echo number_format($subtotal_layanan, 0, ',', '.'); ?></span>
            </div>
            <?php $total = $subtotal_produk + $subtotal_layanan; ?>

            <div class="flex justify-between items-center border-t border-slate-100 pt-3">
                <span class="font-bold text-sm">Total</span>
                <span class="font-extrabold text-xl text-slate-900">Rp <?php echo number_format($total, 0, ',', '.'); ?></span>
            </div>

            <a href="#" class="block text-center bg-slate-900 hover:bg-slate-800 text-white text-xs font-medium py-2.5 rounded-full">
                Lanjut ke checkout
            </a>
            <a href="../mainpage.php" class="block text-center border border-slate-300 hover:bg-slate-50 text-slate-700 text-xs font-medium py-2.5 rounded-full">
                Simpan keranjang
            </a>

            <div class="bg-slate-50 rounded-xl p-3 flex gap-2 items-center text-[11px] text-slate-500">
                <i data-lucide="shield-check" class="w-4 h-4 text-indigo-600 shrink-0"></i>
                <span>Pembayaran aman &bull; Garansi resmi &bull; Bisa ubah jadwal teknisi</span>
            </div>
        </div>

        <!-- Bantuan -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <h3 class="font-bold text-sm text-slate-900 mb-3">Butuh bantuan?</h3>
            <div class="flex gap-3 items-center">
                <div class="w-9 h-9 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center shrink-0">
                    <i data-lucide="phone" class="w-4 h-4"></i>
                </div>
                <div>
                    <p class="font-semibold text-xs text-slate-900">Hubungi tim sales</p>
                    <p class="text-slate-500 text-[11px]">Senin-Jumat, 09.00-18.00 WIB</p>
                </div>
            </div>
        </div>

    </div>
    <?php include __DIR__ . "/../components/landing/footer.php"; ?>
<?php
mysqli_close($conn);
?>
