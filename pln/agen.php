<?php
if (!isset($_GET['menu'])) {
	header("location:hal_utama.php?menu=agen");
}

$table = "agen";
$id = @$_GET['id'];
$where = "md5(sha1(id_agen)) = '$id'";
$redirect = "?menu=agen";

//autocode
$today = date("Ymd");
$agen = $aksi->caridata("agen WHERE id_agen LIKE '%$today%' ORDER BY id_agen DESC");
if (empty($agen)) {
	$id_agen = "A" . $today . "001";
} else {
	$kode = substr($agen['id_agen'], 9, 3) + 1;
	$id_agen = sprintf("A" . $today . '%03s', $kode);
}

// cek username
@$cek_user = $aksi->cekdata("agen WHERE username = '$_POST[username]'");
$field = array(
	'id_agen' => @$_POST['id'],
	'username' => @$_POST['username'],
	'password' => @$_POST['password'],
	'akses' => @$_POST['akses'],
	'nama' => @$_POST['nama'],
	'alamat' => @$_POST['alamat'],
	'no_telepon' => @$_POST['no'],
	'akses' => "agen",
	'biaya_admin' => @$_POST['admin'],
);

$field_ubah = array(
	'username' => @$_POST['username'],
	'password' => @$_POST['password'],
	'nama' => @$_POST['nama'],
	'alamat' => @$_POST['alamat'],
	'no_telepon' => @$_POST['no'],
	'biaya_admin' => @$_POST['admin'],
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
<html>

<head>
	<title>AGEN</title>
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen">
	<div class="max-w-7xl mx-auto px-4 py-8">
		<div class="flex flex-col md:flex-row md:space-x-8">
			<div class="w-full md:w-1/3 mb-8 md:mb-0">
				<div class="bg-white shadow rounded-lg">
					<div class="px-6 py-4 border-b border-gray-200 text-lg font-semibold text-gray-700">
						<?php
						if (@$_GET['id'] == "") {
							echo "INPUT AGEN";
						} else {
							echo "UBAH AGEN";
						}
						?>
					</div>
					<div class="p-6">
						<form method="post" class="space-y-4">
							<div>
								<label class="block text-gray-700 font-medium mb-1">ID AGEN</label>
								<input type="text" name="id" class="form-input border-gray-300 rounded px-2 py-1 w-full" value="<?php if (@$_GET['id'] == "") {
																																	echo @$id_agen;
																																} else {
																																	echo $edit['id_agen'];
																																} ?>" readonly required>
							</div>
							<div>
								<label class="block text-gray-700 font-medium mb-1">USERNAME</label>
								<input type="text" name="username" class="form-input border-gray-300 rounded px-2 py-1 w-full" value="<?php echo @$edit['username'] ?>" required placeholder="Masukan username Agen" maxlength="30">
							</div>
							<div>
								<label class="block text-gray-700 font-medium mb-1">PASSWORD</label>
								<input type="password" name="password" class="form-input border-gray-300 rounded px-2 py-1 w-full" value="<?php echo @$edit['password'] ?>" required placeholder="Masukan password Agen" maxlength="30">
							</div>
							<div>
								<label class="block text-gray-700 font-medium mb-1">BIAYA ADMIN</label>
								<input type="text" name="admin" class="form-input border-gray-300 rounded px-2 py-1 w-full" value="<?php echo @$edit['biaya_admin']; ?>" placeholder="Masukan Biaya Admin" required onkeypress="return event.charCode >=48 && event.charCode <= 57" maxlength="5">
							</div>
							<div>
								<label class="block text-gray-700 font-medium mb-1">NAMA</label>
								<input type="text" name="nama" class="form-input border-gray-300 rounded px-2 py-1 w-full" value="<?php echo @$edit['nama'] ?>" required placeholder="Masukan nama Agen" maxlength="50">
							</div>
							<div>
								<label class="block text-gray-700 font-medium mb-1">ALAMAT</label>
								<textarea class="form-input border-gray-300 rounded px-2 py-1 w-full" name="alamat" rows="3" required><?php echo @$edit['alamat']; ?></textarea>
							</div>
							<div>
								<label class="block text-gray-700 font-medium mb-1">NO.TELEPON</label>
								<input type="text" name="no" class="form-input border-gray-300 rounded px-2 py-1 w-full" value="<?php echo @$edit['no_telepon']; ?>" required placeholder="Masukan No.Telepon Agen" onkeypress="return event.charCode >=48 && event.charCode <= 57" maxlength="15">
							</div>
							<div class="flex flex-col space-y-2 mt-4">
								<?php
								if (@$_GET['id'] == "") { ?>
									<input type="submit" name="simpan" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded w-full" value="SIMPAN">
								<?php } else { ?>
									<input type="submit" name="ubah" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 rounded w-full" value="UBAH">
								<?php } ?>
								<a href="?menu=agen" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 rounded w-full text-center">RESET</a>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="w-full md:w-2/3">
				<div class="bg-white shadow rounded-lg">
					<div class="px-6 py-4 border-b border-gray-200 text-lg font-semibold text-gray-700">DAFTAR AGEN</div>
					<div class="p-6">
						<form method="post" class="mb-4">
							<div class="flex items-center space-x-2">
								<input type="text" name="tcari" class="form-input border-gray-300 rounded px-2 py-1 w-full" value="<?php echo @$text; ?>" placeholder="Masukan Keyword Pencarian ...">
								<button type="submit" name="bcari" class="inline-flex items-center px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4h13M8 4v16m0-16L3 9m5-5l5 5" />
									</svg>CARI</button>
								<button type="submit" name="refresh" class="inline-flex items-center px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16m16-16v16" />
									</svg>REFRESH</button>
							</div>
						</form>
						<div class="overflow-x-auto">
							<table class="min-w-full divide-y divide-gray-200 border border-gray-300 bg-white rounded-lg">
								<thead class="bg-gray-100">
									<tr>
										<th class="px-3 py-2 text-center font-semibold text-gray-700">No.</th>
										<th class="px-3 py-2 text-center font-semibold text-gray-700">ID Agen</th>
										<th class="px-3 py-2 text-center font-semibold text-gray-700">Nama</th>
										<th class="px-3 py-2 text-center font-semibold text-gray-700">No.Telepon</th>
										<th class="px-3 py-2 text-center font-semibold text-gray-700">Alamat</th>
										<th class="px-3 py-2 text-center font-semibold text-gray-700">Biaya Admin</th>
										<th class="px-3 py-2 text-center font-semibold text-gray-700">Username</th>
										<th class="px-3 py-2 text-center font-semibold text-gray-700">Password</th>
										<th class="px-3 py-2 text-center font-semibold text-gray-700">Akses</th>
										<th class="px-3 py-2 text-center font-semibold text-gray-700" colspan="2">Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = 0;
									$a = $aksi->tampil($table, $cari, "ORDER BY id_agen DESC");
									if ($a == "") {
										$aksi->no_record(11);
									} else {
										foreach ($a as $r) {
											$cek = $aksi->cekdata(" pembayaran WHERE id_agen = '$r[id_agen]'");
											$no++;
									?>
											<tr>
												<td class="text-center"><?php echo $no; ?>.</td>
												<td><?php echo $r['id_agen']; ?></td>
												<td><?php echo $r['nama']; ?></td>
												<td><?php echo $r['no_telepon']; ?></td>
												<td><?php echo $r['alamat']; ?></td>
												<td><?php $aksi->rupiah($r['biaya_admin']); ?></td>
												<td><?php echo $r['username']; ?></td>
												<td><?php echo substr(md5($r['password']), 0, 10); ?></td>
												<td><?php echo $r['akses']; ?></td>
												<?php
												if ($cek == 0) { ?>
													<td class="text-center">
														<a href="?menu=agen&hapus&id=<?php echo md5(sha1($r['id_agen'])); ?>" onclick="return confirm('Yakin Akan hapus data ini ?')" class="text-red-500 hover:text-red-700" title="Hapus">
															<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
																<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
															</svg>
														</a>
													</td>
												<?php } else { ?>
													<td>&nbsp;</td>
												<?php } ?>
												<td class="text-center">
													<a href="?menu=agen&edit&id=<?php echo md5(sha1($r['id_agen'])); ?>" class="text-blue-500 hover:text-blue-700" title="Edit">
														<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
															<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6 6M3 17v4h4l10.293-10.293a1 1 0 00-1.414-1.414L3 17z" />
														</svg>
													</a>
												</td>
											</tr>

									<?php	}
									} ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="panel-footer">&nbsp;</div>
			</div>
		</div>
	</div>
	</div>
	</div>
</body>

</html>