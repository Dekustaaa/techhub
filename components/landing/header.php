<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<header class="w-full bg-white border-b border-slate-200 py-3 shadow-sm">
    <!-- Container Isi Header (Ada padding horizontal agar tidak terlalu mepet tepi layar) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4">
        
        <!-- Bagian Kiri: Logo & Branding -->
        <div class="flex items-center gap-3 shrink-0">
            <!-- Avatar Logo "TH" -->
            <div class="w-10 h-10 bg-slate-900 text-white font-bold rounded-xl flex items-center justify-center text-sm shadow-sm">
                TH
            </div>
            <!-- Nama & Subtitle -->
            <div class="hidden sm:block">
                <h1 class="font-bold text-slate-900 text-base leading-tight">Tech Hub</h1>
                <p class="text-slate-400 text-xs">Solusi teknologi & layanan teknisi</p>
            </div>
        </div>

        <!-- Bagian Tengah: Search Bar -->
        <div class="flex-1 max-w-xl mx-2 sm:mx-4">
            <form action="" method="GET" class="relative flex items-center">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-4"></i>
                <input 
                    type="text" 
                    name="q" 
                    placeholder="Cari laptop, tablet, atau layanan teknisi" 
                    class="w-full bg-slate-50 border border-slate-200/80 rounded-2xl pl-11 pr-20 py-2.5 text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:bg-white transition-all"
                >
                <button 
                    type="submit" 
                    class="absolute right-1.5 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs px-3.5 py-1.5 rounded-xl font-medium shadow-sm transition-colors"
                >
                    Cari
                </button>
            </form>
        </div>

        <!-- Bagian Kanan: Actions & Avatar -->
        <div class="flex items-center gap-2 sm:gap-2.5 shrink-0">
            <!-- Tombol Hubungi Kami -->
            <a href="#" class="bg-slate-900 hover:bg-slate-800 text-white text-xs font-medium px-4 py-2.5 rounded-xl transition-colors hidden md:inline-block">
                Hubungi kami
            </a>

            <!-- Icon Notifikasi -->
            <button class="w-9 h-9 bg-slate-100 hover:bg-slate-200/70 text-slate-600 rounded-xl flex items-center justify-center transition-colors">
                <i data-lucide="bell" class="w-4 h-4"></i>
            </button>

            <a href="views/cart.php" class="relative">
                <button class="w-9 h-9 bg-slate-100 hover:bg-slate-200/70 text-slate-600 rounded-xl flex items-center justify-center transition-colors">
                    <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                </button>
            </a>

            <!-- Icon Pengaturan -->
            <button class="w-9 h-9 bg-slate-100 hover:bg-slate-200/70 text-slate-600 rounded-xl flex items-center justify-center transition-colors">
                <i data-lucide="settings" class="w-4 h-4"></i>
            </button>

            <!-- Avatar Profil "AD" -->
            <div class="w-9 h-9 bg-slate-900 text-white font-bold text-xs rounded-xl flex items-center justify-center cursor-pointer hover:opacity-90 transition-opacity">
                AD
            </div>
        </div>

    </div>
</header>

<!-- Script Icon Lucide -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>

<body class="bg-gray-50 min-h-screen text-slate-800 antialiased flex flex-col">
  
</body>