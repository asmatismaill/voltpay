<?php
include '../config/koneksi.php';
include '../library/fungsi.php';
date_default_timezone_set("Asia/Jakarta");
session_start();

$aksi = new oop();
global $koneksi;

if (isset($_GET['tarif'])) {
	$table = "tarif";
	$cari = "";
	$judul = "LAPORAN DAFTAR TARIF";
	$filename = $judul;

	if (isset($_GET['excel'])) {
		header("Content-type:aplication/vnd-ms-excel");
		header("Content-type: application/image/png");
		header("Content-disposition:attachment; filename=" . $filename . ".xls");
	}
} elseif (isset($_GET['pelanggan'])) {
	$table = "pelanggan";
	$cari = "";
	$judul = "LAPORAN DAFTAR PELANGGAN";
	$filename = $judul;
	if (isset($_GET['excel'])) {
		header("Content-type:aplication/vnd-ms-excel");
		header("Content-type: application/image/png");
		header("Content-disposition:attachment; filename=" . $filename . ".xls");
	}
} elseif (isset($_GET['agen'])) {
	$table = "agen";
	$cari = "";
	$judul = "LAPORAN DAFTAR AGEN";
	$filename = $judul;
	if (isset($_GET['excel'])) {
		header("Content-type:aplication/vnd-ms-excel");
		header("Content-type: application/image/png");
		header("Content-disposition:attachment; filename=" . $filename . ".xls");
	}
} elseif (isset($_GET['tagihan_bulan'])) {
	$status = $_GET['status'];
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$table = "qw_tagihan";
	$cari = "WHERE status = '$status' AND bulan = '$bulan' AND tahun ='$tahun'";
	$judul = "LAPORAN TAGIHAN " . strtoupper($status) . " BULAN $bulan TAHUN $tahun";
	$filename = $judul;
	if (isset($_GET['excel'])) {
		header("Content-type:aplication/vnd-ms-excel");
		header("Content-type: application/image/png");
		header("Content-disposition:attachment; filename=" . $filename . ".xls");
	}
} elseif (isset($_GET['tunggakan'])) {
	$table = "pelanggan";
	$cari = "";
	$judul = "LAPORAN PELANGGAN YANG MEMILIKI TUNGGAKAN LEBIH DARI 3 BULAN";
	$filename = $judul;
	if (isset($_GET['excel'])) {
		header("Content-type:aplication/vnd-ms-excel");
		header("Content-type: application/image/png");
		header("Content-disposition:attachment; filename=" . $filename . ".xls");
	}
} elseif (isset($_GET['riwayat_penggunaan'])) {
	$table = "qw_tagihan";
	$id_pelanggan = $_GET['id_pelanggan'];
	$tahun = $_GET['tahun'];
	$pelanggan = $aksi->caridata("pelanggan WHERE id_pelanggan = '$id_pelanggan'");

	$cari = "WHERE id_pelanggan = '$id_pelanggan' AND tahun = '$tahun'";

	$judul = "LAPORAN RIWAYAT PENGGUNNAN " . strtoupper($pelanggan['nama']) . " ($id_pelanggan) PADA TAHUN $tahun";
	$filename = $judul;
	if (isset($_GET['excel'])) {
		header("Content-type:aplication/vnd-ms-excel");
		header("Content-type: application/image/png");
		header("Content-disposition:attachment; filename=" . $filename . ".xls");
	}
}

