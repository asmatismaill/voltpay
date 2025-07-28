<?php
if (!isset($_GET['menu'])) {
	header('location:hal_utama.php?menu=profil');
}

$agen = $aksi->caridata("agen WHERE id_agen = '$_SESSION[id_agen]'");
$field = array(
	'username' => @$_POST['username'],
	'password' => @$_POST['password'],
	'nama' => @$_POST['nama'],
	'alamat' => @$_POST['alamat'],
	'no_telepon' => @$_POST['no'],
	'biaya_admin' => @$_POST['admin'],
);

@$cek_user = $aksi->cekdata("agen WHERE username = '$_POST[username]' AND username != '$_SESSION[username_agen]'");
if (isset($_POST['ubah'])) {
	if ($cek_user > 0) {
		$aksi->pesan("username sudah ada !!!");
	} else {
		$aksi->update("agen", $field, "id_agen = '$_SESSION[id_agen]'");
		$aksi->alert("Data Berhasil diubah", "?menu=profil");
		$_SESSION['nama_agen'] = @$_POST['nama'];
		$_SESSION['username_agen'] = @$_POST['username'];
		$_SESSION['biaya_admin'] = @$_POST['admin'];
	}
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Profil Agen | VoltPay</title>
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-emerald-50 via-white to-blue-50 min-h-screen">
	<div class="max-w-2xl mx-auto py-12 px-2 sm:px-4">
		<div class="rounded-2xl shadow-xl bg-white p-6 sm:p-8">
			<h2 class="font-bold text-2xl mb-1 text-blue-700 tracking-wide text-center">Ubah Data Diri</h2>
			<div class="text-gray-400 mb-6 text-center text-sm">Pastikan data Anda selalu benar dan terbaru.</div>
			<form method="post" autocomplete="off" class="space-y-5">
				<div>
					<label for="idAgen" class="block text-gray-600 mb-1 font-medium">ID Agen</label>
					<input type="text" name="id" id="idAgen" class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-gray-100 text-gray-700" value="<?php echo $agen['id_agen'] ?>" readonly>
				</div>
				<div>
					<label for="username" class="block text-gray-600 mb-1 font-medium">Username</label>
					<input type="text" name="username" id="username" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-gray-700" value="<?php echo $agen['username'] ?>" required maxlength="30" placeholder="Username">
				</div>
				<div>
					<label for="password" class="block text-gray-600 mb-1 font-medium">Password</label>
					<input type="password" name="password" id="password" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-gray-700" value="<?php echo $agen['password'] ?>" required maxlength="30" placeholder="Password">
				</div>
				<div>
					<label for="admin" class="block text-gray-600 mb-1 font-medium">Biaya Admin</label>
					<input type="text" name="admin" id="admin" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-gray-700" value="<?php echo $agen['biaya_admin']; ?>" required maxlength="5" placeholder="Biaya Admin" onkeypress="return event.charCode >=48 && event.charCode <= 57">
				</div>
				<div>
					<label for="akses" class="block text-gray-600 mb-1 font-medium">Akses</label>
					<input type="text" name="akses" id="akses" class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-gray-100 text-gray-700" value="<?php echo $agen['akses'] ?>" required readonly placeholder="Akses">
				</div>
				<div>
					<label for="nama" class="block text-gray-600 mb-1 font-medium">Nama</label>
					<input type="text" name="nama" id="nama" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-gray-700" value="<?php echo $agen['nama'] ?>" required maxlength="50" placeholder="Nama">
				</div>
				<div>
					<label for="alamat" class="block text-gray-600 mb-1 font-medium">Alamat</label>
					<textarea name="alamat" id="alamat" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-gray-700" style="height: 80px;" required placeholder="Alamat"><?php echo $agen['alamat']; ?></textarea>
				</div>
				<div>
					<label for="no" class="block text-gray-600 mb-1 font-medium">No. Telepon</label>
					<input type="text" name="no" id="no" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-gray-700" value="<?php echo $agen['no_telepon']; ?>" required maxlength="15" placeholder="No. Telepon" onkeypress="return event.charCode >=48 && event.charCode <= 57">
				</div>
				<button type="submit" name="ubah" class="w-full py-3 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold text-lg transition">Ubah Data</button>
			</form>
		</div>
	</div>
</body>

</html>