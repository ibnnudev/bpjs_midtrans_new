<a href="<?= site_url('kelas/create') ?>" class="btn btn-primary mb-3">Tambah Kelas</a>
<div class="card">
    <div class="card-header">
        <h5>Data Kelas</h5>
    </div>
    <div class="card-body">
        <br>
        <table id="kelasTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Nama Kelas</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($kelas_bpjs as $k) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $k->nama_kelas ?></td>
                        <td><?= $k->harga ?></td>
                        <td>
                            <a href="<?= site_url('kelas/edit/' . $k->id) ?>" class="btn btn-warning">Edit</a>
                            <a href="<?= site_url('kelas/delete/' . $k->id) ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kelas ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#kelasTable').DataTable();
    });
</script>
<!-- Footer -->