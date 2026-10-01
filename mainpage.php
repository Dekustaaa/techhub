<?php require __DIR__ . "/actions/cek_koneksi.php";

$sql = "SELECT * FROM products ORDER BY product_id ASC";
$result = mysqli_query($conn, $sql);

if(!$result) {
    die("Gagal : " . mysqli_error($conn));
}

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
    <title>Produk Populer</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-6 min-h-screen">

    <div class="max-w-6xl mx-auto">
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
                        <p class="text-slate-500 text-xs leading-relaxed mb-4">
                            <?php echo $row['description']; ?>
                        </p>
                    </div>

                    <!-- Harga & Tombol Action -->
                    <div class="flex items-center justify-between pt-2">
                        <span class="font-bold text-slate-900 text-sm">
                            <?php echo $row['price']; ?>
                        </span>
                        <a href="#" class="bg-slate-900 hover:bg-slate-800 text-white text-xs px-4 py-2 rounded-lg transition-colors font-medium">
                            Lihat
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>
</html>


