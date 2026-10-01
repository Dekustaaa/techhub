<?php
$currentPage = basename($_SERVER['SCRIPT_NAME']);
$menuItems = [
  ['href' => 'payment.php', 'label' => 'Pembayaran'],
  ['href' => 'payment.php', 'label' => 'Pembayaran'],
  ['href' => 'siswa.php', 'label' => 'Siswa'],
  ['href' => 'tb_siswa.php', 'label' => 'Tambah Siswa'],
  ['href' => 'in_spp.php', 'label' => 'Tambah SPP'],
  ['href' => 'detail_siswa.php', 'label' => 'Detail Siswa'],
  ['href' => 'logout.php', 'label' => 'Logout']
];
?>
<aside id="sidebar" class="fixed top-16 left-0 z-20 w-64 h-[calc(100vh-4rem)] transition-transform -translate-x-full sm:translate-x-0 bg-white border-r border-gray-200" aria-label="Sidebar">
  <div class="h-full px-3 py-4 overflow-y-auto">
    <ul class="space-y-2 font-medium">
      <?php foreach ($menuItems as $item): ?>
        <?php $active = $item['href'] === $currentPage; ?>
        <li>
          <a href="<?= htmlspecialchars($item['href']) ?>" class="flex items-center p-2 rounded-lg <?= $active ? 'bg-blue-50 text-blue-700' : 'text-gray-900 hover:bg-gray-100' ?>">
            <span class="ms-3"><?= htmlspecialchars($item['label']) ?></span>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</aside>

<main class="flex-1 pt-16 sm:ml-64">
  <div class="p-6"></div>