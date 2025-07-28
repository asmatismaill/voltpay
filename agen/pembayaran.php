<?php
if (!isset($_GET['menu'])) {
	header('location:hal_utama.php?menu=pembayaran');
}

include '../config/koneksi.php';
global $koneksi;

//dasar
$table = "pembayaran";
$id = isset($_GET['id']) ? $_GET['id'] : '';
$where = " id_pembayaran = '$id'";
$redirect = "?menu=pembayaran";

//kode otomatis
$hari_ini = date("Ymd");
$sql = mysqli_query($koneksi, "SELECT id_pembayaran FROM pembayaran WHERE id_pembayaran LIKE '%$hari_ini%' order by id_pembayaran DESC");
$cek = mysqli_fetch_array($sql);
if (empty($cek)) {
	$id_pembayaran = "BYR" . $hari_ini . "0001";
} else {
	$kode = substr($cek['id_pembayaran'], 12, 4) + 1;
	if ($kode < 10) {
		$id_pembayaran = "BYR" . $hari_ini . "000" . $kode;
	} elseif ($kode < 100) {
		$id_pembayaran = "BYR" . $hari_ini . "00" . $kode;
	} elseif ($kode < 1000) {
		$id_pembayaran = "BYR" . $hari_ini . "0" . $kode;
	} else {
		$id_pembayaran = "BYR" . $hari_ini . "" . $kode;
	}
}
//end kode otomatis

$id_pelanggan = isset($_POST['id_pelanggan']) ? $_POST['id_pelanggan'] : '';


