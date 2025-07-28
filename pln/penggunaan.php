<?php
if (!isset($_GET['menu'])) {
	header('location:hal_utama.php?menu=penggunaan');
}
include '../config/koneksi.php';
global $koneksi;
//dasar
$table = "penggunaan";
$id = isset($_GET['id']) ? $_GET['id'] : '';
$where = " id_penggunaan = '$id'";
$redirect = "?menu=penggunaan";

if (isset($_POST['id_pelanggan'])) {
	$id_pel = $_POST['id_pelanggan'];
	$penggunaan = $aksi->caridata("penggunaan WHERE id_pelanggan = '$id_pel' AND meter_akhir = '0'");
	if ($penggunaan == "") {
		$aksi->pesan('Data Bulan ini sudah diinput');
	}
} elseif (isset($_GET['hapus']) or isset($_GET['edit'])) {
	$penggunaan = $aksi->caridata("penggunaan WHERE id_penggunaan = '$id'");
	$id_pel = $penggunaan['id_pelanggan'];
}

@$pelanggan = $aksi->caridata("pelanggan WHERE id_pelanggan = '$id_pel'");
@$tarif = $aksi->caridata("tarif WHERE id_tarif = '$pelanggan[id_tarif]'");
@$tarif_perkwh = $tarif['tarif_perkwh'];
@$id_guna = $penggunaan['id_penggunaan'];
@$mawal = $penggunaan['meter_awal'];
@$bulan = $penggunaan['bulan'];
@$tahun = $penggunaan['tahun'];

if ($bulan == 12) {
	if ($bulan < 10) {
		$bln = ($bulan + 1);
		$next_bulan = "0" . $bln;
	} else {
		$next_bulan = $bulan + 1;
	}
	$next_tahun = $tahun + 1;
} else {
	if ($bulan < 10) {
		$bln = ($bulan + 1);
		$next_bulan = "0" . $bln;
	} else {
		$next_bulan = $bulan + 1;
	}
	$next_tahun = $tahun;
}
// echo $next_tahun."-".$next_bulan."-".$mawal."-".@$id_pel."<br>";

@$id_pelanggan = $_POST['id_pelanggan'];
@$meter_akhir = $_POST['meter_akhir'];
@$meter_awal = $_POST['meter_awal'];
@$tgl_cek = $_POST['tgl_cek'];
@$jumlah_meter = ($meter_akhir - $mawal);
@$jumlah_bayar = ($jumlah_meter * $tarif_perkwh);
@$id_penggunaan_next = $id_pel . $next_bulan . $next_tahun;

// echo $id_penggunaan_next."-".$tahun."-".$bulan;
@$field_next = array(
	'id_penggunaan' => $id_penggunaan_next,
	'id_pelanggan' => $id_pelanggan,
	'bulan' => $next_bulan,
	'tahun' => $next_tahun,
	'meter_awal' => $meter_akhir,
);


@$field = array(
	'meter_akhir' => $meter_akhir,
	'tgl_cek' => $tgl_cek,
	'id_petugas' => $_SESSION['id_petugas'],
);

@$field_update = array('meter_awal' => $meter_akhir,);

@$field_tagihan = array(
	'id_pelanggan' => $id_pelanggan,
	'bulan' => $bulan,
	'tahun' => $tahun,
	'jumlah_meter' => $jumlah_meter,
	'tarif_perkwh' => $tarif_perkwh,
	'jumlah_bayar' => $jumlah_bayar,
	'status' => "Belum Bayar",
	'id_petugas' => $_SESSION['id_petugas'],
);

@$field_tagihan_update = array(
	'jumlah_meter' => $jumlah_meter,
	'tarif_perkwh' => $tarif_perkwh,
	'jumlah_bayar' => $jumlah_bayar,
	'status' => "Belum Bayar",
	'id_petugas' => $_SESSION['id_petugas'],
);

if (isset($_POST['bsimpan'])) {
	if ($meter_akhir <= $meter_awal) {
		$aksi->pesan("Meter Akhir Tidak Mungkin Kurang dari Meter Awal");
	} else {
		$aksi->simpan("tagihan", $field_tagihan);
		$aksi->update($table, $field, "id_penggunaan = '$id_guna'");
		$aksi->simpan($table, $field_next);
		$aksi->alert("Data Berhasil Disimpan", $redirect);
	}
}


