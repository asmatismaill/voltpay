<!-- INI LAPORAN TAGIHAN PERIODE-->
					<?php }elseif(isset($_GET['tagihan_periode'])){ 
						$data = "";
						if(isset($_POST['bcari'])){
							$table = "qw_tagihan";
							$status = $_POST['status'];

							$bulan_dari = $_POST['bulan_dari'];
							$tahun_dari = $_POST['tahun_dari'];
							$bulan_sampai = $_POST['bulan_sampai'];
							$tahun_sampai = $_POST['tahun_sampai'];

							@$cari = "WHERE status = '$status' AND  bulan = '$bulanini' AND tahun ='$tahunini'";
							$data = $aksi->tampil($table,$cari,"");

							$link_print = "print.php?tagihan_periode&status=$status&bulan_dari=$bulan_dari&tahun_dari=$tahun_dari&bulan_sampai=$bulan_sampai&tahun_sampai=$tahun_sampai";
							$link_excel = "print.php?excel&tagihan_periode&status=$status&bulan_dari=$bulan_dari&tahun_dari=$tahun_dari&bulan_sampai=$bulan_sampai&tahun_sampai=$tahun_sampai";
						}else{
							@$data ="";
						}
					?>
<div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 mb-8">
   <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
	   <div class="text-lg font-bold text-blue-700">LAPORAN TAGIHAN PER-PERIODE</div>
	   <div class="flex gap-3 mt-2 sm:mt-0">
		   <a href="<?php echo $link_print ?>" target="_blank" class="inline-flex items-center px-3 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold transition">
			   <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9V2h12v7" /></svg>
			   CETAK
		   </a>
		   <a href="<?php echo $link_excel ?>" target="_blank" class="inline-flex items-center px-3 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition">
			   <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2" /></svg>
			   EXPORT EXCEL
		   </a>
	   </div>
   </div>
   <form method="post" class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
	   <div class="flex flex-col gap-2">
		   <label class="text-gray-600 font-medium">Status</label>
		   <select name="status" class="px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-400 focus:outline-none" required>
			   <option></option>
			   <option value="Terbayar" <?php if(@$status == "Terbayar"){echo "selected";} ?>>Terbayar</option>
			   <option value="Belum Bayar" <?php if(@$status == "Belum Bayar"){echo "selected";} ?>>Belum Bayar</option>
		   </select>
	   </div>
	   <div class="flex flex-col gap-2">
		   <label class="text-gray-600 font-medium">Dari Bulan</label>
		   <select name="bulan_dari" class="px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-400 focus:outline-none">
			   <option></option>
			   <?php  for ($a=1; $a <=12 ; $a++) { $b = ($a<10) ? "0".$a : $a; ?>
				   <option value="<?php echo $b; ?>" <?php if(@$b==@$bulan_dari){echo "selected";} ?>><?php $aksi->bulan($b); ?></option>
			   <?php } ?>
		   </select>
	   </div>
	   <div class="flex flex-col gap-2">
		   <label class="text-gray-600 font-medium">Tahun Dari</label>
		   <select name="tahun_dari" class="px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-400 focus:outline-none">
			   <option></option>
			   <?php for ($a=2018; $a < 2031; $a++) { ?>
				   <option value="<?php echo $a; ?>" <?php if(@$a==@$tahun_dari){echo "selected";} ?>><?php echo @$a; ?></option>
			   <?php } ?>
		   </select>
	   </div>
	   <div class="flex flex-col gap-2">
		   <label class="text-gray-600 font-medium">Sampai Bulan</label>
		   <select name="bulan_sampai" class="px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-400 focus:outline-none">
			   <option></option>
			   <?php  for ($a=1; $a <=12 ; $a++) { $b = ($a<10) ? "0".$a : $a; ?>
				   <option value="<?php echo $b; ?>" <?php if(@$b==@$bulan_sampai){echo "selected";} ?>><?php $aksi->bulan($b); ?></option>
			   <?php } ?>
		   </select>
	   </div>
	   <div class="flex flex-col gap-2">
		   <label class="text-gray-600 font-medium">Tahun Sampai</label>
		   <select name="tahun_sampai" class="px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-400 focus:outline-none">
			   <option></option>
			   <?php for ($a=2018; $a < 2031; $a++) { ?>
				   <option value="<?php echo $a; ?>" <?php if(@$a==@$tahun_sampai){echo "selected";} ?>><?php echo @$a; ?></option>
			   <?php } ?>
		   </select>
	   </div>
	   <div class="flex items-center gap-2 mt-2">
		   <button type="submit" name="bcari" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm transition flex items-center">
			   <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16l4-4-4-4" /></svg>
			   CARI
		   </button>
		   <a href="?menu=laporan&tagihan_bulan" class="px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm transition flex items-center">
			   <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16" /></svg>
			   REFRESH
		   </a>
	   </div>
   </form>
   <div class="overflow-x-auto">
	   <table class="min-w-full border border-gray-300 rounded-lg text-sm">
		   <thead class="bg-blue-100">
			   <tr>
				   <th class="py-2 px-3 border">No.</th>
				   <th class="py-2 px-3 border">ID Pelanggan</th>
				   <th class="py-2 px-3 border">Nama Pelanggan</th>
				   <th class="py-2 px-3 border">Bulan</th>
				   <th class="py-2 px-3 border">Jumlah Meter</th>
				   <th class="py-2 px-3 border">Jumlah Bayar</th>
				   <th class="py-2 px-3 border">Status</th>
				   <th class="py-2 px-3 border">Petugas</th>
			   </tr>
		   </thead>
		   <tbody>
			   <?php  $no=0; if ($data=="") { $aksi->no_record(8); } else { foreach ($data as $r) { $no++; ?>
				   <tr class="hover:bg-gray-50">
					   <td class="border text-center py-1 px-2"><?php echo $no; ?>.</td>
					   <td class="border text-center py-1 px-2"><?php echo $r['id_pelanggan'] ?></td>
					   <td class="border py-1 px-2"><?php echo $r['nama_pelanggan'] ?></td>
					   <td class="border py-1 px-2"><?php $aksi->bulan($r['bulan']);echo " ".$r['tahun'];?></td>
					   <td class="border text-center py-1 px-2"><?php echo $r['jumlah_meter'] ?></td>
					   <td class="border text-right py-1 px-2"><?php $aksi->rupiah($r['jumlah_bayar'])?></td>
					   <td class="border text-center py-1 px-2"><?php echo $r['status']; ?></td>
					   <td class="border text-center py-1 px-2"><?php echo $r['nama_petugas']; ?></td>
				   </tr>
			   <?php } } ?>
			</tbody>
	   </table>
   </div>
</div>
<!-- INI END LAPORAN TAGIHAN PERIODE -->