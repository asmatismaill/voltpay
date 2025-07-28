<?php // Removed extra <br> for cleaner layout 
?>
<?php
include '../config/koneksi.php';
include '../library/fungsi.php';

session_start();
date_default_timezone_set("Asia/Jakarta");

$aksi = new oop();
if (empty($_SESSION['username_petugas'])) {
	$aksi->alert("Harap Login Dulu !!!", "index.php");
}

if (isset($_GET['logout'])) {
	unset($_SESSION['username_petugas']);
	unset($_SESSION['id_petugas']);
	unset($_SESSION['nama_petugas']);
	unset($_SESSION['akses_petugas']);
	$aksi->alert("logout Berhasil !!!", "index.php");
}
?>
<!DOCTYPE html>
<html>


<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>PT. PLN PERSERO</title>
	<link rel="icon" type="image/png" href="../images/logo_pln.png">
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen">
	<!-- Navbar -->
	<nav class="fixed top-0 left-0 right-0 z-30 bg-white shadow-md">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="flex items-center justify-between h-16">
				<div class="flex items-center">
					<a href="?menu=home" class="flex items-center">
						<img src="../images/logo_pln1.png" alt="PLN Logo" class="h-10 w-auto mr-2">
					</a>
					<div class="hidden md:flex space-x-2 ml-6">
						<!-- Data Dasar Dropdown -->
						<div class="relative group">
							<button class="inline-flex items-center px-3 py-2 text-gray-700 hover:text-emerald-600 font-semibold focus:outline-none">
								<svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
									<path d="M4 4h16v16H4z" />
								</svg>
								Data Dasar
								<svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
								</svg>
							</button>
							<div class="absolute left-0 mt-2 w-56 bg-white rounded-md shadow-lg opacity-0 group-hover:opacity-100 group-hover:visible invisible transition-opacity duration-200 z-20">
								<a href="?menu=tarif" class="block px-4 py-2 text-gray-700 hover:bg-emerald-50">Kelola Tarif</a>
								<a href="?menu=pelanggan" class="block px-4 py-2 text-gray-700 hover:bg-emerald-50">Kelola Pelanggan</a>
								<a href="?menu=agen" class="block px-4 py-2 text-gray-700 hover:bg-emerald-50">Kelola Agen</a>
								<a href="?menu=petugas" class="block px-4 py-2 text-gray-700 hover:bg-emerald-50">Kelola Petugas</a>
							</div>
						</div>
						<!-- Transaksi Dropdown -->
						<div class="relative group">
							<button class="inline-flex items-center px-3 py-2 text-gray-700 hover:text-emerald-600 font-semibold focus:outline-none">
								<svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
									<path d="M3 3h18v6H3V3zm0 12h18v6H3v-6z" />
								</svg>
								Transaksi
								<svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
								</svg>
							</button>
							<div class="absolute left-0 mt-2 w-56 bg-white rounded-md shadow-lg opacity-0 group-hover:opacity-100 group-hover:visible invisible transition-opacity duration-200 z-20">
								<a href="?menu=tagihan" class="block px-4 py-2 text-gray-700 hover:bg-emerald-50">Daftar Tagihan</a>
								<a href="?menu=penggunaan" class="block px-4 py-2 text-gray-700 hover:bg-emerald-50">Kelola Penggunaan</a>
							</div>
						</div>
						<!-- Laporan Dropdown -->
						<div class="relative group">
							<button class="inline-flex items-center px-3 py-2 text-gray-700 hover:text-emerald-600 font-semibold focus:outline-none">
								<svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
									<path d="M9 17v-2a4 4 0 014-4h4" />
								</svg>
								Laporan
								<svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
								</svg>
							</button>
							<div class="absolute left-0 mt-2 w-64 bg-white rounded-md shadow-lg opacity-0 group-hover:opacity-100 group-hover:visible invisible transition-opacity duration-200 z-20">
								<a href="?menu=laporan&tarif" class="block px-4 py-2 text-gray-700 hover:bg-emerald-50">Laporan Data Tarif</a>
								<a href="?menu=laporan&pelanggan" class="block px-4 py-2 text-gray-700 hover:bg-emerald-50">Laporan Data Pelanggan</a>
								<a href="?menu=laporan&agen" class="block px-4 py-2 text-gray-700 hover:bg-emerald-50">Laporan Data Agen</a>
								<div class="border-t my-1"></div>
								<a href="?menu=laporan&tagihan_bulan" class="block px-4 py-2 text-gray-700 hover:bg-emerald-50">Laporan Tagihan (Perbulan)</a>
								<a href="?menu=laporan&tunggakan" class="block px-4 py-2 text-gray-700 hover:bg-emerald-50">Laporan Tunggakan</a>
								<a href="?menu=laporan&riwayat_penggunaan" class="block px-4 py-2 text-gray-700 hover:bg-emerald-50">Laporan Riwayat Penggunaan (Pertahun)</a>
							</div>
						</div>
					</div>
				</div>
				<!-- User Dropdown -->
				<div class="relative group">
					<button class="inline-flex items-center px-3 py-2 text-gray-700 hover:text-emerald-600 font-semibold focus:outline-none">
						<svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
							<path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
						</svg>
						<?php echo $_SESSION['nama_petugas']; ?>
						<svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
							<path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
						</svg>
					</button>
					<div class="absolute right-0 mt-2 w-44 bg-white rounded-md shadow-lg opacity-0 group-hover:opacity-100 group-hover:visible invisible transition-opacity duration-200 z-20">
						<a href="?menu=profil" class="block px-4 py-2 text-gray-700 hover:bg-emerald-50">Profil</a>
						<a href="?logout" class="block px-4 py-2 text-gray-700 hover:bg-emerald-50" onclick="return confirm('Yakin akan keluar dari aplikasi ini ?')">Keluar</a>
					</div>
				</div>
			</div>
		</div>
	</nav>
	<div class="pt-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

		<?php
		switch (@$_GET['menu']) {
			case 'home':
				include 'home.php';
				break;
			case 'tarif':
				include 'tarif.php';
				break;
			case 'pelanggan':
				include 'pelanggan.php';
				break;
			case 'petugas':
				include 'petugas.php';
				break;
			case 'agen':
				include 'agen.php';
				break;
			case 'penggunaan':
				include 'penggunaan.php';
				break;
			case 'tagihan':
				include 'tagihan.php';
				break;
			case 'laporan':
				include 'laporan.php';
				break;
			case 'profil':
				include 'profil.php';
				break;
			default:
				$aksi->redirect("?menu=home");
				break;
		}
		?>


		<footer class="w-full mt-12 py-6 bg-white border-t text-center text-gray-400 text-sm">
			<strong>&copy; <?php echo date("Y"); ?> - PT. PLN PERSERO</strong>
		</footer>

		<script src="../js/jquery.min.js"></script>
</body>

</html>