<?php
if (!isset($_GET['menu'])) {
	header('location:hal_utama.php?menu=laporan');
}

if (isset($_POST['bcari'])) {
	$bulanini = $_POST['bulan'];
	$tahunini = $_POST['tahun'];

	$cari = "WHERE MONTH(tgl_bayar) = '$bulanini' AND YEAR(tgl_bayar) ='$tahunini' AND id_agen = '$_SESSION[id_agen]'";
	$link_print = "print.php?bulan=$bulanini&tahun=$tahunini";
	$link_excel = "print.php?excel&bulan=$bulanini&tahun=$tahunini";
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Laporan | VoltPay</title>
	<link rel="icon" type="image/png" href="../images/vp.png">
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-emerald-50 via-white to-blue-50 min-h-screen">
	<div class="max-w-4xl mx-auto pt-12 pb-8 px-2 sm:px-4">
		<div class="rounded-2xl shadow-xl bg-white">
			<div class="flex flex-col md:flex-row md:items-center justify-between px-6 py-5 border-b">
				<div class="text-2xl font-bold text-blue-700 tracking-wide">Laporan Riwayat Transaksi</div>
				<div class="flex space-x-2 mt-4 md:mt-0">
					<a href="<?php echo $link_print ?>" target="_blank" class="inline-flex items-center px-3 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition">
						<svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
							<path d="M6 9V2h12v7" />
							<rect x="6" y="13" width="12" height="8" rx="2" />
							<path d="M6 17h12" />
						</svg>
						Cetak
					</a>
					<a href="<?php echo $link_excel ?>" target="_blank" class="inline-flex items-center px-3 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white text-sm font-semibold transition">
						<svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
							<path d="M4 4h16v16H4z" />
							<path d="M8 12h8M8 16h8M8 8h8" />
						</svg>
						Export Excel
					</a>
				</div>
			</div>
			<div class="px-6 py-6 bg-gray-50 rounded-b-2xl">
				<form method="post" class="flex flex-col md:flex-row md:items-center gap-4 mb-6">
					<div class="flex items-center gap-2">
						<label for="bulan" class="text-gray-600 font-medium">Bulan</label>
						<select name="bulan" id="bulan" class="block w-28 px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-gray-700">
							<?php
							for ($a = 1; $a <= 12; $a++) {
								if ($a < 10) {
									$b = "0" . $a;
								} else {
									$b = $a;
								} ?>
								<option value="<?php echo $b; ?>" <?php if (@$b == @$bulanini) {
																		echo "selected";
																	} ?>><?php $aksi->bulan($b); ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="flex items-center gap-2">
						<label for="tahun" class="text-gray-600 font-medium">Tahun</label>
						<select name="tahun" id="tahun" class="block w-32 px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-gray-700">
							<?php
							for ($a = date("Y"); $a >= 0; $a--) {
							?>
								<option value="<?php echo $a; ?>" <?php if (@$a == @$tahunini) {
																		echo "selected";
																	} ?>><?php echo @$a; ?></option>
							<?php } ?>
						</select>
					</div>
					<button type="submit" name="bcari" class="inline-flex items-center px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm transition">
						<svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
							<circle cx="11" cy="11" r="8" />
							<path d="M21 21l-4.35-4.35" />
						</svg>
						Cari
					</button>
					<button type="submit" name="brefresh" class="inline-flex items-center px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold text-sm transition">
						<svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
							<path d="M4 4v5h.582M20 20v-5h-.581M5.582 9A7.974 7.974 0 0112 4c2.21 0 4.21.896 5.657 2.343M18.418 15A7.974 7.974 0 0112 20a7.974 7.974 0 01-5.657-2.343" />
						</svg>
						Refresh
					</button>
				</form>
				<?php
				if (isset($_POST['bcari'])) { ?>
					<div class="mb-4">
						<div class="text-center text-lg font-semibold text-blue-700">Laporan Transaksi Bulan <?php $aksi->bulan($bulanini);
																												echo " Tahun " . $tahunini; ?></div>
					</div>
					<div class="overflow-x-auto rounded-lg shadow">
						<table class="min-w-full bg-white text-sm rounded-lg">
							<thead class="bg-gray-100 text-gray-700">
								<tr>
									<th class="py-2 px-3 font-semibold">No.</th>
									<th class="py-2 px-3 font-semibold">ID Pembayaran</th>
									<th class="py-2 px-3 font-semibold">ID Pelanggan</th>
									<th class="py-2 px-3 font-semibold">Nama Pelanggan</th>
									<th class="py-2 px-3 font-semibold">Waktu</th>
									<th class="py-2 px-3 font-semibold">Bulan Bayar</th>
									<th class="py-2 px-3 font-semibold text-right">Jumlah Bayar</th>
									<th class="py-2 px-3 font-semibold text-right">Biaya Admin</th>
									<th class="py-2 px-3 font-semibold text-right">Total Akhir</th>
									<th class="py-2 px-3 font-semibold text-right">Bayar</th>
									<th class="py-2 px-3 font-semibold text-right">Kembali</th>
									<th class="py-2 px-3 font-semibold">Petugas</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$no = 0;
								$data = $aksi->tampil("qw_pembayaran", @$cari, " order by id_pembayaran desc");
								if ($data == "") {
									echo '<tr><td colspan="12" class="text-center py-4 text-gray-500">Tidak ada data pembayaran.</td></tr>';
								} else {
									foreach ($data as $r) {
										$no++; ?>
										<tr class="border-b hover:bg-blue-50">
											<td class="py-2 px-3 text-center font-semibold text-gray-700"><?php echo $no; ?>.</td>
											<td class="py-2 px-3"><?php echo $r['id_pembayaran']; ?></td>
											<td class="py-2 px-3"><?php echo $r['id_pelanggan']; ?></td>
											<td class="py-2 px-3"><?php echo $r['nama_pelanggan']; ?></td>
											<td class="py-2 px-3"><?php echo $r['waktu_bayar']; ?></td>
											<td class="py-2 px-3"><?php $aksi->bulan($r['bulan_bayar']);
																	echo " " . $r['tahun_bayar']; ?></td>
											<td class="py-2 px-3 text-right text-blue-700 font-bold"><?php $aksi->rupiah($r['jumlah_bayar']); ?></td>
											<td class="py-2 px-3 text-right text-blue-700 font-bold"><?php $aksi->rupiah($r['biaya_admin']); ?></td>
											<td class="py-2 px-3 text-right text-green-700 font-bold"><?php $aksi->rupiah($r['total_akhir']); ?></td>
											<td class="py-2 px-3 text-right"><?php $aksi->rupiah($r['bayar']); ?></td>
											<td class="py-2 px-3 text-right"><?php $aksi->rupiah($r['kembali']); ?></td>
											<td class="py-2 px-3 text-center"><?php echo $r['nama_agen'] ?></td>
										</tr>
								<?php }
								} ?>
							</tbody>
						</table>
					</div>
				<?php } else {
					$bulanini = date("m");
					$tahunini = date("Y");
					$cari = "";
				} ?>
			</div>
		</div>
	</div>
</body>

</html>