if (isset($_POST['bubah'])) {
	// echo "<br>".$id_penggunaan_next."-".$bulan."-".$tahun;
	$aksi->update($table, $field_update, "id_penggunaan = '$id_penggunaan_next'");
	$aksi->update("tagihan", $field_tagihan_update, "id_pelanggan = '$id_pel' AND bulan = '$bulan' AND tahun = '$tahun'");
	$aksi->update($table, $field, $where);
	$aksi->alert("Data Berhasil Diubah", $redirect);
}

if (isset($_GET['edit'])) {
	$edit = $aksi->edit($table, $where);
}

if (isset($_GET['hapus'])) {
	$aksi->update(
		"penggunaan",
		array(
			'meter_akhir' => 0,
			'tgl_cek' => "",
			'id_petugas' => "",
		),
		$where
	);
	$aksi->hapus("penggunaan", "id_penggunaan = '$id_penggunaan_next'");
	$aksi->hapus("tagihan", "id_pelanggan = '$id_pel' AND bulan = '$bulan' AND tahun = '$tahun'");
	$aksi->alert("Data Berhasil Dihapus", $redirect);
}

if (isset($_POST['bcari'])) {
	$text = $_POST['tcari'];
	$cari = "WHERE id_pelanggan LIKE '%$text%' OR id_penggunaan LIKE '%$text%' OR meter_awal LIKE '%$text%' OR meter_akhir LIKE '%$text%' OR tahun LIKE '%$text%' OR nama_pelanggan LIKE '%$text%' OR nama_petugas LIKE '%$text%'";
} else {
	$cari = " WHERE meter_akhir != 0";
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>PENGGUNAAN | VoltPay</title>
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen">
	<div class="max-w-5xl mx-auto px-4 py-8">
		<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
			<div>
				<div class="bg-white shadow-xl rounded-2xl">
					<div class="px-6 py-4 border-b border-gray-200 text-lg font-semibold text-gray-700">
						<?php if (!@$_GET['id']) { ?>INPUT PENGGUNAAN<?php } else { ?>UBAH PENGGUNAAN - <?php echo @$id; ?><?php } ?>
					</div>
					<div class="p-6">
						<form method="post" class="space-y-4">
							<div>
								<label class="block text-gray-700 font-medium mb-1">ID PELANGGAN <span class="text-blue-500 text-xs">[TEKAN TAB]</span></label>
								<input type="text" name="id_pelanggan" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none" placeholder="Masukan ID Pelanggan" onchange="submit()" required value="<?php if (@$_GET['id'] == "") {
																																																																	echo @$id_pel;
																																																																} else {
																																																																	echo @$edit['id_pelanggan'];
																																																																} ?>" list="id_pel" onkeypress='return event.charCode >=48 && event.charCode <=57' <?php if (@$_GET['id']) {
																																																																																																											echo "readonly";
																																																																																																										} ?>>
								<datalist id="id_pel">
									<?php $a = mysqli_query($koneksi, "SELECT * FROM pelanggan");
									while ($b = mysqli_fetch_array($a)) { ?>
										<option value="<?php echo $b['id_pelanggan'] ?>"><?php echo $b['nama']; ?></option>
									<?php } ?>
								</datalist>
							</div>
							<div>
								<label class="block text-gray-700 font-medium mb-1">BULAN PENGGUNAAN</label>
								<input type="text" name="no_meter" class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-100" placeholder="Bulan penggunaan" required readonly value="<?php if (@$_GET['id'] == "") {
																																																		@$aksi->bulan(@$bulan);
																																																		echo " " . @$tahun;
																																																	} else {
																																																		@$aksi->bulan(@$edit['bulan']);
																																																		echo " " . @$edit['tahun'];
																																																	} ?>">
							</div>
							<div>
								<label class="block text-gray-700 font-medium mb-1">METER AWAL</label>
								<input type="text" name="meter_awal" class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-100" placeholder="Meter Awal" required readonly value="<?php if (@$_GET['id'] == "") {
																																																	echo @$mawal;
																																																} else {
																																																	echo @$edit['meter_awal'];
																																																} ?>">
							</div>
							<div>
								<label class="block text-gray-700 font-medium mb-1">METER AKHIR</label>
								<input type="text" name="meter_akhir" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none" placeholder="Masukan Meter Akhir" required value="<?php echo @$edit['meter_akhir']; ?>" onkeypress='return event.charCode >=48 && event.charCode <=57'>
							</div>
							<div>
								<label class="block text-gray-700 font-medium mb-1">TANGGAL PENGECEKAN</label>
								<input type="date" name="tgl_cek" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none" placeholder="Masukan Nama" required value="<?php echo @$edit['tgl_cek'] ?>">
							</div>
							<div class="flex flex-col space-y-2 mt-4">
								<?php if (@$_GET['id'] == "") { ?>
									<input type="submit" name="bsimpan" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded w-full" value="SIMPAN">
								<?php } else { ?>
									<input type="submit" name="bubah" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded w-full" value="UBAH">
								<?php } ?>
								<a href="?menu=penggunaan" class="bg-red-500 hover:bg-yellow-600 text-white font-semibold py-2 rounded w-full text-center">RESET</a>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div>
				<div class="bg-white shadow-xl rounded-2xl">
					<div class="px-6 py-4 border-b border-gray-200 text-lg font-semibold text-gray-700">DAFTAR PENGGUNAAN</div>
					<div class="p-6">
						<form method="post" class="mb-4">
							<div class="flex items-center gap-2">
								<input type="text" name="tcari" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none" value="<?php echo @$text ?>" placeholder="Masukan Keyword Pencarian (Kode Penggunaan, ID Pelanggan, Bulan[contoh : 01,09,12], Tahun, Nama Pelanggan, Nama Petugas) ......">
								<button type="submit" name="bcari" class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-semibold transition"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4h13M8 4v16m0-16L3 9m5-5l5 5" />
									</svg>CARI</button>
								<button type="submit" name="brefresh" class="inline-flex items-center px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm font-semibold transition"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16m16-16v16" />
									</svg>REFRESH</button>
							</div>
						</form>
						<div class="overflow-x-auto">
							<table class="min-w-full border border-gray-300 rounded-lg text-sm">
								<thead class="bg-blue-100">
									<tr>
										<th class="py-2 px-3 border">No.</th>
										<th class="py-2 px-3 border">Kode Penggunaan</th>
										<th class="py-2 px-3 border">ID Pelanggan</th>
										<th class="py-2 px-3 border">Nama</th>
										<th class="py-2 px-3 border">Bulan</th>
										<th class="py-2 px-3 border">Meter Awal</th>
										<th class="py-2 px-3 border">Meter Akhir</th>
										<th class="py-2 px-3 border">Tanggal Cek</th>
										<th class="py-2 px-3 border">Petugas</th>
										<th class="py-2 px-3 border">AKSI</th>
									</tr>
								</thead>
								<tbody>
									<?php $no = 0;
									$data = $aksi->tampil("qw_penggunaan", $cari, "ORDER BY tgl_cek DESC");
									if ($data == "") {
										$aksi->no_record(8);
									} else {
										foreach ($data as $r) {
											$cek = $aksi->cekdata("tagihan WHERE id_pelanggan = '$r[id_pelanggan]' AND bulan = '$r[bulan]' AND tahun = '$r[tahun]' AND status = 'Belum Bayar'");
											$no++; ?>
											<tr class="hover:bg-gray-50">
												<td class="border text-center py-1 px-2"><?php echo $no; ?>.</td>
												<td class="border py-1 px-2"><?php echo $r['id_penggunaan'] ?></td>
												<td class="border py-1 px-2"><?php echo $r['id_pelanggan'] ?></td>
												<td class="border py-1 px-2"><?php echo $r['nama_pelanggan'] ?></td>
												<td class="border py-1 px-2"><?php $aksi->bulan($r['bulan']);
																				echo " " . $r['tahun']; ?></td>
												<td class="border py-1 px-2"><?php echo $r['meter_awal'] ?></td>
												<td class="border py-1 px-2"><?php echo $r['meter_akhir'] ?></td>
												<td class="border py-1 px-2"><?php $aksi->format_tanggal($r['tgl_cek']); ?></td>
												<td class="border py-1 px-2"><?php echo $r['nama_petugas'] ?></td>
												<?php if ($cek == 0) { ?>
													<td class="border"></td>
												<?php } else { ?>
													<td class="border text-center">
														<a href="?menu=penggunaan&hapus&id=<?php echo $r['id_penggunaan']; ?>" class="text-red-500 hover:text-red-700" title="Hapus">
															<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
																<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
															</svg>
														</a>
													</td>
												<?php } ?>
											</tr>
									<?php }
									} ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>