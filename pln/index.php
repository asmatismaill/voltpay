<?php // Removed extra <br> for cleaner layout 
?>
<?php
include '../config/koneksi.php'; //untuk koneksi ke database
include '../library/fungsi.php'; //untuk memasukan library

session_start(); //untuk menampung session
date_default_timezone_set("Asia/Jakarta"); //untuk mengatur zona waktu

$aksi = new oop(); //untuk memanggil class di library

//tampung us & pw agar dibaca string bukan syntax
$username = isset($_POST['username']) ? mysqli_real_escape_string($koneksi, $_POST['username']) : '';
$password = isset($_POST['password']) ? mysqli_real_escape_string($koneksi, $_POST['password']) : '';

//jika session username petugas tidak kosong, pindah ke halaman utama
if (!empty($_SESSION['username_petugas'])) {
	$aksi->redirect("hal_utama.php?menu=home");
}

//jika tekan login maka menjalankan fungsi login dari library 
if (isset($_POST['login'])) {
	$aksi->login("petugas", $username, $password, "hal_utama.php?menu=home");
}
?>
<!DOCTYPE html>
<html>


<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login Admin PLN | VoltPay</title>
	<link rel="icon" type="image/png" href="../images/logo_pln.png">
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[url('../images/bg2.png')] bg-cover min-h-screen flex items-center justify-center">
	<div class="w-full max-w-md mx-auto p-6">
		<div class="rounded-2xl shadow-xl bg-white text-center p-8">
			<img src="../images/logo_pln.png" alt="logo" class="mx-auto mb-4 mt-2 w-20">
			<h2 class="font-bold text-2xl mb-1 text-emerald-600 tracking-wide">Login Admin PLN</h2>
			<div class="text-gray-400 mb-6 text-sm">Masuk ke akun admin PLN Anda.</div>
			<form method="post" autocomplete="off" class="space-y-5">
				<div>
					<label for="username" class="block text-left text-gray-600 mb-1 font-medium">Username</label>
					<input type="text" id="username" name="username" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-400 focus:outline-none text-gray-700" placeholder="Masukan username Anda..." required maxlength="30" autofocus>
				</div>
				<div>
					<label for="password" class="block text-left text-gray-600 mb-1 font-medium">Password</label>
					<input type="password" id="password" name="password" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-400 focus:outline-none text-gray-700" placeholder="Masukan password Anda..." required maxlength="30">
				</div>
				<button type="submit" name="login" class="w-full py-3 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-lg transition">LOGIN</button>
			</form>
			<div class="pt-6 text-gray-400 text-xs">&copy;<?php echo date("Y"); ?> - PT. PLN PERSERO</div>
		</div>
	</div>
</body>

</html>