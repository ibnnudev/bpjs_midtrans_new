<div class="row">
    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">FORM PEMBAYARAN BPJS</h5>
                <small class="text-muted float-end">PEMBAYARAN BPJS</small>
            </div>
            <div class="card-body">
                <br>
                <form action="<?= site_url('pembayaran/process_payment'); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="kepesertaan_id" value="<?= $data['kepesertaan_id']; ?>">
                    <input type="hidden" name="metode_pembayaran" value="<?= $data['metode']; ?>">

                    <div class="mb-3">
                        <label>Nama Peserta</label>
                        <input type="text" class="form-control" value="<?= isset($data['nama_peserta']) ? $data['nama_peserta'] : ''; ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label>Jumlah Pembayaran (Rp)</label>
                        <input type="number" class="form-control" name="jumlah_bayar" value="<?= isset($data['harga_kelas']) ? $data['harga_kelas'] : 0; ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label>Metode Pembayaran</label>
                        <input type="text" class="form-control" value="<?= ucfirst($data['metode']); ?>" readonly>
                    </div>

                    <?php if ($data['metode'] == 'qris') : ?>
                        <div class="mb-3">
                            <label>Scan QRIS:</label>
                            <img src="<?= base_url('assets/images/bayar (2).jpeg') ?>" width="200">
                        </div>
                    <?php elseif ($data['metode'] == 'transfer') : ?>
                        <div class="mb-3">
                            <label>Nomor Rekening Transfer:</label>
                            <input type="text" class="form-control" value="123-456-7890 (Bank XYZ)" readonly>
                        </div>
                    <?php elseif ($data['metode'] == 'virtual_account') : ?>
                        <div class="mb-3">
                            <label>Nomor Virtual Account:</label>
                            <input type="text" class="form-control" value="9876543210 (Bank ABC)" readonly>
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label>Upload Bukti Pembayaran:</label>
                        <input type="file" name="bukti_pembayaran" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success">Bayar & Upload Bukti</button>
                </form>
            </div>
        </div>
    </div>
</div>