?>
<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pembayaran | VoltPay</title>
	<link rel="icon" type="image/png" href="../images/vp.png">
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-emerald-50 via-white to-blue-50 min-h-screen">
	<div class="max-w-3xl mx-auto pt-12 pb-8 px-2 sm:px-4">
		<div class="rounded-2xl shadow-xl bg-white p-6 sm:p-8">
			<div class="text-2xl font-bold text-blue-700 mb-6">Input Pembayaran <span class="text-gray-400 text-base font-normal">- <?php echo $id_pembayaran; ?></span></div>
			<form method="post" class="flex flex-col md:flex-row md:items-end gap-4 mb-8">
				<div class="flex-1">
					<label for="id_pelanggan" class="block text-gray-700 font-medium mb-1">ID Pelanggan</label>
					<input type="text" name="id_pelanggan" id="id_pelanggan" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-400 focus:outline-none text-gray-700" value="<?php if (@$_GET['id_pelanggan'] == "") {
																																																						echo @$id_pelanggan;
																																																					} else {
																																																						echo $_GET['id_pelanggan'];
																																																					} ?>" placeholder="Masukan ID Pelanggan ...." onkeypress='return event.charCode >=48 && event.charCode <=57' list="list">
					<datalist id="list">
						<?php
						$a = mysqli_query($koneksi, "SELECT * FROM pelanggan");
						while ($b = mysqli_fetch_array($a)) { ?>
							<option value="<?php echo $b['id_pelanggan'] ?>"><?php echo $b['nama']; ?></option>
						<?php } ?>
					</datalist>
				</div>
				<button type="submit" name="bcari_id" class="inline-flex items-center px-6 py-3 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold text-lg transition">
					<svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
						<circle cx="11" cy="11" r="8" />
						<path d="M21 21l-4.35-4.35" />
					</svg>
					Cari
				</button>
			</form>
			<?php
			if (isset($_POST['bcari_id'])) {
				$pelanggan = $aksi->caridata("pelanggan WHERE id_pelanggan = '$id_pelanggan'");
				$tagihan = $aksi->cekdata("tagihan WHERE id_pelanggan = '$id_pelanggan' AND status ='Belum Bayar'");
				$tarif = $aksi->caridata("tarif WHERE id_tarif = '$pelanggan[id_tarif]'");

				if ($pelanggan == "") {
					echo "<div class='text-center text-xl text-red-500 font-bold py-8'>ID PELANGGAN TIDAK DITEMUKAN</div>";
				} elseif ($tagihan == 0) {
					$aksi->pesan("ID Pelangan Tidak Memiliki Tunggakan Tagihan");
				} else {
			?>
					<div class="rounded-2xl shadow bg-white p-6 mb-8">
						<div class="text-lg font-semibold text-blue-700 mb-4 text-center">Detail Tagihan - <?php echo $id_pelanggan . " - " . $pelanggan['nama']; ?></div>
						<div class="flex flex-col md:flex-row gap-6">
							<div class="md:w-1/3">
								<div class="font-medium text-blue-700 mb-2 text-center">Detail Pelanggan</div>
								<table class="w-full text-sm mb-4">
									<tr>
										<td class="text-right pr-2">ID Pelanggan</td>
										<td class="text-gray-400">:</td>
										<td><?php echo $pelanggan['id_pelanggan']; ?></td>
									</tr>
									<tr>
										<td class="text-right pr-2">Nama</td>
										<td class="text-gray-400">:</td>
										<td><?php echo $pelanggan['nama']; ?></td>
									</tr>
									<tr>
										<td class="text-right pr-2">No.Meter</td>
										<td class="text-gray-400">:</td>
										<td><?php echo $pelanggan['no_meter']; ?></td>
									</tr>
									<tr>
										<td class="text-right pr-2">Alamat</td>
										<td class="text-gray-400">:</td>
										<td><?php echo $pelanggan['alamat']; ?></td>
									</tr>
									<tr>
										<td class="text-right pr-2">Tarif</td>
										<td class="text-gray-400">:</td>
										<td><?php echo $tarif['kode_tarif'] . "<br>";
											$aksi->rupiah($tarif['tarif_perkwh']); ?></td>
									</tr>
								</table>
							</div>
							<div class="md:w-2/3">
								<div class="font-medium text-blue-700 mb-2 text-center">Detail Tagihan</div>
								<div class="overflow-x-auto rounded-lg shadow">
									<table class="min-w-full bg-white text-xs rounded-lg">
										<thead class="bg-gray-100 text-gray-700">
											<tr>
												<th class="py-2 px-3 font-semibold">No.</th>
												<th class="py-2 px-3 font-semibold">ID Pelanggan</th>
												<th class="py-2 px-3 font-semibold">Bulan</th>
												<th class="py-2 px-3 font-semibold">Meter Awal</th>
												<th class="py-2 px-3 font-semibold">Meter Akhir</th>
												<th class="py-2 px-3 font-semibold">Jumlah Meter</th>
												<th class="py-2 px-3 font-semibold">Tarif/KWh</th>
												<th class="py-2 px-3 font-semibold">Jumlah Bayar</th>
												<th class="py-2 px-3 font-semibold">Aksi</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no = 0;
											$data = $aksi->tampil("tagihan", "WHERE id_pelanggan = '$id_pelanggan' AND status = 'Belum Bayar' ", " order by bulan asc");
											if ($data == "") {
												$aksi->no_record(8);
											} else {
												foreach ($data as $r) {
													$penggunaan = $aksi->caridata("penggunaan WHERE id_pelanggan = '$r[id_pelanggan]' AND bulan = '$r[bulan]' AND tahun = '$r[tahun]'");
													$no++; ?>
													<tr class="border-b hover:bg-blue-50">
														<td class="py-2 px-3 text-center"><?php echo $no; ?>.</td>
														<td class="py-2 px-3"><?php echo $r['id_pelanggan'] ?></td>
														<td class="py-2 px-3"><?php $aksi->bulan($r['bulan']);
																				echo " " . $r['tahun'] ?></td>
														<td class="py-2 px-3 text-center"><?php echo $penggunaan['meter_awal']; ?></td>
														<td class="py-2 px-3 text-center"><?php echo $penggunaan['meter_akhir']; ?></td>
														<td class="py-2 px-3 text-center"><?php echo $r['jumlah_meter'] ?></td>
														<td class="py-2 px-3 text-center"><?php $aksi->rupiah($r['tarif_perkwh']) ?></td>
														<td class="py-2 px-3 text-center"><?php $aksi->rupiah($r['jumlah_bayar']) ?></td>
														<td class="py-2 px-3 text-center">
															<a href="?menu=pembayaran&id_pelanggan=<?php echo $r['id_pelanggan']; ?>&bulan=<?php echo $r['bulan']; ?>&tahun=<?php echo $r['tahun']; ?>" class="inline-block px-3 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs transition" target="_blank">BAYAR</a>
														</td>
													</tr>
											<?php }
											}
											$sql_total = mysqli_query($koneksi, "SELECT SUM(jumlah_bayar) as 'sum_bayar' FROM tagihan WHERE id_pelanggan = '$id_pelanggan' AND status = 'Belum Bayar'");
											$sum_total = mysqli_fetch_array($sql_total);
											?>
										</tbody>
										<tfoot>
											<tr>
												<td colspan="7" class="text-right font-semibold text-blue-700">TOTAL TAGIHAN:</td>
												<td colspan="2" class="text-center">
													<input type="text" name="total_bayar" value="<?php echo @$sum_total['sum_bayar']; ?>" readonly class="w-32 px-2 py-1 rounded border border-gray-300 bg-gray-100 text-right">
												</td>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
					</div>
				<?php }
			} elseif (isset($_GET['id_pelanggan'])) {
				$penggunaan = $aksi->caridata("penggunaan WHERE id_pelanggan = '$_GET[id_pelanggan]' AND bulan = '$_GET[bulan]' AND tahun = '$_GET[tahun]'");
				$tagihan = $aksi->caridata("tagihan WHERE id_pelanggan = '$_GET[id_pelanggan]' AND bulan = '$_GET[bulan]' AND tahun = '$_GET[tahun]'");
				$sum_akhir = ($tagihan['jumlah_bayar'] + $_SESSION['biaya_admin']);

				@$biaya_admin = $_POST['biaya_admin'];
				@$total_bayar = $_POST['total_bayar'];
				@$total_akhir = $_POST['total_akhir'];
				@$bayar = $_POST['bayar'];
				@$kembali = $_POST['kembali'];
				@$tanggal = date("Y-m-d");
				@$id_agen = $_SESSION['id_agen'];

				@$id_pel = $_GET['id_pelanggan'];
				@$bln = $_GET['bulan'];
				@$thn = $_GET['tahun'];
				@$field = array(
					'id_pembayaran' => $id_pembayaran,
					'id_pelanggan' => $id_pel,
					'tgl_bayar' => $tanggal,
					'jumlah_bayar' => $total_bayar,
					'biaya_admin' => $biaya_admin,
					'bulan_bayar' => $bln,
					'tahun_bayar' => $thn,
					'total_akhir' => $total_akhir,
					'bayar' => $bayar,
					'kembali' => $kembali,
					'id_agen' => $id_agen,
				);

				if (isset($_POST['bbayar'])) {
					if ($bayar < $total_akhir) {
						$aksi->pesan("Maaf Uang Tidak Mencukupi");
					} else {
						$aksi->update("tagihan", array('status' => "Terbayar"), "id_pelanggan = '$id_pel' AND bulan = '$bln' AND tahun = '$thn' AND status = 'Belum Bayar'");
						$aksi->simpan($table, $field);
						$aksi->alert("Data Berhasil Disimpan", "struk.php?id_pelanggan=" . $id_pel . "&bulan=" . $bln . "&tahun=" . $thn);
					}
				}

				?>
				<div class="rounded-2xl shadow bg-white p-6 mb-8">
					<div class="text-lg font-semibold text-blue-700 mb-4 text-center">Pembayaran - <?php echo @$_GET['id_pelanggan'] . " Bulan ";
																									$aksi->bulan(@$_GET['bulan']);
																									echo " " . @$_GET['tahun']; ?></div>
					<form method="post" class="space-y-4">
						<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
							<div>
								<label class="block text-gray-700 font-medium mb-1">Bulan Penggunaan</label>
								<input type="text" name="bulan" value="<?php $aksi->bulan($_GET['bulan']);
																		echo " " . $_GET['tahun'] ?>" readonly class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-100 text-gray-700" required>
							</div>
							<div>
								<label class="block text-gray-700 font-medium mb-1">Meter Awal</label>
								<input type="text" name="meter_awal" value="<?php echo @$penggunaan['meter_awal']; ?>" readonly class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-100 text-gray-700">
							</div>
							<div>
								<label class="block text-gray-700 font-medium mb-1">Meter Akhir</label>
								<input type="text" name="meter_akhir" value="<?php echo @$penggunaan['meter_akhir']; ?>" readonly class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-100 text-gray-700">
							</div>
							<div>
								<label class="block text-gray-700 font-medium mb-1">Jumlah Meter</label>
								<input type="text" name="jumlah_meter" value="<?php echo @$tagihan['jumlah_meter']; ?>" readonly class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-100 text-gray-700">
							</div>
							<div>
								<label class="block text-gray-700 font-medium mb-1">Tarif/KWH</label>
								<input type="text" name="tarif_perkwh" value="<?php echo @$tagihan['tarif_perkwh']; ?>" readonly class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-100 text-gray-700">
							</div>
							<div>
								<label class="block text-gray-700 font-medium mb-1">Tagihan PLN</label>
								<input type="text" name="total_bayar" value="<?php echo @$tagihan['jumlah_bayar']; ?>" readonly class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-100 text-gray-700">
							</div>
							<div>
								<label class="block text-gray-700 font-medium mb-1">Biaya Admin</label>
								<input type="text" name="biaya_admin" value="<?php echo @$_SESSION['biaya_admin']; ?>" readonly class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-100 text-gray-700">
							</div>
							<div>
								<label class="block text-gray-700 font-medium mb-1">Total Akhir</label>
								<input type="text" id="ttotalakhir" name="total_akhir" value="<?php echo $sum_akhir; ?>" readonly class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-100 text-gray-700" required>
							</div>
							<div>
								<label class="block text-gray-700 font-medium mb-1">Bayar</label>
								<input type="text" id="tbayar" name="bayar" required class="w-full px-4 py-2 rounded-lg border border-gray-300 text-gray-700 focus:ring-2 focus:ring-blue-400 focus:outline-none" onkeypress='return event.charCode >=48 && event.charCode <=57' required>
							</div>
							<div>
								<label class="block text-gray-700 font-medium mb-1">Kembali</label>
								<input type="text" id="tkembalian" name="kembali" value="" required readonly class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-100 text-gray-700">
							</div>
						</div>
						<div class="pt-2">
							<input type="submit" name="bbayar" value="BAYAR" class="w-full py-3 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold text-lg transition">
						</div>
					</form>
				</div>
			<?php } ?>
		</div>
	</div>
</body>

</html>