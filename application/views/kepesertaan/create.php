<div class="col-lg-12 mb-4 order-0">
	<div class="row">
		<div class="col-xl">
			<div class="card mb-4">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h5 class="mb-0">FORM TAMBAH DATA KEPESERTAAN</h5>
					<small class="text-muted float-end">DATA KEPESERTAAN</small>
				</div>
				<div class="card-body">
					<br>
					<form action="<?= site_url('kepesertaan/store') ?>" method="post" enctype="multipart/form-data">
						<div class="mb-3">
							<label class="form-label" for="foto_ktp">Upload Foto KTP:</label>
							<input type="file" class="form-control <?= form_error('foto_ktp') ? 'is-invalid' : '' ?>" name="foto_ktp" id="foto_ktp" accept="image/*" />
							<?= form_error('foto_ktp', '<div class="invalid-feedback">', '</div>') ?>
						</div>
						<div class="mb-3">
							<label class="form-label" for="no_kartu">No KK :</label>
							<input type="number" class="form-control <?= form_error('no_kartu') ? 'is-invalid' : '' ?>" name="no_kartu" id="no_kartu" required placeholder="Masukkan Nomor KK" value="<?= set_value('no_kartu') ?>" />
							<?= form_error('no_kartu', '<div class="invalid-feedback">', '</div>') ?>
						</div>

						<div class="mb-3">
							<label class="form-label" for="nik">NIK:</label>
							<small id="nikWarning" style="color: red; display: none; font-size: 0.875em; margin-bottom: 5px; background-color: #f8d7da; padding: 5px; border-radius: 3px; border: 1px solid #f5c6cb;">
								NIK harus 16 digit angka.
							</small>
							<input type="text" class="form-control <?= form_error('nik') ? 'is-invalid' : '' ?>" name="nik" id="nik" required placeholder="Masukkan NIK" value="<?= set_value('nik') ?>" maxlength="16" />
							<?= form_error('nik', '<div class="invalid-feedback">', '</div>') ?>
						</div>

						<!-- input nama -->
						<div class="mb-3">
							<label class="form-label" for="nama">Nama:</label>
							<small id="namaWarning" style="color: red; display: none; font-size: 0.875em; margin-bottom: 5px; background-color: #f8d7da; padding: 5px; border-radius: 3px; border: 1px solid #f5c6cb;">
								Nama hanya boleh huruf kapital dan spasi.
							</small>


							<input type="text" class="form-control <?= form_error('nama') ? 'is-invalid' : '' ?>" name="nama" id="nama" required placeholder="Masukkan Nama" value="<?= set_value('nama') ?>" />
							<?= form_error('nama', '<div class="invalid-feedback">', '</div>') ?>
						</div>

						<script>
							document.addEventListener("DOMContentLoaded", function() {
								const namaInput = document.getElementById("nama");
								const namaWarning = document.getElementById("namaWarning");
								const submitBtn = document.querySelector("button[type='submit']");

								function validateNama() {
									const nama = namaInput.value.trim();
									const isCapital = /^[A-Z\s]+$/.test(nama);

									if (!isCapital || nama === "") {
										namaWarning.style.display = "block";
										submitBtn.disabled = true;
									} else {
										namaWarning.style.display = "none";
										submitBtn.disabled = false;
									}
								}

								namaInput.addEventListener("input", validateNama);
								namaInput.addEventListener("blur", validateNama);
							});
							// Validasi hanya huruf dan spasi untuk input nama
							const namaInput = document.getElementById("nama");
							const namaWarning = document.getElementById("namaWarning");

							function validateNamaHuruf() {
								const nama = namaInput.value.trim();
								const hurufSaja = /^[A-Z\s]+$/;

								if (!hurufSaja.test(nama)) {
									namaWarning.textContent = "Nama hanya boleh huruf kapital dan spasi.";
									namaWarning.style.display = "block";
									submitBtn.disabled = true;
								} else {
									namaWarning.style.display = "none";
									submitBtn.disabled = false;
								}
							}

							namaInput.addEventListener("input", validateNamaHuruf);
							namaInput.addEventListener("blur", validateNamaHuruf);
						</script>


						<div class="mb-3">
							<label class="form-label" for="tanggal_lahir">Tanggal Lahir:</label>
							<input type="date" class="form-control <?= form_error('tanggal_lahir') ? 'is-invalid' : '' ?>" name="tanggal_lahir" id="tanggal_lahir" required value="<?= set_value('tanggal_lahir') ?>" />
							<?= form_error('tanggal_lahir', '<div class="invalid-feedback">', '</div>') ?>
						</div>

						<div class="mb-3">
							<label class="form-label" for="jenis_kelamin">Jenis Kelamin:</label>
							<select class="form-control <?= form_error('jenis_kelamin') ? 'is-invalid' : '' ?>" name="jenis_kelamin" id="jenis_kelamin">
								<option value="">Pilih Jenis Kelamin</option>
								<option value="Laki-laki" <?= set_select('jenis_kelamin', 'Laki-laki') ?>>Laki-laki</option>
								<option value="Perempuan" <?= set_select('jenis_kelamin', 'Perempuan') ?>>Perempuan</option>
							</select>
							<?= form_error('jenis_kelamin', '<div class="invalid-feedback">', '</div>') ?>
						</div>

						<div class="mb-3">
							<label class="form-label" for="alamat">Alamat:</label>
							<textarea class="form-control <?= form_error('alamat') ? 'is-invalid' : '' ?>" name="alamat" id="alamat" required><?= set_value('alamat') ?></textarea>
							<?= form_error('alamat', '<div class="invalid-feedback">', '</div>') ?>
						</div>

						<div class="mb-3">
							<label class="form-label" for="no_hp">No HP:</label>
							<!-- Notifikasi error -->
							<small id="noHpWarning" style="color: red; display: none; font-size: 0.875em; margin-bottom: 5px; background-color: #f8d7da; padding: 5px; border-radius: 3px; border: 1px solid #f5c6cb;">
								Nomor HP harus 10–12 digit angka.
							</small>

							<input
								type="text"
								class="form-control <?= form_error('no_hp') ? 'is-invalid' : '' ?>"
								name="no_hp"
								id="no_hp"
								required
								maxlength="13"
								pattern="\d*"
								oninput="this.value = this.value.replace(/[^0-9]/g, '')"
								value="<?= set_value('no_hp') ?>"
								placeholder="Masukkan No HP (10–12 digit)" />
							<?= form_error('no_hp', '<div class="invalid-feedback">', '</div>') ?>
						</div>



						<div class="mb-3">
							<label class="form-label" for="email">Email:</label>
							<input type="email" class="form-control <?= form_error('email') ? 'is-invalid' : '' ?>" name="email" id="email" value="<?= set_value('email', $this->session->userdata('email')) ?>" readonly />
							<?= form_error('email', '<div class="invalid-feedback">', '</div>') ?>
						</div>

						<div class="mb-3">
							<label class="form-label" for="faskes_id">Fasilitas Kesehatan:</label>
							<select class="form-control <?= form_error('faskes_id') ? 'is-invalid' : '' ?>" name="faskes_id" id="faskes_id" required>
								<option value="">Pilih Fasilitas Kesehatan</option>
								<?php foreach ($faskes as $f) : ?>
									<option value="<?= $f->id ?>" <?= set_select('faskes_id', $f->id) ?>><?= $f->nama_faskes ?></option>
								<?php endforeach; ?>
							</select>
							<?= form_error('faskes_id', '<div class="invalid-feedback">', '</div>') ?>
						</div>

						<div class="mb-3">
							<label class="form-label" for="kelas_id">Kelas:</label>
							<select class="form-control <?= form_error('kelas_id') ? 'is-invalid' : '' ?>" name="kelas_id" id="kelas_id" required>
								<option value="">Pilih Kelas</option>
								<?php foreach ($kelas as $k) : ?>
									<option value="<?= $k->id ?>" <?= set_select('kelas_id', $k->id) ?>><?= $k->nama_kelas ?></option>
								<?php endforeach; ?>
							</select>
							<?= form_error('kelas_id', '<div class="invalid-feedback">', '</div>') ?>
						</div>

						<div class="mb-3">
							<label class="form-label" for="user_id">Pilih pengguna:</label>
							<select class="form-control <?= form_error('user_id') ? 'is-invalid' : '' ?>" name="user_id" id="user_id">
								<option value="">-- Pilih User --</option>
								<?php foreach ($users as $user): ?>
									<option value="<?= $user->id; ?>" <?= set_select('user_id', $user->id) ?>><?= $user->name; ?> (<?= $user->username; ?>)</option>
								<?php endforeach; ?>
							</select>
							<?= form_error('user_id', '<div class="invalid-feedback">', '</div>') ?>
						</div>

						<a href="<?= site_url('kepesertaan') ?>" class="btn btn-secondary">Kembali</a>
						<button type="submit" class="btn btn-primary" id="submitBtn">Simpan</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Javascript untuk Validasi -->
