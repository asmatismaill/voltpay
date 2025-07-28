<?php
if (!isset($_GET['menu'])) {
	header('location:hal_utama.php?menu=profil');
}

$petugas = $aksi->caridata("petugas WHERE id_petugas = '$_SESSION[id_petugas]'");
$field = array(
	'username' => @$_POST['username'],
	'password' => @$_POST['password'],
	'nama' => @$_POST['nama'],
	'alamat' => @$_POST['alamat'],
	'no_telepon' => @$_POST['no'],
	'jk' => @$_POST['jk'],
);

@$cek_user = $aksi->cekdata("petugas WHERE username = '$_POST[username]' AND username != '$_SESSION[username_petugas]'");
if (isset($_POST['ubah'])) {
	if ($cek_user > 0) {
		$aksi->pesan("username sudah ada !!!");
	} else {
		$aksi->update("petugas", $field, "id_petugas = '$_SESSION[id_petugas]'");
		$aksi->alert("Data Berhasil diubah", "?menu=profil");
		$_SESSION['nama_petugas'] = @$_POST['nama'];
		$_SESSION['username_petugas'] = @$_POST['username'];
	}
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Profil | VoltPay</title>
	<link rel="icon" type="image/png" href="../images/logo_pln.png">
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center">
	<div class="w-full max-w-lg mx-auto p-6">
		<div class="rounded-2xl shadow-xl bg-white p-8">
			<div class="text-2xl font-bold text-emerald-600 mb-6 text-center">Ubah Data Diri</div>
			<form method="post" class="space-y-5">
				<div>
					<label class="block text-gray-600 mb-1 font-medium">ID Petugas</label>
					<input type="text" name="id" class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-gray-100 text-gray-700" value="<?php echo $petugas['id_petugas'] ?>" readonly>
				</div>
				<div>
					<label class="block text-gray-600 mb-1 font-medium">Username</label>
					<input type="text" name="username" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-400 focus:outline-none text-gray-700" value="<?php echo $petugas['username'] ?>" required placeholder="Masukan username Anda">
				</div>
				<div>
					<label class="block text-gray-600 mb-1 font-medium">Password</label>
					<input type="password" name="password" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-400 focus:outline-none text-gray-700" value="<?php echo $petugas['password'] ?>" required placeholder="Masukan password Anda">
				</div>
				<div>
					<label class="block text-gray-600 mb-1 font-medium">Akses</label>
					<input type="text" name="akses" class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-gray-100 text-gray-700" value="<?php echo $petugas['akses'] ?>" required readonly>
				</div>
				<div>
					<label class="block text-gray-600 mb-1 font-medium">Nama</label>
					<input type="text" name="nama" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-400 focus:outline-none text-gray-700" value="<?php echo $petugas['nama'] ?>" required placeholder="Masukan nama Anda">
				</div>
				<div>
					<label class="block text-gray-600 mb-1 font-medium">Jenis Kelamin</label>
					<select name="jk" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-400 focus:outline-none text-gray-700" required>
						<option value="L" <?php if ($petugas['jk'] == "L") {
												echo "selected";
											} ?>>Laki-Laki</option>
						<option value="P" <?php if ($petugas['jk'] == "P") {
												echo "selected";
											} ?>>Perempuan</option>
					</select>
				</div>
				<div>
					<label class="block text-gray-600 mb-1 font-medium">Alamat</label>
					<textarea class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-400 focus:outline-none text-gray-700" name="alamat" rows="3" required><?php echo $petugas['alamat']; ?></textarea>
				</div>
				<div>
					<label class="block text-gray-600 mb-1 font-medium">No. Telepon</label>
					<input type="text" name="no" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-400 focus:outline-none text-gray-700" value="<?php echo $petugas['no_telepon']; ?>" required placeholder="Masukan No.Telepon Anda" onkeypress="return event.charCode >=48 && event.charCode <= 57">
				</div>
				<div>
					<button type="submit" name="ubah" class="w-full py-3 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-lg transition">UBAH DATA</button>
				</div>
			</form>
		</div>
	</div>
</body>

</html>