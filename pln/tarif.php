<?php
if (!isset($_GET['menu'])) {
	header('location:hal_utama.php?menu=tarif');
}
//dasar
$table = "tarif";
$id = @$_GET['id'];
$where = " md5(sha1(id_tarif)) = '$id'";
$redirect = "?menu=tarif";

//untuk kebutuhan crud
@$golongan = $_POST['golongan'];
@$daya = $_POST['daya'];
@$tarif = $_POST['tarif'];
@$kode_tarif = $golongan . "/" . $daya;
//tampung data
$data = array(
	'kode_tarif' => $kode_tarif,
	'golongan' => $golongan,
	'daya' => $daya,
	'tarif_perkwh' => $tarif,
);

$cek = $aksi->cekdata("tarif WHERE kode_tarif = '$kode_tarif'");
if (isset($_POST['bsimpan'])) {
	if ($cek > 0) {
		$aksi->pesan("Data sudah ada");
	} else {
		$aksi->simpan($table, $data);
		$aksi->alert("Data Berhasil Disimpan", $redirect);
	}
}

if (isset($_POST['bubah'])) {
	@$cek = $aksi->cekdata("tarif WHERE kode_tarif = '$kode_tarif' AND kode_tarif != '$edit[kode_tarif]'");
	if ($cek > 0) {
		$aksi->pesan("Data sudah ada");
	} else {
		$aksi->update($table, $data, $where);
		$aksi->alert("Data Berhasil Diubah", $redirect);
	}
}

if (isset($_GET['edit'])) {
	$edit = $aksi->edit($table, $where);
}

if (isset($_GET['hapus'])) {
	$aksi->hapus($table, $where);
	$aksi->alert("Data Berhasil Dihapus", $redirect);
}

if (isset($_POST['bcari'])) {
	$text = $_POST['tcari'];
	$cari = "WHERE id_tarif LIKE '%$text%' OR kode_tarif LIKE '%$text%' OR daya LIKE '%$text%' OR golongan LIKE '%$text%' OR tarif_perkwh LIKE '%$text%'";
} else {
	$cari = "";
}





?>
<!DOCTYPE html>
<html>