<script>
	const submitBtn = document.getElementById("submitBtn");
	const formInputs = document.querySelectorAll("input[required], select[required], textarea[required]");

	// Fungsi untuk validasi NIK
	function validateNik() {
		const nikInput = document.getElementById("nik");
		const nikWarning = document.getElementById("nikWarning");
		const nik = nikInput.value.trim();

		if (nik.length !== 16 || isNaN(nik)) {
			nikWarning.style.display = "block"; // Menampilkan pesan peringatan
			submitBtn.disabled = true; // Menonaktifkan tombol submit
		} else {
			nikWarning.style.display = "none"; // Menyembunyikan pesan peringatan
			submitBtn.disabled = false; // Mengaktifkan tombol submit
		}
	}


	// Fungsi untuk validasi semua input
	function validateForm() {
		let valid = true;
		formInputs.forEach(input => {
			if (input.type === "text" && input.value.trim() === "") {
				valid = false; // Jika ada input kosong, form dianggap tidak valid
			}
			if (input.type === "number" && isNaN(input.value)) {
				valid = false; // Jika input angka tidak valid
			}
			if (input.type === "select-one" && input.value === "") {
				valid = false; // Jika input select tidak dipilih
			}
		});

		// Jika ada input yang tidak valid, tombol submit akan dinonaktifkan
		submitBtn.disabled = !valid;
	}

	// Event listener untuk validasi NIK
	const nikInput = document.getElementById("nik");
	nikInput.addEventListener("input", validateNik);
	nikInput.addEventListener("blur", validateNik); // Juga validasi saat input hilang fokus

	// Event listener untuk form input lainnya
	formInputs.forEach(input => {
		input.addEventListener("input", validateForm); // Validasi semua input saat ada perubahan
	});

	// Event listener untuk submit form jika form valid
	submitBtn.addEventListener("click", function(event) {
		if (submitBtn.disabled) {
			event.preventDefault(); // Mencegah pengiriman form jika tombol submit dinonaktifkan
		}
	});
	// Validasi No HP
	const noHpInput = document.getElementById("no_hp");
	const noHpWarning = document.getElementById("noHpWarning");

	function validateNoHp() {
		const noHp = noHpInput.value.trim();
		if (noHp.length < 10 || noHp.length > 12 || isNaN(noHp)) {
			noHpWarning.style.display = "block";
			submitBtn.disabled = true;
		} else {
			noHpWarning.style.display = "none";
			submitBtn.disabled = false;
		}
	}

	noHpInput.addEventListener("input", validateNoHp);
	noHpInput.addEventListener("blur", validateNoHp);


	const noKKInput = document.getElementById("no_kartu");
	const noKKWarning = document.createElement("small");
	noKKWarning.id = "noKKWarning";
	noKKWarning.style = "color: red; display: none; font-size: 0.875em; margin-bottom: 5px; background-color: #f8d7da; padding: 5px; border-radius: 3px; border: 1px solid #f5c6cb;";
	noKKWarning.innerText = "Nomor KK harus 16 digit angka.";
	noKKInput.parentNode.insertBefore(noKKWarning, noKKInput); // letakkan di atas kolom input

	function validateNoKK() {
		const val = noKKInput.value.trim();

		if (val.length === 16 && !isNaN(val)) {
			noKKWarning.style.display = "none";
			noKKInput.readOnly = true; // kunci input
			noKKInput.blur(); // hilangkan fokus agar tidak biru
			submitBtn.disabled = false;
		} else {
			noKKWarning.style.display = "block";
			noKKInput.readOnly = false;
			submitBtn.disabled = true;
		}
	}


	// Jika ingin input bisa dihapus lagi saat backspace
	noKKInput.addEventListener("keydown", function(e) {
		if (noKKInput.readOnly && (e.key === "Backspace" || e.key === "Delete")) {
			noKKInput.readOnly = false;
		}
	});

	// Jalankan validasi saat input berubah
	noKKInput.addEventListener("input", validateNoKK);
	noKKInput.addEventListener("blur", validateNoKK);
