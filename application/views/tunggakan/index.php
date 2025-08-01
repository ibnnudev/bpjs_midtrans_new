<div class="card">
	<div class="card-header">
		<h5>Data Tunggakan Peserta BPJS</h5>
	</div>
	<div class="card-body">
		<br>
		<?php
		$bulan_ini = date('m-Y');
		function hitungSelisihBulan($from, $to)
		{
			$fromDate = DateTime::createFromFormat('m-Y', $from);
			$toDate = DateTime::createFromFormat('m-Y', $to);

			if ($fromDate && $toDate) {
				$interval = $fromDate->diff($toDate);
				$selisih = ($interval->y * 12) + $interval->m;

				if ($interval->invert === 1) {
					$selisih *= -1;
				}
				return $selisih;
			}
		} ?>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>No</th>
					<th>No KK</th>
					<th>NIK</th>
					<th>Nama Peserta</th>
					<th>FasKes</th>
					<th>Kelas</th>
					<th>Status</th>
					<th>Lama Tunggakan</th>
					<th>Total Tunggakan</th>
				</tr>
			</thead>
			<tbody>
				<?php $no = 1;
				foreach ($tunggakan as $p): ?>
					<?php
					$terakhir_bayar = $p->terakhir_bayar; // format '05-2024' misalnya
					$from = $terakhir_bayar ? $terakhir_bayar : date('m-Y', strtotime($p->tanggal_daftar));
					$lama_tunggakan = hitungSelisihBulan($from, $bulan_ini);
					$total_tunggakan = $lama_tunggakan * $p->harga;
					?>
					<tr>
						<td><?= $no++; ?></td>
						<td><?= $p->no_kartu; ?></td> <!-- Bisa diganti dengan nama jika ada relasi -->
						<td><?= $p->nik ?></td>
						<td><?= $p->nama ?></td>
						<td><?= $p->nama_faskes ?></td>
						<td><?= $p->nama_kelas ?></td>
						<td>

							<?php
							$status_kepesertaan = $p->status_kepesertaan;
							// Jika status ditemukan, tampilkan, jika tidak tampilkan "Tidak Aktif"
							$status_aktif = $status_kepesertaan ? $status_kepesertaan : 'Tidak Aktif';
							if ($status_aktif == 'Aktif') : ?>
								<span class="badge badge-success">Aktif</span>
							<?php else : ?>
								<span class="badge badge-danger">Tidak Aktif</span>
							<?php endif; ?>
						</td>
						<td><?= $lama_tunggakan ?> Bulan</td>
						<td>Rp <?= number_format($total_tunggakan, 0, ',', '.') ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
