<br> <br> <br> <br> <br> <br>

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
if (!empty($_SESSION['username_agen'])) {
	$aksi->redirect("hal_utama.php?menu=home");
}

//jika tekan login maka menjalankan fungsi login dari library 
if (isset($_POST['login'])) {
	$aksi->login("agen", $username, $password, "hal_utama.php?menu=home");
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login Agen | VoltPay</title>
	<link rel="icon" type="image/png" href="../images/vp.png">
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-emerald-50 via-white to-blue-50 min-h-screen flex items-center justify-center">
	<div class="w-full max-w-md mx-auto p-4 sm:p-6">
		<div class="rounded-2xl shadow-xl bg-white text-center p-8 sm:p-10">
			<img src="../images/vp.png" alt="logo" class="mx-auto mb-4 mt-2 w-20 rounded-xl shadow-sm">
			<h2 class="font-bold text-2xl mb-1 text-blue-700 tracking-wide">Login Agen</h2>
			<div class="text-gray-400 mb-6 text-sm">Masuk ke akun Anda untuk mengakses layanan VoltPay.</div>
			<form method="post" autocomplete="off" class="space-y-5">
				<div>
					<label for="username" class="block text-left text-gray-600 mb-1 font-medium">Username</label>
					<input type="text" id="username" name="username" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-gray-700" placeholder="Username" required maxlength="30" autofocus>
				</div>
				<div>
					<label for="password" class="block text-left text-gray-600 mb-1 font-medium">Password</label>
					<input type="password" id="password" name="password" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-gray-700" placeholder="Password" required maxlength="30">
				</div>
				<button type="submit" name="login" class="w-full py-3 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold text-lg transition">LOGIN</button>
			</form>
			<div class="pt-6 text-gray-400 text-xs">&copy;<?php echo date("Y"); ?> - VOLTPAY</div>
		</div>
	</div>
</body>

</html>