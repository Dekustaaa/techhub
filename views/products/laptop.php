<?php require __DIR__ . "/../../actions/cek_koneksi.php"; 
$id = $_GET['id'];
$sql = "SELECT * FROM products WHERE product_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if(!$result) {
    die("Gagal : " . mysqli_error($conn));
}
$row = mysqli_fetch_assoc($result);
$pesan ="";

if(isset($_POST['hapus'])) {
    $id =(int)$_POST['id'];
    $stmt = mysqli_prepare($conn, "DELETE FROM products WHERE id=?");
    mysqli_stmt_bind_param($stmt,"s", $id);

    if(mysqli_stmt_execute($stmt)) {
        $pesan = "Data berhasil dihapus";
} else { 
    $pesan = "Gagal hapus: " . mysqli_error($conn);
} 
mysqli_stmt_close($stmt);
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - <?php echo $row['product_name']; ?></title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons CDN untuk icon checklist, shield, dll -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-50 p-6 min-h-screen text-slate-800">

    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Header Halaman -->
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Produk</h1>
            <p class="text-slate-500 text-sm mt-1">
                Temukan laptop, tablet, smartphone, monitor, dan aksesori teknologi terbaru untuk kerja, belajar, dan kreatif.
            </p>
        </div>

        <!-- Section Main Detail Produk -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Kolom Kiri: Gambar Produk dengan Badge & Overlay Card -->
            <div class="lg:col-span-6 relative rounded-2xl overflow-hidden group">
                <!-- Badge Atas Gambar -->
                <div class="absolute top-4 left-4 z-10 flex gap-2">
                    <span class="bg-white/90 backdrop-blur-md text-slate-900 text-xs font-semibold px-3 py-1.5 rounded-full shadow-sm flex items-center gap-1.5">
                        <i data-lucide="headphones" class="w-3.5 h-3.5"></i> Layanan 24/7
                    </span>
                </div>
                <div class="absolute top-4 right-4 z-10">
                    <span class="bg-white/90 backdrop-blur-md text-slate-900 text-xs font-semibold px-3 py-1.5 rounded-full shadow-sm flex items-center gap-1.5">
                        <i data-lucide="shield-check" class="w-3.5 h-3.5"></i> Garansi resmi
                    </span>
                </div>

                <!-- Main Image -->
                <img src="<?php echo $row['url']; ?>" 
                     alt="<?php echo $row['product_name']; ?>" 
                     class="w-full h-[380px] object-cover rounded-2xl">

                <!-- Card Float Overlay di Bawah Gambar -->
                <div class="absolute bottom-4 left-4 right-4 bg-white/90 backdrop-blur-md p-4 rounded-xl border border-white/40 shadow-lg max-w-xs">
                    <h4 class="font-bold text-slate-900 text-sm mb-1"><?php echo $row['product_name']; ?></h4>
                    
                </div>
            </div>

            <!-- Kolom Kanan: Detail Informasi Produk -->
            <div class="lg:col-span-6 flex flex-col justify-between space-y-6 pt-2">
                <div>
                    <!-- Tag / Badge Populer -->
                    <div class="inline-flex items-center gap-1.5 bg-indigo-50 text-indigo-600 text-xs font-medium px-3 py-1 rounded-full mb-3">
                        <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                        <?php echo $row['badge']; ?>
                    </div>

                    <!-- Judul Utama -->
                    <h2 class="text-3xl font-extrabold text-slate-900 mb-3">
                        <?php echo $row['product_name']; ?>
                    </h2>

                    <!-- Deskripsi Panjang -->
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">
                        <?php echo $row['description']; ?>
                    </p>

                    <!-- Tombol Action Utama -->
                    <div class="flex items-center gap-3 mb-6">
                        <a href="#" class="bg-slate-900 hover:bg-slate-800 text-white text-xs font-medium px-5 py-2.5 rounded-xl transition-colors">
                            Checkout
                        </a>
                        <a href="#" class="border border-slate-300 hover:bg-slate-50 text-slate-700 text-xs font-medium px-5 py-2.5 rounded-xl transition-colors">
                            Pesan teknisi
                        </a>
                    </div>
                </div>

                <!-- Bagian Bawah: Harga & Kategori -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-t border-slate-100 pt-4">
                        <span class="text-xl font-bold text-slate-900">
                            <?php echo $row['price']; ?>
                        </span>
                        <a href="#" class="bg-slate-900 hover:bg-slate-800 text-white text-xs font-medium px-4 py-2 rounded-xl transition-colors">
                            Checkout
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Render Icon Lucide -->
    <script>
        lucide.createIcons();
    </script>
</body>
</html>