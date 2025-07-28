<?php
include '../config/koneksi.php';
global $koneksi;
/*
File: pelanggan.php
Deskripsi: Modul manajemen data pelanggan
Dibuat: 18 Juli 2025
Pembuat: Asmat Ismail Marzuki
*/

if (!isset($_GET['menu'])) {
	header('location:hal_utama.php?menu=pelanggan');
}
//dasar
$table = "pelanggan";
$id = isset($_GET['id']) ? $_GET['id'] : '';
$where = " md5(sha1(id_pelanggan)) = '$id'";
$redirect = "?menu=pelanggan";

//kode auto
$id_pel = date("YmdHis");
if (date('z') < 10) {
	$no_met = "00" . date("zymNHs");
} elseif (date('z') < 100) {
	$no_met = "0" . date("zymNHs");
} else {
	$no_met = date("zymNHs");
}

//untuk kebutuhan crud
$tenggang = date("d");
$id_pelanggan = isset($_POST['id_pelanggan']) ? $_POST['id_pelanggan'] : '';
$no_meter = isset($_POST['no_meter']) ? $_POST['no_meter'] : '';
$nama = isset($_POST['nama']) ? $_POST['nama'] : '';
$alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
$id_tarif = isset($_POST['id_tarif']) ? $_POST['id_tarif'] : '';
//tampung data
$simpan_pelanggan = array(
	'id_pelanggan' => $id_pelanggan,
	'no_meter' => $no_meter,
	'nama' => $nama,
	'alamat' => $alamat,
	'tenggang' => $tenggang,
	'id_tarif' => $id_tarif,
);

$ubah_pelanggan = array(
	'nama' => $nama,
	'alamat' => $alamat,
	'id_tarif' => $id_tarif,
);

//untuk penggunaan default meter awal
if (date("d") > 25) {
	if (date("m") < 10) {
		$bln = date("m") + 1;
		$bulan = "0" . $bln;
	} else {
		$bulan = date("m") + 1;
	}
	$tahun = date("Y");
} elseif (date("d") > 25 && date("m") == 12) {
	$bln = date("m") + 1;
	$bulan = "0" . $bln;
	$tahun = date("Y") + 1;
} else {
	$bulan = date("m");
	$tahun = date("Y");
}

$simpan_penggunaan = array(
	'id_penggunaan' => $id_pelanggan . $bulan . $tahun,
	'id_pelanggan' => $id_pelanggan,
	'bulan' => $bulan,
	'tahun' => $tahun,
	'meter_awal' => 0,
);

if (isset($_POST['bsimpan'])) {
	$aksi->simpan("penggunaan", $simpan_penggunaan);
	$aksi->simpan($table, $simpan_pelanggan);
	$aksi->alert("Data Berhasil Disimpan", $redirect);
}

if (isset($_POST['bubah'])) {
	$aksi->update($table, $ubah_pelanggan, $where);
	$aksi->alert("Data Berhasil Diubah", $redirect);
}

if (isset($_GET['edit'])) {
	$edit = $aksi->edit($table, $where);
}

if (isset($_GET['hapus'])) {
	$aksi->hapus("penggunaan", "id_pelanggan = '$id'");
	$aksi->hapus($table, $where);
	$aksi->alert("Data Berhasil Dihapus", $redirect);
}

if (isset($_POST['bcari'])) {
	$text = $_POST['tcari'];
	$cari = "WHERE id_pelanggan LIKE '%$text%' OR nama LIKE '%$text%' OR no_meter LIKE '%$text%' OR alamat LIKE '%$text%' OR tenggang LIKE '%$text%'";
} else {
	$cari = "";
}

?>
<!DOCTYPE html>
<html>

