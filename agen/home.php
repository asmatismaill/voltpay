<?php
if (!isset($_GET['menu'])) {
	header('location:hal_utama.php?menu=home');
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home Agen | VoltPay</title>
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-emerald-50 via-white to-blue-50 min-h-screen">
	<div class="max-w-3xl mx-auto py-12 px-2 sm:px-4">
		<div class="flex justify-center">
			<div class="w-full">
				<div class="rounded-2xl shadow-xl bg-white text-center p-8 sm:p-10">
					<img src="../images/vpbg.png" class="mx-auto mb-8 max-w-xs rounded-xl shadow-sm" alt="VoltPay">
					<h2 class="font-bold text-3xl mb-3 text-blue-700">Selamat Datang, <span class="text-green-600">Agen <?php echo $_SESSION['nama_agen']; ?></span>!</h2>
					<p class="text-lg text-gray-600 mb-6">Aplikasi <span class="font-bold text-blue-700">VoltPay</span> siap membantu Anda dalam mengelola pembayaran listrik pasca bayar dengan mudah, cepat, dan aman.</p>
					<hr class="my-6 border-blue-200">
					<div class="text-base text-gray-500">Gunakan menu di atas untuk mengakses fitur transaksi, laporan, dan profil Anda.</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>