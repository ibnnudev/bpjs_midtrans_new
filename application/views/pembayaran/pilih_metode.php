<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<div class="col-lg-12 mb-4 order-0">
	<div class="row">
		<div class="col-xl">
			<div class="card mb-4">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h5 class="mb-0">Pilih Metode Pembayaran & Tipe Pembayaran</h5>
					<small class="text-muted float-end">Metode Pembayaran</small>
				</div>
				<div class="card-body">
					<br>
					<div class="row">
						<div class="col-md-12 mb-5">
							<select name="tipe_pembayaran" id="tipe_pembayaran" class="form-control fs-7">
								<?php if ($after_current_month): ?>
									<option value="">Pilih Metode Pembayaran</option>
									<option value="iuran">Iuran</option>
								<?php elseif (!$after_current_month): ?>

									<?php if (empty($pembayaran)): ?>
										<option value="registrasi" <?= ($same_month_year ? 'selected' : '') ?>>Registrasi</option>
									<?php endif; ?>

									<?php if (!$same_month_year): ?>
										<option value="iuran">Iuran</option>
									<?php endif; ?>

								<?php endif; ?>
							</select>
						</div>
						<div class="col-12">
							<button class="btn btn-primary w-100 d-flex align-items-center justify-content-center" onclick="onBayar()">
								<span>Bayar</span>
							</button>
						</div>
						<!-- Metode Transfer Bank -->
						<!-- <div class="col-md-4">
                            <div class="card shadow-sm text-center p-3 method-card" data-method="transfer">
                                <img src="<?= base_url('assets/images/bayar (3).jpeg') ?>" alt="Transfer Bank" class="img-fluid mb-2" width="80">
                                <h6>Transfer Bank</h6>
                            </div>
                        </div> -->

						<!-- Metode Virtual Account -->
						<!-- <div class="col-md-4">
                            <div class="card shadow-sm text-center p-3 method-card" data-method="virtual_account">
                                <img src="<?= base_url('assets/images/bayar (1).jpeg') ?>" alt="Virtual Account" class="img-fluid mb-2" width="80">
                                <h6>Virtual Account</h6>
                            </div>
                        </div> -->

						<!-- Metode QRIS -->
						<!-- <div class="col-md-4">
                            <div class="card shadow-sm text-center p-3 method-card" data-method="qris">
                                <img src="<?= base_url('assets/images/bayar (2).jpeg') ?>" alt="QRIS" class="img-fluid mb-2" width="80">
                                <h6>QRIS</h6>
                            </div>
                        </div> -->
					</div>

					<!-- Form Hidden untuk Redirect -->
					<form id="paymentForm" action="<?= site_url('pembayaran/bayar'); ?>" method="get">
						<input type="hidden" name="kepesertaan_id" value="<?= $kepesertaan_id; ?>">
						<input type="hidden" name="metode" id="selectedMethod">
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	function onBayar() {
		let tipePembayaran = document.getElementById("tipe_pembayaran").value;

		if (!tipePembayaran) {
			alert("Silakan pilih tipe pembayaran terlebih dahulu.");
			return;
		}

		fetch('<?= site_url("pembayaran/get_midtrans_token") ?>', {
				method: "POST",
				headers: {
					"Content-Type": "application/json"
				},
				body: JSON.stringify({
					tipe_pembayaran: tipePembayaran,
					kepesertaan_id: '<?= $kepesertaan_id; ?>'
				})
			})
			.then(response => response.json())
			.then(data => {
				console.log("Response token Midtrans:", data); // Tambahkan ini untuk debug
				if (data.token) {
					snap.pay(data.token, {
						onSuccess: function(result) {
							fetch('<?= site_url("pembayaran/process_payment") ?>', {
								method: "POST",
								headers: {
									"Content-Type": "application/json"
								},
								body: JSON.stringify(result)
							}).then(() => {
								alert("Pembayaran berhasil!");
								window.location.href = '<?= site_url("pembayaran") ?>';
							});
						},
						onPending: function(result) {
							alert("Pembayaran dalam proses!");
							window.location.href = '<?= site_url("pembayaran") ?>';
						},
						onError: function(result) {
							alert("Pembayaran gagal!");
							window.location.href = '<?= site_url("pembayaran") ?>';
						}
					});
				} else {
					alert("Gagal mendapatkan token pembayaran.");
				}
			})
			.catch(error => console.error("Error:", error));
	}

	document.addEventListener("DOMContentLoaded", function() {
		$('#tipe_pembayaran').select2({
			width: '100%',
			placeholder: 'Pilih Tipe Pembayaran',
			allowClear: true,
		});
	});
</script>