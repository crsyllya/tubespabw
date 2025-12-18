<?php
session_start();
include '../koneksi/conn.php';

if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit;
}

$nama = $_SESSION['nama'] ?? "Admin";
$email = $_SESSION['email'];

// Hitung total pengguna
$resultUser = $conn->query("SELECT COUNT(*) AS total FROM tb_users");
$totalUsers = $resultUser ? $resultUser->fetch_assoc()['total'] : 0;

// Hitung total event
$resultEvent = $conn->query("SELECT COUNT(*) AS total FROM tb_events");
$totalEvents = $resultEvent ? $resultEvent->fetch_assoc()['total'] : 0;

// Hitung total tiket terjual
$resultTickets = $conn->query("SELECT SUM(jumlah) AS total FROM tb_tiket");
$totalTicketsSold = $resultTickets ? $resultTickets->fetch_assoc()['total'] : 0;

// Hitung total transaksi (jumlah baris di tb_transaksi atau tb_pemesanan tiket)
$resultTransactions = $conn->query("SELECT COUNT(*) AS total FROM tb_transaksi");
$totalTransactions = $resultTransactions ? $resultTransactions->fetch_assoc()['total'] : 0;

// PERBAIKAN: Hitung pendapatan total dari kolom price di tb_events
$resultRevenue = $conn->query("SELECT SUM(price) AS total_revenue FROM tb_events");
$price = $resultRevenue ? $resultRevenue->fetch_assoc()['total_revenue'] : 0;

// Hitung pengunjung terbaru (misal yang daftar 30 hari terakhir)
$resultVisitors = $conn->query("SELECT COUNT(*) AS total FROM tb_users WHERE tanggal_daftar >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)");
$newVisitors = $resultVisitors ? $resultVisitors->fetch_assoc()['total'] : 0;

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Penyelenggara - EventEast</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-100 text-gray-800">

<div class="flex min-h-screen">
  <!-- Sidebar -->
  <aside class="w-64 bg-[#0b1e4b] text-white p-6 space-y-4">
    <div class="text-xl font-bold mb-6">EventEast</div>
    <nav class="space-y-2">
      <a href="dashAdmin" class="block py-2 px-4 rounded <?= ($active ?? '') == 'dashboard' ? 'bg-blue-700' : 'hover:bg-blue-600' ?>">Dashboard</a>
      <a href="../admin/kelolaEvent.php" class="block py-2 px-4 rounded <?= ($active ?? '') == 'kelola event' ? 'bg-blue-700' : 'hover:bg-blue-600' ?>">Kelola Event</a>
      <a href="../admin/kelolaUser.php" class="block py-2 px-4 rounded <?= ($active ?? '') == 'kelola user' ? 'bg-blue-700' : 'hover:bg-blue-600' ?>">Kelola User</a>
      <div class="mt-4 text-gray-400">Akun</div>
      <a href="../profile/adminProfile.php" class="block py-2 px-4 rounded <?= ($active ?? '') == 'pengaturan' ? 'bg-blue-700' : 'hover:bg-blue-600' ?>">Pengaturan</a>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-6">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-semibold">Hai, <?= htmlspecialchars($nama) ?> 👋</h1>
      <div class="flex items-center space-x-4">

        <!-- Dropdown Profil -->
        <div class="relative">
          <button id="profilBtn" class="flex items-center space-x-2 bg-white px-4 py-2 rounded border border-gray-300">
            <span><?= htmlspecialchars($nama) ?></span>
          </button>
          <div id="profilDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded shadow-lg p-2 hidden z-10">
            <a href="../profile/adminProfile.php" class="block px-4 py-2 text-sm hover:bg-gray-100">Profil Saya</a>
            <div class="border-t my-1"></div>
            <a href="../logout.php" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Keluar</a>
          </div>
        </div>
      </div>
    </div>

<!-- Statistik -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
  <div class="bg-white p-4 rounded shadow">
    <p class="text-gray-500 text-sm">Total Pengguna</p>
    <p class="text-2xl font-bold"><?= $totalUsers ?> <span class="text-sm text-blue-600">Orang</span></p>
  </div>
  <div class="bg-white p-4 rounded shadow">
    <p class="text-gray-500 text-sm">Total Event</p>
    <p class="text-2xl font-bold"><?= $totalEvents ?> <span class="text-sm text-blue-600">Event</span></p>
  </div>
  <div class="bg-white p-4 rounded shadow">
    <p class="text-gray-500 text-sm">Total Transaksi</p>
    <p class="text-2xl font-bold"><?= $totalTransactions ?> <span class="text-sm text-blue-600">Transaksi</span></p>
  </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
  <div class="bg-white p-4 rounded shadow">
    <p class="text-gray-500 text-sm">Total Tiket Terjual</p>
    <p class="text-2xl font-bold"><?= $totalTicketsSold ?? 0 ?> <span class="text-sm">Tiket</span></p>
  </div>
  <div class="bg-white p-4 rounded shadow">
    <p class="text-gray-500 text-sm">Pendapatan</p>
    <p class="text-2xl font-bold">Rp <?= number_format($price ?? 0, 0, ',', '.') ?></p>
  </div>
  <div class="bg-white p-4 rounded shadow">
    <p class="text-gray-500 text-sm">Pengunjung Terbaru</p>
    <p class="text-2xl font-bold"><?= $newVisitors ?? 0 ?> <span class="text-sm">Orang</span></p>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    lucide.createIcons();

    const profilBtn = document.getElementById("profilBtn");
    const dropdown = document.getElementById("profilDropdown");

    profilBtn.addEventListener("click", function (e) {
      e.stopPropagation();
      dropdown.classList.toggle("hidden");
    });

    document.addEventListener("click", function () {
      dropdown.classList.add("hidden");
    });

    dropdown.addEventListener("click", function (e) {
      e.stopPropagation();
    });
  });
</script>

</body>
</html>