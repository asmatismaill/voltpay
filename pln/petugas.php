<?php
include '../config/koneksi.php';
global $koneksi;
if (!isset($_GET['menu'])) {
	header("location:hal_utama.php?menu=petugas");
}

$table = "petugas";
$id = isset($_GET['id']) ? $_GET['id'] : '';
$where = "md5(sha1(id_petugas)) = '$id'";
$redirect = "?menu=petugas";

//autocode
$today = date("Ymd");
$petugas = $aksi->caridata("petugas WHERE id_petugas LIKE '%$today%' ORDER BY id_petugas DESC");
$kode = isset($petugas['id_petugas']) ? substr($petugas['id_petugas'], 9, 3) + 1 : 1;
$id_petugas = sprintf("P" . $today . '%03s', $kode);

// cek username
$cek_user = $aksi->cekdata("petugas WHERE username = '" . (isset($_POST['username']) ? $_POST['username'] : '') . "'");
$field = array(
	'id_petugas' => isset($_POST['id']) ? $_POST['id'] : '',
	'username' => isset($_POST['username']) ? $_POST['username'] : '',
	'password' => isset($_POST['password']) ? $_POST['password'] : '',
	'akses' => "petugas",
	'nama' => isset($_POST['nama']) ? $_POST['nama'] : '',
	'alamat' => isset($_POST['alamat']) ? $_POST['alamat'] : '',
	'no_telepon' => isset($_POST['no']) ? $_POST['no'] : '',
	'jk' => isset($_POST['jk']) ? $_POST['jk'] : '',
);

$field_ubah = array(
	'username' => isset($_POST['username']) ? $_POST['username'] : '',
	'password' => isset($_POST['password']) ? $_POST['password'] : '',
	'nama' => isset($_POST['nama']) ? $_POST['nama'] : '',
	'alamat' => isset($_POST['alamat']) ? $_POST['alamat'] : '',
	'no_telepon' => isset($_POST['no']) ? $_POST['no'] : '',
	'jk' => isset($_POST['jk']) ? $_POST['jk'] : '',
);
//crud
if (isset($_POST['simpan'])) {
	if ($cek_user > 0) {
		$aksi->pesan("username sudah ada !!!");
	} else {
		$aksi->simpan($table, $field);
		$aksi->alert("Data berhasil disimpan", $redirect);
	}
}

if (isset($_GET['edit'])) {
	$edit = $aksi->edit($table, $where);
}

if (isset($_POST['ubah'])) {
	$cek_user = $aksi->cekdata("petugas WHERE username = '" . (isset($_POST['username']) ? $_POST['username'] : '') . "' AND username != '" . (isset($edit['username']) ? $edit['username'] : '') . "'");
	if ($cek_user > 0) {
		$aksi->pesan("username sudah ada !!!");
	} else {
		$aksi->update($table, $field_ubah, $where);
		$aksi->alert("Data berhasil diubah", $redirect);
	}
}

