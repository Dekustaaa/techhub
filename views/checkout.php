<?php 
session_start();
require __DIR__ . "/../actions/cek_koneksi.php";

if (!isset($_SESSION['cart']))    { $_SESSION['cart'] = []; }
if (!isset($_SESSION['layanan'])) { $_SESSION['layanan'] = []; }

if (count($_SESSION['cart']) == 0 && count($_SESSION['layanan']) == 0) {
    header("Location: cart.php");
    exit;
}

$subtotal    = 0;
$daftar_item = [];   // semua item (produk + layanan) dikumpulkan di sini

// ---------- Ambil data PRODUK ----------
foreach ($_SESSION['cart'] as $id => $jumlah) {
    $query  = mysqli_query($conn, "SELECT * FROM products WHERE product_id = $id");
    $produk = mysqli_fetch_assoc($query);
    if (!$produk) { continue; }

    $sub       = $produk['price'] * $jumlah;
    $subtotal += $sub;

    $daftar_item[] = [
        'nama'      => $produk['product_name'],
        'deskripsi' => $produk['description'],
        'gambar'    => $produk['url'],
        'qty'       => $jumlah,
        'subtotal'  => $sub
    ];
}

// ---------- Ambil data LAYANAN ----------
foreach ($_SESSION['layanan'] as $id => $jumlah) {
    $query   = mysqli_query($conn, "SELECT * FROM services WHERE id = $id");
    $layanan = mysqli_fetch_assoc($query);
    if (!$layanan) { continue; }

    $sub       = $layanan['base_price'] * $jumlah;
    $subtotal += $sub;

    $daftar_item[] = [
        'nama'      => $layanan['service_name'],
        'deskripsi' => $layanan['description'],
        'gambar'    => '',                 // layanan tidak punya gambar
        'qty'       => $jumlah,
        'subtotal'  => $sub
    ];
}

$total     = $subtotal + $ongkir;
$no_order  = "TH-" . date("ymd");          // contoh: TH-261002

// Untuk header.php
$pageTitle = "Checkout - Tech Hub";
$basePath  = "../";
include __DIR__ . "/../components/landing/header.php";
?>