<head>
	<title>TARIF</title>
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen">
	<div class="max-w-7xl mx-auto px-4 py-8">
		<div class="flex flex-col md:flex-row md:space-x-8">
			<div class="w-full md:w-1/3 mb-8 md:mb-0">
				<div class="bg-white shadow rounded-lg">
					<?php if (!@$_GET['id']) { ?>
						<div class="px-6 py-4 border-b border-gray-200 text-lg font-semibold text-gray-700">INPUT TARIF</div>
					<?php } else { ?>
						<div class="px-6 py-4 border-b border-gray-200 text-lg font-semibold text-gray-700">UBAH TARIF</div>
					<?php } ?>
					<div class="p-6">
						<form method="post" class="space-y-4">
							<div>
								<label class="block text-gray-700 font-medium mb-1">GOLONGAN</label>
								<input type="text" name="golongan" class="form-input border-gray-300 rounded px-2 py-1 w-full" placeholder="Masukan Golongan" required value="<?php echo @$edit['golongan']; ?>" list="gol">
								<datalist id="gol">
									<option value="R1">R1</option>
									<option value="R2">R2</option>
									<option value="R3">R3</option>
									<option value="B1">B1</option>
								</datalist>
							</div>
							<div>
								<label class="block text-gray-700 font-medium mb-1">DAYA</label>
								<input type="text" name="daya" class="form-input border-gray-300 rounded px-2 py-1 w-full" placeholder="Masukan Daya" required value="<?php echo @$edit['daya']; ?>" list="day">
								<datalist id="day">
									<option value="450VA">450VA</option>
									<option value="900VA">900VA</option>
									<option value="1300VA">1300VA</option>
								</datalist>
							</div>
							<div>
								<label class="block text-gray-700 font-medium mb-1">TARIF/KWH</label>
								<input type="text" name="tarif" class="form-input border-gray-300 rounded px-2 py-1 w-full" placeholder="Masukan Tarif" required value="<?php echo @$edit['tarif_perkwh']; ?>" onkeypress='return event.charCode >=48 && event.charCode <=57'>
							</div>
							<div class="flex flex-col space-y-2 mt-4">
								<?php
								if (@$_GET['id'] == "") { ?>
									<input type="submit" name="bsimpan" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded w-full" value="SIMPAN">
								<?php } else { ?>
									<input type="submit" name="bubah" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 rounded w-full" value="UBAH">
								<?php } ?>
								<a href="?menu=tarif" class="bg-red-500 hover:bg-yellow-600 text-white font-semibold py-2 rounded w-full text-center">RESET</a>
							</div>
						</form>
					</div>
				</div>
				<div class="w-full md:w-2/3">
					<div class="bg-white shadow rounded-lg">
						<div class="px-6 py-4 border-b border-gray-200 text-lg font-semibold text-gray-700">DAFTAR TARIF</div>
						<div class="p-6">
							<form method="post" class="mb-4">
								<div class="flex items-center space-x-2">
									<input type="text" name="tcari" class="form-input border-gray-300 rounded px-2 py-1 w-full" value="<?php echo @$text ?>" placeholder="Masukan Keyword Pencarian......">
									<button type="submit" name="bcari" class="inline-flex items-center px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4h13M8 4v16m0-16L3 9m5-5l5 5" />
										</svg>CARI</button>
									<button type="submit" name="brefresh" class="inline-flex items-center px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16m16-16v16" />
										</svg>REFRESH</button>
								</div>
							</form>
							<div class="overflow-x-auto">
								<table class="min-w-full divide-y divide-gray-200 border border-gray-300 bg-white rounded-lg">
									<thead class="bg-gray-100">
										<tr>
											<th class="px-3 py-2 text-center font-semibold text-gray-700">No.</th>
											<th class="px-3 py-2 text-center font-semibold text-gray-700">Kode Tarif</th>
											<th class="px-3 py-2 text-center font-semibold text-gray-700">Golongan</th>
											<th class="px-3 py-2 text-center font-semibold text-gray-700">Daya</th>
											<th class="px-3 py-2 text-center font-semibold text-gray-700">Tarif/KWh</th>
											<th class="px-3 py-2 text-center font-semibold text-gray-700" colspan="2">AKSI</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$no = 0;
										$data = $aksi->tampil($table, $cari, "");
										if ($data == "") {
											$aksi->no_record(7);
										} else {
											foreach ($data as $r) {
												$cek = $aksi->cekdata("pelanggan WHERE id_tarif = '$r[id_tarif]'");
												$no++; ?>

												<tr>
													<td class="text-center"><?php echo $no; ?>.</td>
													<td><?php echo $r['kode_tarif'] ?></td>
													<td><?php echo $r['golongan'] ?></td>
													<td><?php echo $r['daya'] ?></td>
													<td><?php $aksi->rupiah($r['tarif_perkwh']) ?></td>
													<?php
													if ($cek > 0) { ?>
														<td>&nbsp;</td>
													<?php } else { ?>
														<td class="text-center">
															<a href="?menu=tarif&hapus&id=<?php echo md5(sha1($r['id_tarif'])); ?>" class="text-red-500 hover:text-red-700" title="Hapus">
																<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
																	<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
																</svg>
															</a>
														</td>
													<?php } ?>
													<td class="text-center">
														<a href="?menu=tarif&edit&id=<?php echo md5(sha1($r['id_tarif'])); ?>" class="text-blue-500 hover:text-blue-700" title="Edit">
															<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
																<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6 6M3 17v4h4l10.293-10.293a1 1 0 00-1.414-1.414L3 17z" />
															</svg>
														</a>
													</td>
												</tr>

										<?php }
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