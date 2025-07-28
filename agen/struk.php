<?php
include '../config/koneksi.php';
include '../library/fungsi.php';
session_start();
$aksi = new oop();

$id_pelanggan = $_GET['id_pelanggan'];
$bulan = $_GET['bulan'];
$tahun = $_GET['tahun'];

$pembayaran = $aksi->caridata("qw_pembayaran WHERE id_pelanggan = '$id_pelanggan' AND bulan_bayar = '$bulan' AND tahun_bayar = '$tahun' ");
$penggunaan = $aksi->caridata("penggunaan WHERE id_pelanggan = '$id_pelanggan' AND bulan = '$bulan' AND tahun = '$tahun'");
$pelanggan = $aksi->caridata("pelanggan WHERE id_pelanggan = '$id_pelanggan'");
$tarif = $aksi->caridata("tarif WHERE id_tarif = '$pelanggan[id_tarif]'");
?>
<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cetak Struk <?php echo $pembayaran['id_pembayaran']; ?></title>
	<link rel="icon" type="image/png" href="../images/vp.png">
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body onload="window.print()" class="font-mono bg-white">
	<div class="max-w-lg mx-auto my-8 p-6 bg-white rounded-xl shadow print:shadow-none print:bg-white print:p-0 border border-gray-300">
		<div class="flex flex-col items-center mb-4">
			<img src="../images/vpstruk.png" alt="Logo" class="w-28 opacity-80 mb-2 print:mb-0">
			<div class="text-lg font-bold text-blue-700 tracking-wide mb-2">STRUK PEMBAYARAN TAGIHAN LISTRIK</div>
		</div>
		<table class="w-full text-sm mb-2">
			<tr>
				<td class="py-1 text-gray-700">IDPEL</td>
				<td class="py-1">:</td>
				<td class="py-1 font-semibold text-gray-900"><?php echo $pembayaran['id_pelanggan']; ?></td>
				<td class="py-1"></td>
				<td class="py-1 text-gray-700">BL/TH</td>
				<td class="py-1">:</td>
				<td class="py-1 font-semibold text-gray-900"><?php $aksi->bulan_substr($bulan);
																echo substr($tahun, 2, 2); ?></td>
			</tr>
			<tr>
				<td class="py-1 text-gray-700">NAMA</td>
				<td class="py-1">:</td>
				<td class="py-1 font-semibold text-gray-900"><?php echo $pelanggan['nama']; ?></td>
				<td class="py-1"></td>
				<td class="py-1 text-gray-700">STAND METER</td>
				<td class="py-1">:</td>
				<td class="py-1 font-semibold text-gray-900"><?php echo $penggunaan['meter_awal'] . "-" . $penggunaan['meter_akhir']; ?></td>
			</tr>
			<tr>
				<td class="py-1 text-gray-700">TARIF/DAYA</td>
				<td class="py-1">:</td>
				<td class="py-1 font-semibold text-gray-900"><?php echo $tarif['kode_tarif']; ?></td>
			</tr>
			<tr>
				<td class="py-1 text-gray-700">RP. TAG PLN</td>
				<td class="py-1">:</td>
				<td class="py-1 font-semibold text-blue-700"><?php $aksi->rupiah($pembayaran['jumlah_bayar']); ?></td>
			</tr>
			<tr>
				<td class="py-1 text-gray-700">JFA REF</td>
				<td class="py-1">:</td>
				<td class="py-1 font-semibold text-gray-900"><?php echo strtoupper(sha1($pembayaran['id_pembayaran'] . $_SESSION['id_agen'])); ?></td>
			</tr>
			<tr>
				<td colspan="7" class="py-2 text-center text-xs text-gray-500">PLN menyatakan struk ini sebagai bukti pembayaran yang sah</td>
			</tr>
			<tr>
				<td class="py-1 text-gray-700">ADMIN BANK</td>
				<td class="py-1">:</td>
				<td class="py-1 font-semibold text-blue-700"><?php $aksi->rupiah($pembayaran['biaya_admin']) ?></td>
			</tr>
			<tr>
				<td class="py-1 text-gray-700">TOTAL BAYAR</td>
				<td class="py-1">:</td>
				<td class="py-1 font-semibold text-green-700"><?php $aksi->rupiah($pembayaran['total_akhir']) ?></td>
			</tr>
		</table>
		<div class="text-center text-base font-bold text-blue-700 my-2">TERIMA KASIH</div>
		<div class="text-center text-xs text-gray-500 mb-1">Rincian tagihan dapat diakses di www.pln.co.id, Informasi Hubungi Call Center: 123</div>
		<div class="text-center text-xs text-gray-500">PPOB VOLTPAY/<?php echo $_SESSION['nama_agen'] . "/" . $pembayaran['waktu_bayar']; ?></div>
	</div>
</body>

</html>