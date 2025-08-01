<div class="col-lg-12 mb-4 order-0">
	<div class="row">
		<div class="col-xl">
			<div class="card mb-4">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h5 class="mb-0">FORM EDIT DATA KEPESERTAAN</h5>
					<small class="text-muted float-end">DATA KEPESERTAAN</small>
				</div>
				<div class="card-body">
					<form action="<?= site_url('kepesertaan/update/' . $kepesertaan->id) ?>" method="post" enctype="multipart/form-data">
						<div class="mb-3">
							<label class="form-label" for="no_kartu">No KK:</label>
							<small id="kkWarning" class="form-text text-danger d-none">
								No KK harus 16 digit angka.
							</small>
							<input type="number" maxlength="16" oninput="validateNik()" class="form-control" name="no_kartu" value="<?= $kepesertaan->no_kartu ?>" required placeholder="Masukan Nomor KK" />
							<?= form_error('no_kartu', '<div class="invalid-feedback">', '</div>') ?>
						</div>

						<div class="mb-3">
							<label class="form-label" for="nik">NIK:</label>
							<small id="nikWarning" class="form-text text-danger d-none">
								NIK harus 16 digit angka.
							</small>
							<input type="number" maxlength="16" oninput="validateNik()" class="form-control" name="nik" value="<?= $kepesertaan->nik ?>" required />
						</div>

						<div class="mb-3">
							<label class="form-label" for="nama">Nama:</label>
							<input type="text" class="form-control" name="nama" value="<?= $kepesertaan->nama ?>" required />
						</div>

						<div class="mb-3">
							<label class="form-label" for="tanggal_lahir">Tanggal Lahir:</label>
							<input type="date" class="form-control" name="tanggal_lahir" value="<?= $kepesertaan->tanggal_lahir ?>" required />
						</div>

						<div class="mb-3">
							<label class="form-label" for="jenis_kelamin">Jenis Kelamin:</label>
							<select class="form-control" name="jenis_kelamin">
								<option value="Laki-laki" <?= $kepesertaan->jenis_kelamin == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
								<option value="Perempuan" <?= $kepesertaan->jenis_kelamin == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
							</select>
						</div>

						<div class="mb-3">
							<label class="form-label" for="alamat">Alamat:</label>
							<textarea class="form-control" name="alamat" required><?= $kepesertaan->alamat ?></textarea>
						</div>

						<div class="mb-3">
							<label class="form-label" for="no_hp">No HP:</label>
							<input type="number" class="form-control" name="no_hp" value="<?= $kepesertaan->no_hp ?>" required />
						</div>

						<div class="mb-3">
							<label class="form-label" for="email">Email:</label>
							<input type="email" class="form-control" name="email" value="<?= $kepesertaan->email ?>" />
						</div>

						<div class="mb-3">
							<label class="form-label" for="faskes_id">Fasilitas Kesehatan:</label>
							<select class="form-control" name="faskes_id" required>
								<option value="">Pilih Faskes</option>
								<?php foreach ($faskes as $f): ?>
									<option value="<?= $f->id ?>" <?= $kepesertaan->faskes_id == $f->id ? 'selected' : '' ?>><?= $f->nama_faskes ?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="mb-3">
							<label class="form-label" for="kelas_id">Kelas:</label>
							<select class="form-control" name="kelas_id" required>
								<option value="">Pilih Kelas</option>
								<?php foreach ($kelas as $k): ?>
									<option value="<?= $k->id ?>" <?= $kepesertaan->kelas_id == $k->id ? 'selected' : '' ?>><?= $k->nama_kelas ?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="mb-3">
							<label class="form-label" for="status_aktif">Status Aktif:</label>
							<select class="form-control" name="status_aktif">
								<option value="Aktif" <?= $kepesertaan->status_aktif == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
								<option value="Tidak Aktif" <?= $kepesertaan->status_aktif == 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
							</select>
						</div>

						<?php
						$role = $this->session->userdata('role');
						$user_id = $this->session->userdata('user_id');
						?>
						<div class="mb-3">
							<label class="form-label" for="user_id">Pilih Pengguna:</label>
							<?php if ($role == 'admin'): ?>
								<select class="form-control" name="user_id" id="user_id">
									<option value="">-- Pilih User --</option>
									<?php foreach ($users as $user): ?>
										<option value="<?= $user->id ?>" <?= ($user->id == $kepesertaan->user_id) ? 'selected' : '' ?>>
											<?= $user->name ?> (<?= $user->username ?>)
										</option>
									<?php endforeach; ?>
								</select>
							<?php else: ?>
								<input type="hidden" name="user_id" id="user_id" value="<?= $kepesertaan->user_id ?>" />
							<?php endif; ?>
						</div>

						<div class="mb-3">
							<input type="hidden" name="foto_ktp_lama" value="<?= $kepesertaan->foto_ktp ?>">
							<label for="foto_ktp" class="form-label">Upload Foto KTP</label>
							<input type="file" class="form-control" name="foto_ktp" id="foto_ktp" accept="image/*">
						</div>

						<?php if ($kepesertaan->foto_ktp): ?>
							<p>Foto KTP saat ini:</p>
							<img src="<?= base_url('uploads/ktp/' . $kepesertaan->foto_ktp) ?>" width="200">
						<?php endif; ?>

						<a href="<?= site_url('kepesertaan') ?>" class="btn btn-secondary">Kembali</a>
						<button type="submit" class="btn btn-primary">Update</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	function validateNik() {
		const nikInput = document.querySelector('input[name="nik"]');
		const nikWarning = document.getElementById('nikWarning');
		const noKartuInput = document.querySelector('input[name="no_kartu"]');
		const kkWarning = document.getElementById('kkWarning');

		if (nikInput.value.length !== 16) {
			nikWarning.classList.remove('d-none');
			nikInput.classList.add('is-invalid');
		} else {
			nikWarning.classList.add('d-none');
			nikInput.classList.remove('is-invalid');
		}

		if (noKartuInput.value.length !== 16) {
			kkWarning.classList.remove('d-none');
			noKartuInput.classList.add('is-invalid');
		} else {
			kkWarning.classList.add('d-none');
			noKartuInput.classList.remove('is-invalid');
		}
	}

	document.addEventListener('DOMContentLoaded', function() {
		validateNik(); // Validasi saat halaman dimuat

		// disable submit jika ada input yang tidak valid
		const form = document.querySelector('form');
		form.addEventListener('submit', function(event) {
			const nikInput = document.querySelector('input[name="nik"]');
			const noKartuInput = document.querySelector('input[name="no_kartu"]');
			if (nikInput.classList.contains('is-invalid') || noKartuInput.classList.contains('is-invalid')) {
				event.preventDefault(); // Mencegah submit jika ada input yang tidak valid
				alert('Pastikan semua input valid sebelum mengirim form.');
			}

			// Validasi NIK dan No KK saat submit
			validateNik();
			if (nikInput.value.length !== 16 || noKartuInput.value.length !== 16) {
				event.preventDefault(); // Mencegah submit jika NIK atau No KK
				alert('NIK dan No KK harus 16 digit angka.');
			}
		});
	});
</script>