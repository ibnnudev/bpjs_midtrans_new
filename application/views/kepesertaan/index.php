<a href="<?= site_url('kepesertaan/create') ?>" class="btn btn-primary mb-3">Tambah Peserta</a>
<div class="card">
	<div class="card-header">
		<h5>Data Kepesertaan BPJS</h5>
	</div>
	<div class="card-body">
		<br>
		<?php
		$role = $this->session->userdata('role');
		$user_id = $this->session->userdata('user_id');
		?>

		<table id="kepesertaanTable" class="table table-bordered">
			<thead>
				<tr>
					<th>No</th>
					<th>Foto KTP</th>
					<th>No KK</th>
					<th>NIK</th>
					<th>Nama</th>
					<th>Jenis Kelamin</th>
					<th>Faskes</th>
					<th>Kelas</th>
					<th>Status</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$no = 1;
				$data_tampil = false;

				foreach ($kepesertaan as $p):
					if ($role == 'admin' || $p->user_id == $user_id):
						$data_tampil = true;
				?>
						<tr>
							<td><?= $no++; ?></td>
							<td>
								<?php if ($p->foto_ktp): ?>
									<img src="<?= base_url('uploads/ktp/' . $p->foto_ktp) ?>" width="100" height="50" style="object-fit: contain;">
								<?php else: ?>
									<img src="https://media.istockphoto.com/id/1452662817/vector/no-picture-available-placeholder-thumbnail-icon-illustration-design.jpg?s=612x612&w=0&k=20&c=bGI_FngX0iexE3EBANPw9nbXkrJJA4-dcEJhCrP8qMw=" width="50" height="50">
								<?php endif; ?>
							</td>
							<td><?= $p->no_kartu; ?></td>
							<td><?= $p->nik; ?></td>
							<td><?= $p->nama; ?></td>
							<td><?= $p->jenis_kelamin; ?></td>
							<td><?= $p->nama_faskes; ?></td> <!-- Menampilkan Nama Faskes -->
							<td><?= $p->nama_kelas; ?></td> <!-- Menampilkan Nama Kelas -->
							<td>
								<?php
								// Ambil status kepesertaan terbaru dari tabel pembayaran_bpjs dengan tipe "registrasi"
								$status_kepesertaan = $this->db->select('status_kepesertaan')
									->from('pembayaran_bpjs')
									->where('kepesertaan_id', $p->id)
									->where('tipe_pembayaran', 'registrasi') // Hanya ambil yang tipe pembayaran "registrasi"
									->order_by('id', 'DESC') // Ambil data terbaru jika ada lebih dari satu
									->limit(1)
									->get()
									->row();

								// Jika status ditemukan, tampilkan, jika tidak tampilkan "Tidak Aktif"
								$status_aktif = $status_kepesertaan ? $status_kepesertaan->status_kepesertaan : 'Tidak Aktif';
								?>
								<?php if ($status_aktif == 'Aktif') : ?>
									<span class="badge badge-success">Aktif</span>
								<?php elseif ($status_aktif == 'Menunggu Aktivasi') : ?>
									<span class="badge badge-warning">Menunggu Aktivasi</span>
								<?php else : ?>
									<span class="badge badge-danger">Tidak Aktif</span>
								<?php endif; ?>
							</td>


							<td class="text-center">
								<div class="dropdown">
									<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
										Aksi
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item" href="<?= site_url('kepesertaan/show/' . $p->id) ?>">Lihat Detail</a>
										<?php if ($this->session->userdata('role') == 'admin'): ?>
											<a class="dropdown-item" href="<?= site_url('kepesertaan/edit/' . $p->id) ?>">Edit</a>

											<?php if ($status_aktif == 'Aktif'): ?>
												<a class="dropdown-item text-danger" href="<?= site_url('kepesertaan/update_status/' . $p->id . '/nonaktif') ?>" onclick="return confirm('Nonaktifkan peserta ini?');">Nonaktifkan</a>
											<?php else: ?>
												<a class="dropdown-item text-success" href="<?= site_url('kepesertaan/update_status/' . $p->id . '/aktif') ?>" onclick="return confirm('Aktifkan peserta ini?');">Aktifkan</a>
											<?php endif; ?>

										<?php endif; ?>
									</div>
								</div>
							</td>

						</tr>
					<?php
					endif;
				endforeach;

				// Jika tidak ada data yang ditampilkan
				if (!$data_tampil):
					?>
					<tr>
						<td colspan="9" class="text-center">Tidak ada data</td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>

	</div>
</div>