</script>

<style>
	/* Styling untuk notifikasi */
	.invalid-feedback {
		background-color: #f8d7da;
		color: #721c24;
		border: 1px solid #f5c6cb;
		padding: 12px 20px;
		border-radius: 25px;
		width: fit-content;
		display: inline-block;
		font-size: 14px;
		position: relative;
		top: -5px;
		margin-top: 5px;
		box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
		transition: transform 0.3s ease, opacity 0.3s ease;
	}

	.invalid-feedback:hover {
		transform: scale(1.1);
		opacity: 0.9;
	}

	.invalid-feedback:before {
		content: "";
		position: absolute;
		bottom: -10px;
		left: 20px;
		width: 0;
		height: 0;
		border-left: 10px solid transparent;
		border-right: 10px solid transparent;
		border-top: 10px solid #f5c6cb;
	}

	/* Hilangkan spinner number */
	input[type=number]::-webkit-inner-spin-button,
	input[type=number]::-webkit-outer-spin-button {
		-webkit-appearance: none;
		margin: 0;
	}

	input[type=number] {
		-moz-appearance: textfield;
	}

	input:focus {
		outline: none !important;
		box-shadow: none !important;
		border-color: #ced4da !important;
		/* warna default border input bootstrap */
		background-color: white !important;
	}


	input[readonly] {
		background-color: white !important;
		color: #212529;
		/* warna teks normal bootstrap */
	}
</style>