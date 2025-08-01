<div class="col-lg-12 mb-4 order-0">
	<div class="row">
		<div class="col-xl">
			<div class="card mb-4">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h5 class="mb-0">DETAIL KEPESERTAAN BPJS</h5>
					<small class="text-muted float-end">DETAIL KEPESERTAAN</small>
				</div>
				<div class="card-body">
					<br>
					<table class="table table-bordered">
						<tr>
							<th>Nomor Kartu BPJS</th>
							<td><?= $kepesertaan->no_kartu; ?></td>
						</tr>
						<tr>
							<th>Bulan Daftar</th>
							<td><?= $bulan; ?></td>
						</tr>
						<tr>
							<th>NIK</th>
							<td><?= $kepesertaan->nik; ?></td>
						</tr>
						<tr>
							<th>Nama</th>
							<td><?= $kepesertaan->nama; ?></td>
						</tr>
						<tr>
							<th>Faskes</th>
							<td><?= $faskes->nama_faskes; ?></td>
						</tr>
						<tr>
							<th>Kelas BPJS</th>
							<td><?= $kelas->nama_kelas; ?></td>
						</tr>
						<tr>
							<th>Status Kepesertaan</th>
							<td>
								<?php
								// Ambil status kepesertaan terbaru dari tabel pembayaran_bpjs dengan tipe "registrasi"
								$status_kepesertaan = $this->db->select('status_kepesertaan')
									->from('pembayaran_bpjs')
									->where('kepesertaan_id', $kepesertaan->id)
									->where('tipe_pembayaran', 'registrasi') // Hanya ambil tipe registrasi
									->order_by('id', 'DESC') // Ambil data terbaru
									->limit(1)
									->get()
									->row();

								// Jika ada data, gunakan status dari pembayaran_bpjs, jika tidak, default "Tidak Aktif"
								$status_aktif = $status_kepesertaan ? ucfirst($status_kepesertaan->status_kepesertaan) : 'Tidak Aktif';
								?>
								<span class="badge <?= ($status_aktif == 'Aktif') ? 'badge-success' : 'badge-danger'; ?>">
									<?= $status_aktif; ?>
								</span>
							</td>
						</tr>

					</table>
				</div>
				<div class="d-flex justify-content-center mb-3">
					<a href="<?= site_url('kepesertaan/export_keaktifan_pdf/' . $kepesertaan->id) ?>" class="btn btn-danger">
						<i class="bi bi-file-earmark-pdf"></i> Download Bukti Kepesertaan
					</a>
				</div>

			</div>
		</div>
		<div class="col-xl">
			<div class="card mb-4">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h5 class="mb-0">STATUS PEMBAYARAN</h5>
					<small class="text-muted float-end">DETAIL STATUS PEMBAYARAN</small>
				</div>
				<div class="card-body">
					<br>
					<?php
					$bulan_sekarang = date('m-Y');
					$tampilkan_data_pembayaran = false;
					$pembayaran_valid = null;
					$cek_pembayaran = $this->db->get_where('pembayaran_bpjs', ['kepesertaan_id' => $kepesertaan->id])->result();

					if ($cek_pembayaran) {
						foreach ($cek_pembayaran as $pembayaran) {
							if ($pembayaran->tipe_pembayaran == 'iuran' && $pembayaran->bulan == $bulan_sekarang && $pembayaran->status == 'lunas') {
								$tampilkan_data_pembayaran = true;
								$pembayaran_valid = $pembayaran;
								break;
							}
						}
					}
					?>

					<?php if ($tampilkan_data_pembayaran && $pembayaran_valid) : ?>
						<table class="table table-bordered">
							<tr>
								<th>Bulan</th>
								<?php
								$date = DateTime::createFromFormat('m-Y', $pembayaran_valid->bulan);
								?>
								<td><?= $date->format('M Y') ?></td>
							</tr>
							<tr>
								<th>Jumlah Bayar</th>
								<td>Rp<?= number_format($pembayaran_valid->jumlah_bayar, 2, ',', '.'); ?></td>
							</tr>
							<tr>
								<th>Tanggal Bayar</th>
								<td><?= date('d M Y H:i:s', strtotime($pembayaran_valid->tanggal_bayar)) ?></td>
							</tr>
							<tr>
								<th>Metode Pembayaran</th>
								<?php
								$metode = "";
								if (!empty($pembayaran_valid->metode_pembayaran)) {
									$metode =  ucwords(str_replace('_', ' ', $pembayaran_valid->metode_pembayaran));
								}
								?>
								<td><?= $metode ?></td>
							</tr>
							<tr>
								<th>Status</th>
								<td>
									<span class="badge bg-success">Lunas</span>
								</td>
							</tr>
							
						</table>
					<?php else : ?>
						<div class="alert alert-warning mt-3">
							<?php
							// Periksa apakah pembayaran iuran sudah ada di bulan ini
							$cek_pembayaran_iuran = $this->db->get_where('pembayaran_bpjs', [
								'kepesertaan_id' => $kepesertaan->id,
								'tipe_pembayaran' => 'iuran',
								'bulan' => $bulan_sekarang
							])->row();

							if ($cek_pembayaran_iuran) {
							} else {
								echo "<strong></strong> ";
							}
							?>
						</div>
						<div class="d-flex gap-2 mt-2">
							<a href="<?= site_url('pembayaran/pilih_metode/' . $kepesertaan->id) ?>" class="btn btn-primary">Bayar Sekarang</a>
							<a href="<?= site_url('kepesertaan') ?>" class="btn btn-secondary">Kembali</a>
						</div>
					<?php endif; ?>

				</div>
			</div>
		</div>
	</div>
</div>
