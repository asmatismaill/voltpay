<?php // Removed extra <br> for cleaner layout 
?>
<?php
include '../config/koneksi.php';
include '../library/fungsi.php';

session_start();
date_default_timezone_set("Asia/Jakarta");

$aksi = new oop();
if (empty($_SESSION['username_agen'])) {
	$aksi->alert("Harap Login Dulu !!!", "index.php");
}

if (isset($_GET['logout'])) {
	unset($_SESSION['username_agen']);
	unset($_SESSION['id_agen']);
	unset($_SESSION['nama_agen']);
	unset($_SESSION['biaya_admin']);
	unset($_SESSION['akses_agen']);
	$aksi->alert("logout Berhasil !!!", "index.php");
}

?>
<!DOCTYPE html>
<html>


<head>
	<title>VOLTPAY</title>
	<link rel="icon" type="image/png" href="../images/vp.png">
	<script src="https://cdn.tailwindcss.com"></script>
</head>


<body class="bg-gradient-to-br from-emerald-50 via-white to-blue-50 min-h-screen">
	<!-- Navbar -->
	<nav class="fixed top-0 left-0 right-0 z-30 bg-white shadow-lg">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="flex items-center justify-between h-16">
				<div class="flex items-center">
					<a href="?menu=home" class="flex items-center">
						<img src="../images/vp1.png" alt="VoltPay Logo" class="h-10 w-auto mr-2">
					</a>
					<div class="hidden md:flex space-x-2 ml-6">
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
							<div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 group-hover:opacity-100 group-hover:visible invisible transition-opacity duration-200 z-20">
								<a href="?menu=riwayat" class="block px-4 py-2 text-gray-700 hover:bg-emerald-50">Riwayat Pembayaran</a>
								<a href="?menu=pembayaran" class="block px-4 py-2 text-gray-700 hover:bg-emerald-50">Kelola Pembayaran</a>
							</div>
						</div>
						<!-- Laporan Dropdown -->
						<div class="relative group">
							<button class="inline-flex items-center px-3 py-2 text-gray-700 hover:text-emerald-600 font-semibold focus:outline-none">
								<svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
									<path d="M4 4h16v16H4z" />
								</svg>
								Laporan
								<svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
								</svg>
							</button>
							<div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 group-hover:opacity-100 group-hover:visible invisible transition-opacity duration-200 z-20">
								<a href="?menu=laporan" class="block px-4 py-2 text-gray-700 hover:bg-emerald-50">Riwayat Pembayaran</a>
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
						<?php echo $_SESSION['nama_agen']; ?>
						<svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
							<path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
						</svg>
					</button>
					<div class="absolute right-0 mt-2 w-44 bg-white rounded-md shadow-lg opacity-0 group-hover:opacity-100 group-hover:visible invisible transition-opacity duration-200 z-20">
						<a href="?menu=profil" class="block px-4 py-2 text-gray-700 hover:bg-emerald-50">Profil</a>
						<a href="?logout" class="block px-4 py-2 text-gray-700 hover:bg-emerald-50">Keluar</a>
					</div>
				</div>
			</div>
		</div>
	</nav>
	<div class="pt-20 max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">

		<?php
		switch (@$_GET['menu']) {
			case 'home':
				include 'home.php';
				break;
			case 'riwayat':
				include 'riwayat.php';
				break;
			case 'pembayaran':
				include 'pembayaran.php';
				break;
			case 'laporan':
				include 'laporan.php';
				break;
			case 'profil':
				include 'profil.php';
				break;
			// case 'struk':include'struk.php'; break;
			default:
				$aksi->redirect("?menu=home");
				break;
		}
		?>


		<footer class="w-full mt-12 py-6 bg-white border-t text-center text-gray-400 text-sm shadow-inner">
			<strong>&copy; 2025 <a target="_blank" href="#" class="text-blue-600 hover:underline">VOLTPAY</a>.</strong>
		</footer>

		<script src="../js/jquery.min.js"></script>
		<script>
			$("#tbayar").keyup(function() {
				var totalakhir = parseInt($("#ttotalakhir").val());
				var bayar = parseInt($("#tbayar").val());
				var kembalian = 0;
				if (bayar < totalakhir) {
					kembalian = "";
				};
				if (bayar > totalakhir) {
					kembalian = bayar - totalakhir;
				};
				$("#tkembalian").val(kembalian);
			});
		</script>
</body>

</html>