<?php // Removed extra <br> for cleaner layout 
?>
<?php
if (!isset($_GET['menu'])) {
	header('location:hal_utama.php?menu=home');
}
?>
<!DOCTYPE html>
<html>


<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home | VoltPay</title>
	<link rel="icon" type="image/png" href="../images/logo_pln.png">
	<script src="https://cdn.tailwindcss.com"></script>
</head>


<body class="bg-gray-50 min-h-screen flex items-center justify-center">
	<div class="w-full max-w-2xl mx-auto p-6">
		<div class="rounded-2xl shadow-xl bg-white text-center p-10">
			<div class="mb-6 animate-pulse">
				<h3 class="text-2xl font-bold text-emerald-700">Selamat Datang <?php echo $_SESSION['nama_petugas']; ?>, di Aplikasi Pembayaran Listrik Pasca Bayar</h3>
			</div>
			<img src="../images/logo_pln2.png" alt="Logo PLN" class="mx-auto w-full max-w-lg">
		</div>
	</div>
</body>

</html>