<head>
	<title>PELANGGAN</title>
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen">
	<div class="max-w-7xl mx-auto px-4 py-8">
		<div class="flex flex-col md:flex-row md:space-x-8">
			<div class="w-full md:w-1/3 mb-8 md:mb-0">
				<div class="bg-white shadow rounded-lg">
					<?php if (!isset($_GET['id'])) { ?>
						<div class="px-6 py-4 border-b border-gray-200 text-lg font-semibold text-gray-700">INPUT PELANGGAN</div>
					<?php } else { ?>
						<div class="px-6 py-4 border-b border-gray-200 text-lg font-semibold text-gray-700">UBAH PELANGGAN</div>
					<?php } ?>
					<div class="p-6">
						<form method="post" class="space-y-4">
							<div>
								<label class="block text-gray-700 font-medium mb-1">ID PELANGGAN</label>
								<input type="text" name="id_pelanggan" class="form-input border-gray-300 rounded px-2 py-1 w-full" placeholder="Masukan ID Pelanggan" required readonly value="<?php if (!isset($_GET['id'])) {
																																																	echo $id_pel;
																																																} else {
																																																	echo isset($edit['id_pelanggan']) ? $edit['id_pelanggan'] : '';
																																																} ?>">
							</div>
							<div>
								<label class="block text-gray-700 font-medium mb-1">NO.METER</label>
								<input type="text" name="no_meter" class="form-input border-gray-300 rounded px-2 py-1 w-full" placeholder="Masukan NO.METER" required readonly value="<?php if (!isset($_GET['id'])) {
																																															echo $no_met;
																																														} else {
																																															echo isset($edit['no_meter']) ? $edit['no_meter'] : '';
																																														} ?>">
							</div>
							<div>
								<label class="block text-gray-700 font-medium mb-1">NAMA</label>
								<input type="text" name="nama" class="form-input border-gray-300 rounded px-2 py-1 w-full" placeholder="Masukan Nama" required value="<?php echo isset($edit['nama']) ? $edit['nama'] : ''; ?>">
							</div>
							<div>
								<label class="block text-gray-700 font-medium mb-1">ALAMAT</label>
								<textarea name="alamat" class="form-input border-gray-300 rounded px-2 py-1 w-full" required rows="3"><?php echo isset($edit['alamat']) ? $edit['alamat'] : ''; ?></textarea>
							</div>
							<div>
								<label class="block text-gray-700 font-medium mb-1">JENIS TARIF</label>
								<select name="id_tarif" class="form-select border-gray-300 rounded px-2 py-1 w-full" required>
									<?php
									$b = $aksi->caridata("tarif WHERE id_tarif = '" . (isset($edit['id_tarif']) ? $edit['id_tarif'] : '') . "'");
									if (isset($_GET['id'])) { ?>
										<option selected value="<?php echo $b['id_tarif'] ?>"><?php echo $b['kode_tarif']; ?></option>
									<?php } ?>
									<option></option>
									<?php
									$a = mysqli_query($koneksi, "SELECT * FROM tarif");
									while ($tarif = mysqli_fetch_array($a)) { ?>
										<option value="<?php echo $tarif['id_tarif'] ?>"><?php echo $tarif['kode_tarif']; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="flex flex-col space-y-2 mt-4">
								<?php
								if (!isset($_GET['id'])) { ?>
									<input type="submit" name="bsimpan" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded w-full" value="SIMPAN">
								<?php } else { ?>
									<input type="submit" name="bubah" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 rounded w-full" value="UBAH">
								<?php } ?>
								<a href="?menu=pelanggan" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 rounded w-full text-center">RESET</a>
							</div>
					</div>
					</form>
				</div>
				<div class="w-full md:w-2/3">
					<div class="bg-white shadow rounded-lg">
						<div class="px-6 py-4 border-b border-gray-200 text-lg font-semibold text-gray-700">DAFTAR PELANGGAN</div>
						<div class="p-6">
							<form method="post" class="mb-4">
								<div class="flex items-center space-x-2">
									<input type="text" name="tcari" class="form-input border-gray-300 rounded px-2 py-1 w-full" value="<?php echo isset($text) ? $text : '' ?>" placeholder="Masukan Keyword Pencarian......">
									<button type="submit" name="bcari" class="inline-flex items-center px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4h13M8 4v16m0-16L3 9m5-5l5 5" />
										</svg>CARI</button>
									<button type="submit" name="brefresh" class="inline-flex items-center px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16m16-16v16" />
										</svg>REFRESH</button>
								</div>
							</form>
							<div class="text-sm text-red-600 mb-2">* Jika kolom berwarna merah, Pelanggan memiliki tunggakan &ge; 3 bulan</div>
							<div class="overflow-x-auto">
								<table class="min-w-full divide-y divide-gray-200 border border-gray-300 bg-white rounded-lg">
									<thead class="bg-gray-100">
										<tr>
											<th class="px-3 py-2 text-center font-semibold text-gray-700">No.</th>
											<th class="px-3 py-2 text-center font-semibold text-gray-700">ID Pelanggan</th>
											<th class="px-3 py-2 text-center font-semibold text-gray-700">No.Meter</th>
											<th class="px-3 py-2 text-center font-semibold text-gray-700">Nama</th>
											<th class="px-3 py-2 text-center font-semibold text-gray-700">Alamat</th>
											<th class="px-3 py-2 text-center font-semibold text-gray-700">Tenggang</th>
											<th class="px-3 py-2 text-center font-semibold text-gray-700">Kode Tarif</th>
											<th class="px-3 py-2 text-center font-semibold text-gray-700" colspan="2">AKSI</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$no = 0;
										$data = $aksi->tampil($table, $cari, "");
										if ($data == "") {
											$aksi->no_record(9);
										} else {
											foreach ($data as $r) {
												$a = $aksi->caridata("tarif WHERE id_tarif = '$r[id_tarif]'");
												$cek = $aksi->cekdata("penggunaan WHERE id_pelanggan ='$r[id_pelanggan]' AND meter_awal = '0' AND meter_akhir = '0'");
												$cek2 = $aksi->cekdata("tagihan WHERE id_pelanggan = '$r[id_pelanggan]' AND status = 'Belum Bayar'");
												$no++; ?>
												<tr<?php if ($cek2 >= 3) {
														echo ' class="bg-red-100"';
													} ?>>
													<td class="text-center"><?php echo $no; ?>.</td>
													<td><?php echo $r['id_pelanggan'] ?></td>
													<td><?php echo $r['no_meter'] ?></td>
													<td><?php echo $r['nama'] ?></td>
													<td><?php echo $r['alamat'] ?></td>
													<td><?php echo $r['tenggang'] ?></td>
													<td><?php echo $a['kode_tarif'] ?></td>
													<?php
													if ($cek == 0) { ?>
														<td>&nbsp;</td>
													<?php } else { ?>
														<td class="text-center">
															<a href="?menu=pelanggan&hapus&id=<?php echo md5(sha1($r['id_pelanggan'])); ?>" class="text-red-500 hover:text-red-700" title="Hapus">
																<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
																	<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
																</svg>
															</a>
														</td>
													<?php } ?>
													<td class="text-center">
														<a href="?menu=pelanggan&edit&id=<?php echo md5(sha1($r['id_pelanggan'])); ?>" class="text-blue-500 hover:text-blue-700" title="Edit">
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