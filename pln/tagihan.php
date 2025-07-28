<?php
if (!isset($_GET['menu'])) {
	header("location:hal_utama.php?menu=tagihan");
}

$table = "tagihan";
$redirect = "?menu=alamat";

$cari = "";
if (isset($_POST['bcari_text'])) {
	$text = $_POST['tcari'];
	$cari = "WHERE id_pelanggan LIKE '%$text%' OR bulan LIKE '%$text%' OR tahun LIKE '%$text%' OR jumlah_meter LIKE '%$text%' OR tarif_perkwh LIKE '%$text%' OR jumlah_bayar LIKE '%$text%' OR nama_petugas LIKE '%$text%' OR nama_pelanggan LIKE '%$text%' OR status LIKE '%$text%'";
}

if (isset($_POST['bcari'])) {
	$bln_cari = $_POST['bulan'];
	$thn_cari = $_POST['tahun'];
	$status = $_POST['laporan'];
	$cari = "WHERE status = '$status' AND bulan = '$bln_cari'  AND tahun = '$thn_cari'";
}

?>
<!DOCTYPE html>
<html>

<head>
	<title>TAGIHAN</title>
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen">
	<div class="max-w-5xl mx-auto px-4 py-8">
		<div class="bg-white shadow rounded-lg">
			<div class="px-6 py-4 border-b border-gray-200 text-lg font-semibold text-gray-700">DAFTAR TAGIHAN</div>
			<div class="p-6">
				<form method="post" class="flex flex-col md:flex-row md:space-x-6 mb-6">
					<div class="flex-1 mb-4 md:mb-0">
						<label class="block text-gray-700 font-medium mb-1">Filter Perbulan</label>
						<div class="flex flex-wrap items-center space-x-2">
							<span class="text-gray-600 text-sm">JENIS</span>
							<select name="laporan" class="form-select border-gray-300 rounded px-2 py-1">
								<option value="Terbayar" <?php if (@$status == "Terbayar") {
																echo "selected";
															} ?>>Sudah Bayar</option>
								<option value="Belum Bayar" <?php if (@$status == "Belum Bayar") {
																echo "selected";
															} ?>>Belum Bayar</option>
							</select>
							<span class="text-gray-600 text-sm ml-2">BULAN</span>
							<select name="bulan" class="form-select border-gray-300 rounded px-2 py-1">
								<?php
								for ($a = 1; $a <= 12; $a++) {
									if ($a < 10) {
										$b = "0" . $a;
									} else {
										$b = $a;
									} ?>
									<option value="<?php echo $b; ?>" <?php if ($b == @$bln_cari) {
																			echo "selected";
																		} ?>><?php $aksi->bulan($b); ?></option>
								<?php } ?>
							</select>
							<span class="text-gray-600 text-sm ml-2">TAHUN</span>
							<select name="tahun" class="form-select border-gray-300 rounded px-2 py-1">
								<?php
								for ($a = date("Y"); $a < 2031; $a++) {
								?>
									<option value="<?php echo $a; ?>" <?php if ($a == @$thn_cari) {
																			echo "selected";
																		} ?>><?php echo @$a; ?></option>
								<?php } ?>
							</select>
							<button type="submit" name="bcari" class="ml-2 inline-flex items-center px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4h13M8 4v16m0-16L3 9m5-5l5 5" />
								</svg></button>
							<button type="submit" name="brefresh" class="inline-flex items-center px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16m16-16v16" />
								</svg></button>
						</div>
					</div>
					<div class="flex-1">
						<label class="block text-gray-700 font-medium mb-1">Filter Dengan Pencarian</label>
						<div class="flex items-center space-x-2">
							<input type="text" name="tcari" class="form-input border-gray-300 rounded px-2 py-1 w-full" placeholder="Masukan Keyword [bulan 01 = januari, lainnya]" value="<?php echo @$text ?>">
							<button type="submit" name="bcari_text" class="inline-flex items-center px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4h13M8 4v16m0-16L3 9m5-5l5 5" />
								</svg></button>
							<button type="submit" name="brefresh" class="inline-flex items-center px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16m16-16v16" />
								</svg></button>
						</div>
					</div>
				</form>

				<br>
				<hr>
				<div class="mt-8">
					<div class="overflow-x-auto">
						<table class="min-w-full divide-y divide-gray-200 border border-gray-300 bg-white rounded-lg">
							<thead class="bg-gray-100">
								<tr>
									<th class="px-3 py-2 text-center font-semibold text-gray-700">No.</th>
									<th class="px-3 py-2 text-center font-semibold text-gray-700">ID Pelanggan</th>
									<th class="px-3 py-2 text-center font-semibold text-gray-700">Nama Pelanggan</th>
									<th class="px-3 py-2 text-center font-semibold text-gray-700">Bulan</th>
									<th class="px-3 py-2 text-center font-semibold text-gray-700">Jumlah Meter</th>
									<th class="px-3 py-2 text-center font-semibold text-gray-700">Jumlah Bayar</th>
									<th class="px-3 py-2 text-center font-semibold text-gray-700">Nama Petugas</th>
									<th class="px-3 py-2 text-center font-semibold text-gray-700">Status</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$no = 0;
								$a = $aksi->tampil("qw_tagihan", $cari, "ORDER BY status ASC");
								if (empty($a)) {
									$aksi->no_record(8);
								} else {
									foreach ($a as $r) {
										$no++;
								?>
										<tr>
											<td class="text-center"><?php echo $no; ?>.</td>
											<td><?php echo $r['id_pelanggan']; ?></td>
											<td><?php echo $r['nama_pelanggan']; ?></td>
											<td><?php $aksi->bulan($r['bulan']);
												echo " " . $r['tahun']; ?></td>
											<td><?php echo $r['jumlah_meter']; ?></td>
											<td><?php $aksi->rupiah($r['jumlah_bayar']); ?></td>
											<td><?php echo $r['nama_petugas']; ?></td>
											<td><?php echo $r['status']; ?></td>
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
	</div>
</body>

</html>