?>
<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>PRINT LAPORAN</title>
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white font-sans min-h-screen p-4">
	<!-- INI BAGIAN HEADER LAPORAN -->
	<div class="max-w-5xl mx-auto">
		<div class="flex items-center gap-4 mb-2">
			<?php if (!isset($_GET['excel'])) { ?>
				<img src="../images/logo_pln.png" class="w-20 h-20 object-contain" alt="PLN Logo">
			<?php } ?>
			<div>
				<div class="text-xs sm:text-sm text-gray-500 font-semibold">PERUSAHAAN LISTRIK MILIK NEGARA</div>
				<div class="text-2xl sm:text-3xl font-bold text-blue-700 leading-tight">PT. PLN PERSERO</div>
				<div class="text-xs sm:text-sm text-gray-500">JL. Kapten Muslihat No.2, Paledang, Bogor Tengah, Kota Bogor, Jawa Barat 16122</div>
			</div>
		</div>
		<hr class="border-2 border-black mb-4">
		<div class="text-center mb-6">
			<?php if (isset($_GET['tagihan_bulan'])) { ?>
				<h3 class="text-lg sm:text-xl font-bold text-gray-700">
					<?php echo "LAPORAN TAGIHAN " . strtoupper($status) . " BULAN ";
					$aksi->bulan($bulan);
					echo " TAHUN $tahun"; ?>
				</h3>
			<?php } else { ?>
				<h3 class="text-lg sm:text-xl font-bold text-gray-700"><?php echo @$judul; ?></h3>
			<?php } ?>
		</div>
	</div>
	<!-- INI END BAGIAN HEADER LAPORAN -->

	<!-- ISI LAPORAN -->
	<?php if (isset($_GET['tarif'])) { ?>
		<div class="overflow-x-auto">
			<table class="min-w-full border border-gray-300 rounded-lg text-sm">
				<thead class="bg-blue-100">
					<tr>
						<th class="py-2 px-3 border">No.</th>
						<th class="py-2 px-3 border">Kode Tarif</th>
						<th class="py-2 px-3 border">Golongan</th>
						<th class="py-2 px-3 border">Daya</th>
						<th class="py-2 px-3 border">Tarif/KWh</th>
					</tr>
				</thead>
				<tbody>
					<?php $no = 0;
					$data = $aksi->tampil($table, $cari, "ORDER BY golongan ASC");
					if ($data == "") {
						$aksi->no_record(5);
					} else {
						foreach ($data as $r) {
							$no++; ?>
							<tr class="hover:bg-gray-50">
								<td class="border text-center py-1 px-2"><?php echo $no; ?>.</td>
								<td class="border text-center py-1 px-2"><?php echo $r['kode_tarif'] ?></td>
								<td class="border text-center py-1 px-2"><?php echo $r['golongan'] ?></td>
								<td class="border text-center py-1 px-2"><?php echo $r['daya'] ?></td>
								<td class="border text-right py-1 px-2"><?php $aksi->rupiah($r['tarif_perkwh']) ?></td>
							</tr>
					<?php }
					} ?>
				</tbody>
			</table>
		</div>

	<?php } elseif (isset($_GET['pelanggan'])) { ?>
		<table width="100%" border="1" cellspacing="0" cellpadding="3">
			<thead>
				<th>
					<center>No.</center>
				</th>
				<th>
					<center>ID Pelanggan</center>
				</th>
				<th>
					<center>No.Meter</center>
				</th>
				<th>
					<center>Nama</center>
				</th>
				<th>
					<center>Alamat</center>
				</th>
				<th>
					<center>Tenggang</center>
				</th>
				<th>
					<center>Kode Tarif</center>
				</th>
			</thead>
			<tbody>
				<?php
				$no = 0;
				$data = $aksi->tampil($table, $cari, "ORDER BY id_pelanggan");
				if ($data == "") {
					$aksi->no_record(9);
				} else {
					foreach ($data as $r) {
						$a = $aksi->caridata("tarif WHERE id_tarif = '$r[id_tarif]'");
						$no++; ?>
						<tr>
							<td align="center"><?php echo $no; ?>.</td>
							<td align="center"><?php echo $r['id_pelanggan'] ?></td>
							<td align="center"><?php echo $r['no_meter'] ?></td>
							<td><?php echo $r['nama'] ?></td>
							<td><?php echo $r['alamat'] ?></td>
							<td align="center"><?php echo $r['tenggang'] ?></td>
							<td align="center"><?php echo $a['kode_tarif'] ?></td>
						</tr>

				<?php }
				} ?>
			</tbody>
		</table>

	<?php } elseif (isset($_GET['agen'])) { ?>
		<table width="100%" border="1" cellspacing="0" cellpadding="3">
			<thead>
				<th width="5%">
					<center>No.</center>
				</th>
				<th width="13%">
					<center>ID Agen</center>
				</th>
				<th width="20%">
					<center>Nama</center>
				</th>
				<th width="12%">
					<center>No.Telepon</center>
				</th>
				<th>
					<center>Alamat</center>
				</th>
				<th width="12%">
					<center>Biaya Admin</center>
				</th>
			</thead>
			<tbody>
				<?php
				$no = 0;
				$a = $aksi->tampil($table, $cari, "ORDER BY id_agen DESC");
				if ($a == "") {
					$aksi->no_record(7);
				} else {
					foreach ($a as $r) {
						$cek = $aksi->cekdata(" pembayaran WHERE id_agen = '$r[id_agen]'");
						$no++;
				?>
						<tr>
							<td align="center"><?php echo $no; ?>.</td>
							<td align="center"><?php echo $r['id_agen']; ?></td>
							<td><?php echo $r['nama']; ?></td>
							<td align="center"><?php echo $r['no_telepon']; ?></td>
							<td><?php echo $r['alamat']; ?></td>
							<td align="right"><?php $aksi->rupiah($r['biaya_admin']); ?></td>
						</tr>

				<?php	}
				} ?>
			</tbody>
		</table>

	<?php } elseif (isset($_GET['tagihan_bulan'])) { ?>
		<table width="100%" border="1" cellspacing="0" cellpadding="3">
			<thead>
				<th>
					<center>No.</center>
				</th>
				<th>
					<center>ID Pelanggan</center>
				</th>
				<th>
					<center>Nama Pelanggan</center>
				</th>
				<th>
					<center>Bulan</center>
				</th>
				<th>
					<center>Jumlah Meter</center>
				</th>
				<th>
					<center>Jumlah Bayar</center>
				</th>
				<th>
					<center>Status</center>
				</th>
				<th>
					<center>Petugas</center>
				</th>
			</thead>
			<tbody>
				<?php
				$no = 0;
				$data = $aksi->tampil($table, $cari, "");
				if ($data == "") {
					$aksi->no_record(8);
				} else {
					foreach ($data as $r) {
						$no++;
				?>
						<tr>
							<td align="center"><?php echo $no; ?>.</td>
							<td align="center"><?php echo $r['id_pelanggan'] ?></td>
							<td><?php echo $r['nama_pelanggan'] ?></td>
							<td><?php $aksi->bulan($r['bulan']);
								echo " " . $r['tahun']; ?></td>
							<td align="center"><?php echo $r['jumlah_meter'] ?></td>
							<td align="right"><?php $aksi->rupiah($r['jumlah_bayar']) ?></td>
							<td align="center"><?php echo $r['status']; ?></td>
							<td align="center"><?php echo $r['nama_petugas']; ?></td>
						</tr>

				<?php }
				} ?>
			</tbody>
		</table>

	<?php } elseif (isset($_GET['tunggakan'])) { ?>
		<table width="100%" border="1" cellspacing="0" cellpadding="3">
			<thead>
				<th>
					<center>No.</center>
				</th>
				<th>
					<center>ID Pelanggan</center>
				</th>
				<th>
					<center>Nama Pelanggan</center>
				</th>
				<th>
					<center>Alamat</center>
				</th>
				<th>
					<center>Banyak Tunggakan</center>
				</th>
				<th>
					<center>Bulan</center>
				</th>
				<th>
					<center>Total Meter</center>
				</th>
				<th>
					<center>Tarif/Kwh</center>
				</th>
				<th>
					<center>Total Tunggakan</center>
				</th>
			</thead>

			<tbody>
				<?php
				$no = 0;
				$data = $aksi->tampil($table, $cari, "ORDER BY nama ASC");
				if ($data == "") {
					$aksi->no_record(8);
				} else {
					foreach ($data as $r) {
						$cek = $aksi->cekdata("tagihan WHERE id_pelanggan = '$r[id_pelanggan]' AND status = 'Belum Bayar'");
				?>
						<?php
						if ($cek >= 3) {
							$no++;
							$sum = mysqli_fetch_array($koneksi->query("SELECT id_pelanggan,COUNT(bulan) as bln_tunggak,sum(jumlah_bayar) jml_bayar,SUM(jumlah_meter) as jml_meter,tarif_perkwh FROM tagihan WHERE id_pelanggan = '$r[id_pelanggan]' AND status = 'Belum Bayar'"));
							$bulan = $koneksi->query("SELECT * FROM tagihan WHERE id_pelanggan = '$r[id_pelanggan]' AND status = 'Belum Bayar' ");
						?>
							<tr>
								<td align="center"><?php echo $no; ?>.</td>
								<td align="center"><?php echo $r['id_pelanggan'] ?></td>
								<td><?php echo $r['nama'] ?></td>
								<td align="left"><?php echo $r['alamat'] ?></td>
								<td align="center"><?php echo $sum['bln_tunggak']; ?>&nbsp;Bulan</td>
								<td align="center">
									<?php while ($bln = mysqli_fetch_array($bulan)) {
										$aksi->bulan_substr($bln['bulan']);
										echo substr($bln['tahun'], 2, 2) . ",";
									} ?>

								</td>
								<td align="center"><?php echo $sum['jml_meter'] ?></td>
								<td align="right"><?php $aksi->rupiah($sum['tarif_perkwh']); ?></td>
								<td align="right"><?php $aksi->rupiah($sum['jml_bayar']); ?></td>
							</tr>
				<?php }
					}
				} ?>
			</tbody>
		</table>

	<?php } elseif (isset($_GET['riwayat_penggunaan'])) { ?>
		<table width="100%" border="1" cellspacing="0" cellpadding="3">
			<thead>
				<th>
					<center>No.</center>
				</th>
				<th>
					<center>ID Pelanggan</center>
				</th>
				<th>
					<center>Nama Pelanggan</center>
				</th>
				<th>
					<center>Bulan</center>
				</th>
				<th>
					<center>Meter Awal</center>
				</th>
				<th>
					<center>Meter Akhir</center>
				</th>
				<th>
					<center>Jumlah Meter</center>
				</th>
				<th>
					<center>Tarif/KWh</center>
				</th>
				<th>
					<center>Jumlah Bayar</center>
				</th>
			</thead>
			<tbody>
				<?php
				$no = 0;
				$data = $aksi->tampil($table, $cari, "ORDER BY bulan ASC");
				if ($data == "") {
					$aksi->no_record(9);
				} else {
					foreach ($data as $r) {
						$no++;
						$penggunaan = $aksi->caridata("penggunaan WHERE id_pelanggan = '$r[id_pelanggan]' AND bulan = '$r[bulan]' AND tahun = '$r[tahun]'");
				?>
						<tr>
							<td align="center"><?php echo $no; ?>.</td>
							<td align="center"><?php echo $r['id_pelanggan']; ?></td>
							<td align="left" style="margin-left: 5px;"><?php echo $r['nama_pelanggan']; ?></td>
							<td align="center"><?php $aksi->bulan($r['bulan']);
												echo " " . $r['tahun']; ?></td>
							<td align="center"><?php echo $penggunaan['meter_awal']; ?></td>
							<td align="center"><?php echo $penggunaan['meter_akhir']; ?></td>
							<td align="center"><?php echo $r['jumlah_meter']; ?></td>
							<td align="right"><?php $aksi->rupiah($r['tarif_perkwh']); ?></td>
							<td align="right"><?php $aksi->rupiah($r['jumlah_bayar']); ?></td>
						</tr>
				<?php }
				}
				$sum = mysqli_fetch_array($koneksi->query("SELECT SUM(jumlah_meter) as meter,SUM(jumlah_bayar) as bayar FROM tagihan WHERE id_pelanggan = '$id_pelanggan' AND tahun = '$tahun'"));
				?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="6" align="right">TOTAL METER :</td>
					<td align="center"><?php echo $sum['meter']; ?></td>
					<td align="right">TOTAL BAYAR :</td>
					<td align="right"><?php $aksi->rupiah($sum['bayar']); ?></td>
				</tr>
			</tfoot>
		</table>
	<?php } ?>
	<!-- INI END ISI LAPORAN -->

	<!-- FOOTER LAPORAN -->
	<div class="mt-12 flex justify-end">
		<div class="text-right">
			<div class="text-sm text-gray-600 mb-2">
				<?php $aksi->hari(date("N"));
				echo ", ";
				$aksi->format_tanggal(date("Y-m-d")); ?>
			</div>
			<div class="font-semibold text-gray-700 mb-8">Hormat Saya,</div>
			<div class="h-8"></div>
			<div class="font-bold text-blue-700 text-lg"><?php echo $_SESSION['nama_petugas']; ?></div>
		</div>
	</div>
	<!-- END FOOTER LAPORAN -->
</body>

</html>