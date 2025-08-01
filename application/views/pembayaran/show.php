<div class="card">
    <div class="card-header">
        <h5>Detail Pembayaran BPJS</h5>
    </div>
    <div class="card-body">
        <br>
        <table class="table table-bordered">
            <tr>
                <th>Nama Peserta</th>
                <td><?= $pembayaran->nama; ?></td> <!-- Bisa diganti dengan relasi ke nama peserta -->
            </tr>
            <tr>
                <th>Bulan</th>
                <td><?= $pembayaran->bulan; ?></td>
            </tr>
            <tr>
                <th>Jumlah Bayar</th>
                <td>Rp<?= number_format($pembayaran->jumlah_bayar, 2, ',', '.'); ?></td>
            </tr>
            <tr>
                <th>Tanggal Bayar</th>
                <td><?= date('d M Y', strtotime($pembayaran->tanggal_bayar)) ?></td>
            </tr>
            <tr>
                <?php
                $metode = "";
                if (!empty($pembayaran->metode_pembayaran)) {
                    $metode =  ucwords(str_replace('_', ' ', $pembayaran->metode_pembayaran));
                }
                ?>
                <th>Metode Pembayaran</th>
                <td><?= $metode ?></td>
            </tr>
            <tr>
                <th>Tipe Pembayaran</th>
                <td><?= ucfirst($pembayaran->tipe_pembayaran) ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    <span class="badge bg-<?= $pembayaran->status == 'lunas' ? 'success' : 'warning' ?>">
                        <?= ucfirst($pembayaran->status); ?>
                    </span>
                </td>
            </tr>
            <!-- <tr>
                <th>Bukti Pembayaran</th>
                <td>
                    <?php if (!empty($pembayaran->bukti_pembayaran)) : ?>
                        <img src="<?= base_url('uploads/bukti_pembayaran/' . $pembayaran->bukti_pembayaran); ?>"
                            alt="Bukti Pembayaran" class="img-thumbnail" width="300">
                        <br>
                        <a href="<?= base_url('uploads/bukti_pembayaran/' . $pembayaran->bukti_pembayaran); ?>"
                            target="_blank" class="btn btn-primary btn-sm mt-2">Lihat Bukti</a>
                    <?php else : ?>
                        <span class="text-danger">Belum ada bukti pembayaran</span>
                    <?php endif; ?>
                </td>
            </tr> -->
        </table>
        <br>
        <div class="d-flex align-items-center justify-content-between">
            <a href="<?= site_url('pembayaran') ?>" class="btn btn-secondary btn-sm me-2">Kembali</a>
            <?php if ($pembayaran->status == 'pending'): ?>
                <button class="btn btn-info btn-sm text-white" onclick="reopenSnap('<?= $pembayaran->order_id; ?>')">
                    Konfirmasi
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
    function reopenSnap(orderId) {
        fetch("<?= site_url('pembayaran/get_existing_midtrans_token') ?>", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    order_id: orderId
                })
            })
            .then(response => response.json())
            .then(data => {
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
                            alert("Menunggu pembayaran.");
                        },
                        onError: function(result) {
                            alert("Pembayaran gagal.");
                        }
                    });
                } else {
                    alert("Gagal mendapatkan token pembayaran.");
                }
            })
            .catch(error => console.error("Error:", error));
    }
</script>