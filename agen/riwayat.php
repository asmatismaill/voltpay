<?php
if (!isset($_GET['menu'])) {
	header('location:hal_utama.php?menu=riwayat');
}

//dasar
$table = "pembayaran";
$redirect = "?menu=riwayat";

if (isset($_POST['bcari'])) {
	$text = $_POST['tcari'];
	$cari = "WHERE id_agen = '$_SESSION[id_agen]' AND id_pelanggan LIKE '%$text%' OR id_pembayaran LIKE '%$text%' OR jumlah_bayar LIKE '%$text%' OR nama_agen LIKE '%$text%' OR tahun_bayar LIKE '%$text%' OR nama_pelanggan LIKE '%$text%' OR bulan_bayar LIKE '%$text%' OR total_akhir LIKE '%$text%' OR bayar LIKE '%$text%' OR kembali LIKE '%$text%' ";
} else {
	$cari = " WHERE id_agen = '$_SESSION[id_agen]'";
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Riwayat Pembayaran | VoltPay</title>
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-emerald-50 via-white to-blue-50 min-h-screen">
	<div class="max-w-6xl mx-auto py-12 px-2 sm:px-4">
		<div class="rounded-2xl shadow-xl bg-white p-6 sm:p-8">
			<h2 class="font-bold text-2xl mb-1 text-blue-700 tracking-wide text-center">Daftar Riwayat Pembayaran</h2>
			<form method="post" class="flex flex-col md:flex-row gap-4 justify-center items-center my-8">
				<input type="text" name="tcari" class="w-full md:w-96 px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-gray-700" value="<?php echo @$text ?>" placeholder="Cari ID Pembayaran, Pelanggan, Bulan, Tahun, Nama ...">
				<button type="submit" name="bcari" class="px-6 py-3 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold transition">Cari</button>
				<button type="submit" name="brefresh" class="px-6 py-3 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold transition">Reset</button>
			</form>
			<div class="overflow-x-auto">
				<table class="min-w-full text-sm text-left border border-gray-200 rounded-lg overflow-hidden">
					<thead class="bg-gray-100 text-gray-700">
						<tr>
							<th class="py-3 px-2">No.</th>
							<th class="py-3 px-2">ID Pembayaran</th>
							<th class="py-3 px-2">ID Pelanggan</th>
							<th class="py-3 px-2">Nama Pelanggan</th>
							<th class="py-3 px-2">Waktu</th>
							<th class="py-3 px-2">Bulan Bayar</th>
							<th class="py-3 px-2 text-center">Jumlah Bayar</th>
							<th class="py-3 px-2 text-center">Biaya Admin</th>
							<th class="py-3 px-2 text-center">Total Akhir</th>
							<th class="py-3 px-2 text-center">Bayar</th>
							<th class="py-3 px-2 text-center">Kembali</th>
							<th class="py-3 px-2 text-center">Petugas</th>
							<th class="py-3 px-2 text-center">Cetak<br>Struk</th>
						</tr>
					</thead>
					<tbody class="bg-white">
						<?php
						$no = 0;
						$data = $aksi->tampil("qw_pembayaran", $cari, " order by id_pembayaran desc");
						if ($data == "") {
							echo '<tr><td colspan="13" class="text-center py-4 text-gray-500">Tidak ada data pembayaran.</td></tr>';
						} else {
							foreach ($data as $r) {
								$no++; ?>
								<tr class="border-b border-gray-100 hover:bg-blue-50">
									<td class="py-2 px-2 text-center font-semibold text-gray-700"><?php echo $no; ?>.</td>
									<td class="py-2 px-2"><?php echo $r['id_pembayaran']; ?></td>
									<td class="py-2 px-2"><?php echo $r['id_pelanggan']; ?></td>
									<td class="py-2 px-2"><?php echo $r['nama_pelanggan']; ?></td>
									<td class="py-2 px-2"><?php echo $r['waktu_bayar']; ?></td>
									<td class="py-2 px-2"><?php $aksi->bulan($r['bulan_bayar']);
															echo " " . $r['tahun_bayar']; ?></td>
									<td class="py-2 px-2 text-right text-blue-700 font-bold"><?php $aksi->rupiah($r['jumlah_bayar']); ?></td>
									<td class="py-2 px-2 text-right text-blue-700 font-bold"><?php $aksi->rupiah($r['biaya_admin']); ?></td>
									<td class="py-2 px-2 text-right text-green-700 font-bold"><?php $aksi->rupiah($r['total_akhir']); ?></td>
									<td class="py-2 px-2 text-right"><?php $aksi->rupiah($r['bayar']); ?></td>
									<td class="py-2 px-2 text-right"><?php $aksi->rupiah($r['kembali']); ?></td>
									<td class="py-2 px-2 text-center"><?php echo $r['nama_agen'] ?></td>
									<td class="py-2 px-2 text-center">
										<a href="struk.php?id_pelanggan=<?php echo $r['id_pelanggan']; ?>&bulan=<?php echo $r['bulan_bayar']; ?>&tahun=<?php echo $r['tahun_bayar']; ?>" target="_blank" class="inline-block px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs">Cetak</a>
									</td>
								</tr>
						<?php }
						} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>

</html>