<?php require __DIR__ . "/actions/cek_koneksi.php";

// 1. UPDATE QUERY: Menggunakan LEFT JOIN untuk mengambil nama kategori dari tabel categories
$sql = "SELECT products.*, categories.category_name, categories.image, categories.cat_description
        FROM products 
        LEFT JOIN categories ON products.category_id = categories.category_id
        ORDER BY products.product_id ASC";

$result = mysqli_query($conn, $sql);

if(!$result) {
    die("Gagal : " . mysqli_error($conn));
}

$pesan = "";

if(isset($_POST['hapus'])) {
    $id = (int)$_POST['id'];
    
    // Perbaikan: Kolom ID disesuaikan (misal: product_id) dan tipe data parameter 'i' untuk integer
    $stmt = mysqli_prepare($conn, "DELETE FROM products WHERE product_id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);

    if(mysqli_stmt_execute($stmt)) {
        $pesan = "Data berhasil dihapus";
    } else { 
        $pesan = "Gagal hapus: " . mysqli_error($conn);
    } 
    mysqli_stmt_close($stmt);
}
?>


<?php include __DIR__ . "/components/landing/header.php"; ?>

<body class="bg-gray-50 p-6 min-h-screen">

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-16">

        <!-- SECTION 1: HERO BANNER -->
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            
            <!-- Hero Left Side: Text & Actions -->
            <div class="lg:col-span-6 space-y-6">
                <!-- Badge Versi -->
                <div class="inline-flex items-center gap-1.5 bg-indigo-50 border border-indigo-100 text-indigo-600 text-xs font-semibold px-3 py-1.5 rounded-full">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                    <span>Tech Hub 2.0</span>
                </div>

                <!-- Judul Utama -->
                <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 leading-[1.15] tracking-tight">
                    Solusi teknologi lengkap untuk bisnis dan rumahan
                </h1>

                <!-- Deskripsi Hero -->
                <p class="text-slate-500 text-sm sm:text-base leading-relaxed max-w-xl">
                    Beli produk teknologi, pesan jasa teknisi, dan kelola layanan bisnis Anda dari satu dashboard yang lebih cepat, lebih rapi, dan lebih mudah dipahami.
                </p>

                <!-- Tombol Action -->
                <div class="flex items-center gap-3 pt-2">
                    <a href="#" class="bg-slate-900 hover:bg-slate-800 text-white text-xs sm:text-sm font-medium px-5 py-2.5 rounded-xl transition-colors shadow-sm">
                        Mulai berjualan
                    </a>
                    <a href="#" class="border border-slate-300 hover:bg-slate-100 text-slate-700 text-xs sm:text-sm font-medium px-5 py-2.5 rounded-xl transition-colors">
                        Pesan teknisi
                    </a>
                </div>

                
                </div>
            </div>

            <!-- Hero Right Side: Image Banner with Overlay -->
            <div class="lg:col-span-6 relative">
                <div class="relative rounded-3xl overflow-hidden shadow-sm border border-slate-200/80 bg-slate-100">
                    
                    <!-- Badges Top Image -->
                    <div class="absolute top-4 left-4 z-10">
                        <span class="bg-white/90 backdrop-blur-md text-slate-900 text-xs font-semibold px-3 py-1.5 rounded-full shadow-sm flex items-center gap-1.5 border border-white/40">
                            <i data-lucide="headphones" class="w-3.5 h-3.5"></i> Layanan 24/7
                        </span>
                    </div>
                    <div class="absolute top-4 right-4 z-10">
                        <span class="bg-white/90 backdrop-blur-md text-slate-900 text-xs font-semibold px-3 py-1.5 rounded-full shadow-sm flex items-center gap-1.5 border border-white/40">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5"></i> Garansi resmi
                        </span>
                    </div>

                    <!-- Banner Image -->
                    <img 
                        src="https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=800&auto=format&fit=crop&q=80" 
                        alt="Hero Banner Tech Hub" 
                        class="w-full h-[360px] sm:h-[420px] object-cover"
                    >


                </div>
            </div>

        </section>

        <!-- SECTION 2: KATEGORI PRODUK & LAYANAN -->
        <section class="space-y-6">
            <!-- Header Section Kategori -->
            <div class="flex justify-between items-end border-b border-slate-200/60 pb-4">
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900">Kategori produk & layanan</h2>
                    <p class="text-slate-500 text-xs sm:text-sm mt-1">Temukan solusi yang tepat untuk bisnis dan rumahan.</p>
                </div>
                <a href="#" class="text-indigo-600 hover:underline text-xs sm:text-sm font-medium shrink-0">
                    Lihat semua
                </a>
            </div>

            <!-- Grid 6 Kolom Kategori -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                <?php foreach ($result as $row): ?>
                    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
                        <div>
                            <!-- Icon Kategori -->
                            <div class="w-9 h-9 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mb-3">
                                <i data-lucide="<?php echo $row['image']; ?>" class="w-4 h-4"></i>
                            </div>

                            <!-- Judul & Deskripsi Kategori -->
                            <h3 class="font-bold text-slate-900 text-xs sm:text-sm mb-1">
                                <?php echo $row['category_name']; ?>
                            </h3>
                            <p class="text-slate-500 text-[11px] leading-relaxed line-clamp-3">
                                <?php echo $row['cat_description']; ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

    </main>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-16">
        <!-- Header Section -->
        <div class="flex justify-between items-end mb-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Produk populer</h2>
                <p class="text-slate-500 text-sm mt-1">Rekomendasi untuk kerja, belajar, dan kreatif.</p>
            </div>
            <a href="#" class="text-indigo-600 hover:underline text-sm font-medium">Lihat semua produk</a>
        </div>

        <!-- Grid Produk -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <?php foreach ($result as $row): ?>
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 flex flex-col justify-between">
                    <div>
                        <!-- Gambar Produk -->
                        <div class="rounded-xl overflow-hidden mb-4 h-40 bg-gray-100">
                            <img src="<?php echo $row['url']; ?>" 
                                 alt="<?php echo $row['product_name']; ?>" 
                                 class="w-full h-full object-cover">
                        </div>

                        <!-- Judul & Deskripsi -->
                        <h3 class="font-bold text-slate-900 text-base mb-1">
                            <?php echo $row['product_name']; ?>
                        </h3>
                        <p class="text-slate-500 text-xs leading-relaxed mb-4 line-clamp-3">
                            <?php echo $row['description']; ?>
                        </p>
                    </div>

                    <!-- Harga & Tombol Action -->
                    <div class="flex items-center justify-between pt-2">
                        <span class="font-bold text-slate-900 text-sm">
                            <?php 
                                        $price = $row['price'] ?? 10000000;
                                        echo is_numeric($price) ? 'Rp ' . number_format($price, 0, ',', '.') : htmlspecialchars($price);
                                    ?>
                        </span>
                        <a href="#" class="bg-slate-900 hover:bg-slate-800 text-white text-xs px-4 py-2 rounded-lg transition-colors font-medium">
                            Lihat
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>