if (isset($_GET['hapus'])) {
	$aksi->hapus($table, $where);
	$aksi->alert("Data berhasil dihapus", $redirect);
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PETUGAS</title>
	<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen">
	<div class="container mx-auto py-8 px-2">
		<div class="flex flex-col lg:flex-row gap-8">
			<!-- Form Section -->
			<div class="w-full lg:w-1/3">
				<div class="bg-white rounded-lg shadow p-6">
					<h2 class="text-xl font-semibold mb-4 text-gray-700">
						<?php
						if (@$_GET['id'] == "") {
							echo "INPUT PETUGAS";
						} else {
							echo "UBAH PETUGAS";
						}
						?>
					</h2>
					<form method="post" enctype="multipart/form-data" class="space-y-4">
						<div>
							<label class="block text-gray-600 mb-1">ID PETUGAS</label>
							<input type="text" name="id" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300 bg-gray-100" value="<?php if (@$_GET['id'] == "") {
																																											echo @$id_petugas;
																																										} else {
																																											echo $edit['id_petugas'];
																																										} ?>" readonly required>
						</div>
						<div>
							<label class="block text-gray-600 mb-1">USERNAME</label>
							<input type="text" name="username" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" value="<?php echo @$edit['username'] ?>" required placeholder="Masukan username Petugas" maxlength="30">
						</div>
						<div>
							<label class="block text-gray-600 mb-1">PASSWORD</label>
							<input type="password" name="password" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" value="<?php echo @$edit['password'] ?>" required placeholder="Masukan password Petugas" maxlength="30">
						</div>
						<div>
							<label class="block text-gray-600 mb-1">JENIS KELAMIN</label>
							<select name="jk" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" required>
								<option value="L" <?php if (@$edit['jk'] == "L") {
														echo "selected";
													} ?>>Laki-Laki</option>
								<option value="P" <?php if (@$edit['jk'] == "P") {
														echo "selected";
													} ?>>Perempuan</option>
							</select>
						</div>
						<div>
							<label class="block text-gray-600 mb-1">NAMA</label>
							<input type="text" name="nama" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" value="<?php echo @$edit['nama'] ?>" required placeholder="Masukan nama Petugas" maxlength="50">
						</div>
						<div>
							<label class="block text-gray-600 mb-1">ALAMAT</label>
							<textarea class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" name="alamat" rows="3" required><?php echo @$edit['alamat']; ?></textarea>
						</div>
						<div>
							<label class="block text-gray-600 mb-1">NO.TELEPON</label>
							<input type="text" name="no" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" value="<?php echo @$edit['no_telepon']; ?>" required placeholder="Masukan No.Telepon Petugas" onkeypress="return event.charCode >=48 && event.charCode <= 57" maxlength="15">
						</div>
						<div>
							<label class="block text-gray-600 mb-1">FOTO</label>
							<input type="file" name="foto" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
						</div>
						<div class="flex gap-2">
							<?php
							if (@$_GET['id'] == "") { ?>
								<input type="submit" name="simpan" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded transition" value="SIMPAN">
							<?php } else { ?>
								<input type="submit" name="ubah" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded transition" value="UBAH">
							<?php } ?>
							<a href="?menu=petugas" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold py-2 rounded text-center transition">RESET</a>
						</div>
					</form>
				</div>
			</div>
			<!-- Table Section -->
			<div class="w-full lg:w-2/3">
				<div class="bg-white rounded-lg shadow p-6">
					<h2 class="text-xl font-semibold mb-4 text-gray-700">DAFTAR PETUGAS</h2>
					<?php
					if (isset($_POST['bcari'])) {
						@$text = $_POST['tcari'];
						@$cari = "WHERE id_petugas LIKE '%$text%' OR nama LIKE '%$text%' OR alamat LIKE '%$text%' OR no_telepon LIKE '%$text%' OR jk LIKE '%$text%' OR username LIKE '%$text%'";
					} else {
						$cari = "";
					}
					?>
					<form method="post" class="mb-4">
						<div class="flex gap-2">
							<input type="text" name="tcari" class="flex-1 px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" value="<?php echo @$text; ?>" placeholder="Masukan Keyword Pencarian ...">
							<button type="submit" name="bcari" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded transition">CARI</button>
							<button type="submit" name="refresh" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded transition">REFRESH</button>
						</div>
					</form>
					<div class="overflow-x-auto">
						<table class="min-w-full bg-white border border-gray-200 rounded-lg">
							<thead class="bg-gray-100">
								<tr>
									<th class="py-2 px-3 border-b text-center">No.</th>
									<th class="py-2 px-3 border-b">ID Petugas</th>
									<th class="py-2 px-3 border-b">Nama</th>
									<th class="py-2 px-3 border-b">No.Telepon</th>
									<th class="py-2 px-3 border-b">Alamat</th>
									<th class="py-2 px-3 border-b">JK</th>
									<th class="py-2 px-3 border-b">Username</th>
									<th class="py-2 px-3 border-b">Password</th>
									<th class="py-2 px-3 border-b">Akses</th>
									<th class="py-2 px-3 border-b text-center" colspan="2">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$no = 0;
								$a = $aksi->tampil($table, $cari, "ORDER BY id_petugas DESC");
								if ($a == "") {
									echo '<tr><td colspan="11" class="text-center py-4 text-gray-500">Tidak ada data petugas.</td></tr>';
								} else {
									foreach ($a as $r) {
										$cek = $aksi->cekdata(" penggunaan WHERE id_petugas = '$r[id_petugas]'");
										if ($r['id_petugas'] != $_SESSION['id_petugas']) {
											$no++;
								?>
											<tr class="hover:bg-gray-50">
												<td class="py-2 px-3 text-center"><?php echo $no; ?>.</td>
												<td class="py-2 px-3"><?php echo $r['id_petugas']; ?></td>
												<td class="py-2 px-3"><?php echo $r['nama']; ?></td>
												<td class="py-2 px-3"><?php echo $r['no_telepon']; ?></td>
												<td class="py-2 px-3"><?php echo $r['alamat']; ?></td>
												<td class="py-2 px-3"><?php if ($r['jk'] == "L") {
																			echo "Laki-Laki";
																		} else {
																			echo "Perempuan";
																		} ?></td>
												<td class="py-2 px-3"><?php echo $r['username']; ?></td>
												<td class="py-2 px-3"><?php echo substr(md5($r['password']), 0, 10); ?></td>
												<td class="py-2 px-3"><?php echo $r['akses']; ?></td>
												<?php
												if ($cek == 0) { ?>
													<td class="py-2 px-3 text-center">
														<a href="?menu=petugas&hapus&id=<?php echo md5(sha1($r['id_petugas'])); ?>" onclick="return confirm('Yakin Akan hapus data ini ?')" class="text-red-600 hover:text-red-800 transition">
															<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
																<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
															</svg>
														</a>
													</td>
												<?php } else { ?>
													<td class="py-2 px-3">&nbsp;</td>
												<?php } ?>
												<td class="py-2 px-3 text-center">
													<a href="?menu=petugas&edit&id=<?php echo md5(sha1($r['id_petugas'])); ?>" class="text-blue-600 hover:text-blue-800 transition">
														<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
															<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6 6M3 21h6v-6H3v6z" />
														</svg>
													</a>
												</td>
											</tr>
								<?php   }
									}
								} ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>