<body class="bg-gray-50 p-6 min-h-screen text-slate-800">

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <h1 class="text-3xl font-bold text-slate-900">Checkout</h1>
    <p class="text-slate-500 text-sm mt-1 mb-6">
        Lengkapi pembayaran dan konfirmasi detail pengiriman untuk pesanan Anda.
    </p>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- ================= KIRI: RINGKASAN BELANJA ================= -->
        <div class="lg:col-span-7 bg-white rounded-3xl border border-slate-100 shadow-sm p-6">

            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-slate-900">Ringkasan belanja</h2>
                <span class="text-indigo-600 text-xs font-semibold"><?php echo count($daftar_item); ?> item</span>
            </div>

            <!-- Daftar item -->
            <?php foreach ($daftar_item as $item) { ?>
                <div class="flex gap-4 items-center py-4 border-b border-slate-100 last:border-0">

                    <?php if ($item['gambar'] != '') { ?>
                        <img src="<?php echo $item['gambar']; ?>" alt="<?php echo $item['nama']; ?>"
                             class="w-20 h-20 rounded-2xl object-cover shrink-0">
                    <?php } else { ?>
                        <div class="w-20 h-20 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                            <i data-lucide="wrench" class="w-6 h-6"></i>
                        </div>
                    <?php } ?>

                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-sm text-slate-900"><?php echo $item['nama']; ?></h3>
                        <p class="text-slate-500 text-xs truncate"><?php echo $item['deskripsi']; ?></p>
                        <p class="text-xs mt-1"><span class="font-semibold">Qty <?php echo $item['qty']; ?></span></p>
                    </div>

                    <p class="font-bold text-slate-900 shrink-0">
                        Rp <?php echo number_format($item['subtotal'], 0, ',', '.'); ?>
                    </p>
                </div>
            <?php } ?>

            <!-- Kotak total -->
            <div class="bg-slate-50 rounded-2xl p-4 mt-2 space-y-2">
                <div class="flex justify-between text-xs text-slate-500">
                    <span>Subtotal</span>
                    <span class="font-semibold text-slate-900">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></span>
                </div>
                <div class="flex justify-between text-xs text-slate-500">
                    <span>Ongkir</span>
                    <span class="font-semibold text-slate-900">Rp <?php echo number_format($ongkir, 0, ',', '.'); ?></span>
                </div>
                <div class="flex justify-between items-center border-t border-slate-200 pt-3">
                    <span class="font-bold text-sm">Total</span>
                    <span class="font-extrabold text-xl text-slate-900">Rp <?php echo number_format($total, 0, ',', '.'); ?></span>
                </div>
            </div>
        </div>


        <!-- ================= KANAN: RINGKASAN PESANAN ================= -->
        <form action="../actions/bayar.php" method="POST"
              class="lg:col-span-5 bg-white rounded-3xl border border-slate-100 shadow-sm p-6">

            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-slate-900">Ringkasan pesanan</h2>
                <span class="bg-indigo-50 text-indigo-600 text-[11px] font-semibold px-3 py-1 rounded-full">
                    Order #<?php echo $no_order; ?>
                </span>
            </div>

            <!-- Daftar item versi kecil -->
            <?php foreach ($daftar_item as $item) { ?>
                <div class="flex gap-3 items-center py-2">

                    <?php if ($item['gambar'] != '') { ?>
                        <img src="<?php echo $item['gambar']; ?>" alt="<?php echo $item['nama']; ?>"
                             class="w-14 h-14 rounded-xl object-cover shrink-0">
                    <?php } else { ?>
                        <div class="w-14 h-14 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                            <i data-lucide="wrench" class="w-5 h-5"></i>
                        </div>
                    <?php } ?>

                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-xs text-slate-900 truncate"><?php echo $item['nama']; ?></p>
                        <p class="text-slate-500 text-[11px]">Qty <?php echo $item['qty']; ?></p>
                    </div>

                    <p class="font-semibold text-xs text-slate-900 shrink-0">
                        Rp <?php echo number_format($item['subtotal'], 0, ',', '.'); ?>
                    </p>
                </div>
            <?php } ?>

            <!-- Rincian harga -->
            <div class="border-t border-slate-100 mt-3 pt-3 space-y-2">
                <div class="flex justify-between text-xs text-slate-500">
                    <span>Subtotal</span>
                    <span class="font-semibold text-slate-900">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></span>
                </div>
                <div class="flex justify-between text-xs text-slate-500">
                    <span>Ongkir</span>
                    <span class="font-semibold text-slate-900">Rp <?php echo number_format($ongkir, 0, ',', '.'); ?></span>
                </div>
                <div class="flex justify-between items-center text-xs text-slate-500">
                    <span>Metode pembayaran</span>
                    <select name="metode" class="border border-slate-200 rounded-lg px-2 py-1 text-xs font-semibold text-slate-900">
                        <option>Kartu kredit</option>
                        <option>Transfer bank</option>
                        <option>E-wallet</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-between items-center border-t border-slate-100 mt-3 pt-3">
                <span class="font-bold text-sm">Total</span>
                <span class="font-extrabold text-2xl text-slate-900">Rp <?php echo number_format($total, 0, ',', '.'); ?></span>
            </div>

            <!-- Tombol -->
            <button type="submit"
                    class="w-full bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium py-3 rounded-xl mt-4">
                Bayar sekarang
            </button>
            <a href="cart.php"
               class="block text-center border border-slate-300 hover:bg-slate-50 text-slate-700 text-sm font-medium py-3 rounded-xl mt-3">
                Kembali ke keranjang
            </a>

            <div class="bg-emerald-50 rounded-xl p-3 mt-4 flex gap-2 items-center text-[11px] text-slate-600">
                <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600 shrink-0"></i>
                <span>Pembayaran aman dengan enkripsi SSL dan garansi produk resmi.</span>
            </div>
        </form>

    <?php include __DIR__ . "/../components/landing/footer.php"; ?>
<?php
mysqli_close($conn);
?>