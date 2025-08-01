<div class="card">
    <div class="card-header">
        <h5>Data Pembayaran BPJS</h5>
    </div>
    <div class="card-body">
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Peserta</th>
                    <th>Bulan</th>
                    <th>Jumlah Bayar</th>
                    <th>Tipe Pembayaran</th>
                    <th>Metode Pembayaran</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($pembayaran as $p):
                    $date = DateTime::createFromFormat('m-Y', $p->bulan);
                    $metode = "";
                    if (!empty($p->metode_pembayaran)) {
                        $metode =  ucwords(str_replace('_', ' ', $p->metode_pembayaran));
                    }
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $p->nama; ?></td> <!-- Bisa diganti dengan nama jika ada relasi -->
                        <td><?= $date->format('M Y') ?></td>
                        <td>Rp<?= number_format($p->jumlah_bayar, 2, ',', '.'); ?></td>
                        <td><?= ucfirst($p->tipe_pembayaran); ?></td>
                        <td><?= $metode ?></td>
                        <td>
                            <span class="badge bg-<?= $p->status == 'lunas' ? 'success' : 'warning' ?>">
                                <?= ucfirst($p->status); ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= site_url('pembayaran/show/' . $p->id) ?>" class="btn btn-info btn-sm">
                                Show
                            </a>
                            <?php if ($this->session->userdata('role') == 'admin'): ?>
                                <a href="<?= site_url('pembayaran/hapus/' . $p->id); ?>" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus pembayaran ini?');">Hapus</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>