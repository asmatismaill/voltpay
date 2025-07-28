<?php
include '../config/koneksi.php';
include '../library/fungsi.php';
date_default_timezone_set("Asia/Jakarta");
session_start();

$aksi = new oop();
$table = "qw_pembayaran";
$bulanini = $_GET['bulan'];
$tahunini = $_GET['tahun'];
$cari = "WHERE MONTH(tgl_bayar) = '$bulanini' AND YEAR(tgl_bayar) ='$tahunini' AND id_agen = '$_SESSION[id_agen]'";
$filename = "Laporan Riwayat Pemabayan Bulan $bulanini TAHUN $tahunini";

$agen = $aksi->caridata("agen WHERE id_agen = '$_SESSION[id_agen]'");

if (isset($_GET['excel'])) {
	header("Content-type:aplication/vnd-ms-excel");
	header("Content-type: application/image/png");
	header("Content-disposition:attachment; filename=" . $filename . ".xls");
}

?>
<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PRINT LAPORAN</title>
	<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
	<style>
		@media print {
			.no-print {
				display: none !important;
			}

			body {
				background: #fff !important;
			}
		}
	</style>
</head>

<body onload="window.print()" class="bg-white text-gray-900 font-sans px-2 py-4">
	<!-- INI BAGIAN HEADER LAPORAN -->
	<div class="max-w-5xl mx-auto">
		<div class="flex items-center gap-4 mb-2">
			<?php if (!isset($_GET['excel'])) { ?>
				<img src="../images/vp.png" alt="Logo VoltPay" class="w-20 h-20 object-contain">
			<?php } ?>
			<div>
				<div class="text-lg font-bold leading-tight">APLIKASI PPOB</div>
				<div class="text-3xl font-extrabold text-blue-700 tracking-wide leading-tight">VOLTPAY</div>
				<div class="text-xs text-gray-600">Jl. Jend. Sudirman RT.5/RW.3, Senayan, Kec. Kby. Baru, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12110</div>
			</div>
		</div>
		<hr class="border-2 border-gray-700 mb-2">
		<div class="text-center mb-4">
			<h3 class="text-xl font-bold">LAPORAN RIWAYAT PEMBAYARAN BULAN <?php $aksi->bulan($bulanini);
																			echo " TAHUN $tahunini"; ?></h3>
		</div>
	</div>
	<!-- INI END BAGIAN HEADER LAPORAN -->

	<!-- INI ISI LAPORAN -->
	<div class="overflow-x-auto max-w-5xl mx-auto mb-8">
		<table class="min-w-full border border-gray-300 rounded-lg text-sm">
			<thead class="bg-gray-100">
				<tr>
					<th class="py-2 px-3 border-b text-center">No.</th>
					<th class="py-2 px-3 border-b">ID Pelanggan</th>
					<th class="py-2 px-3 border-b">Nama Pelanggan</th>
					<th class="py-2 px-3 border-b">Waktu</th>
					<th class="py-2 px-3 border-b">Bulan Bayar</th>
					<th class="py-2 px-3 border-b text-center">Jumlah Bayar</th>
					<th class="py-2 px-3 border-b text-center">Biaya Admin</th>
					<th class="py-2 px-3 border-b text-center">Total Akhir</th>
					<th class="py-2 px-3 border-b text-center">Bayar</th>
					<th class="py-2 px-3 border-b text-center">Kembali</th>
					<th class="py-2 px-3 border-b text-center">Petugas</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$no = 0;
				$data = $aksi->tampil($table, $cari, " order by id_pembayaran desc");
				if ($data == "") {
					echo '<tr><td colspan="11" class="text-center py-4 text-gray-500">Tidak ada data pembayaran.</td></tr>';
				} else {
					foreach ($data as $r) {
						$no++; ?>
						<tr class="hover:bg-gray-50">
							<td class="py-2 px-3 text-center font-semibold text-gray-700"><?php echo $no; ?>.</td>
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
	<!-- INI END ISI LAPORAN -->

	<!-- INI FOOTER LAPORAN -->
	<div class="max-w-5xl mx-auto mt-8">
		<div class="flex flex-col items-end">
			<div class="text-sm text-gray-700 mb-2">Tanggal: <span class="font-semibold"><?php $aksi->hari(date("N"));
																							echo ", ";
																							$aksi->format_tanggal(date("Y-m-d")); ?></span></div>
			<div class="text-sm text-gray-700 mb-2">Hormat Saya,</div>
			<div class="h-8"></div>
			<div class="text-lg font-bold text-gray-900"><?php echo $_SESSION['nama_petugas']; ?></div>
		</div>
	</div>
	<!-- INI END FOOTER LAPORAN -->
</body>

</html>