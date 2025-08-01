<a href="<?= site_url('user/create') ?>" class="btn btn-primary mb-3">Tambah Pengguna</a>
<div class="card">
    <div class="card-header">
        <h5>Data Pengguna</h5>
    </div>
    <div class="card-body">
        <br>
        <table id="userTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($users as $user): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $user['name'] ?></td>
                        <td><?= $user['username'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td><?= $user['role'] ?></td>
                        <td>
                            <a href="<?= site_url('user/edit/' . $user['id']) ?>" class="btn btn-warning">Edit</a>
                            <a href="<?= site_url('user/delete/' . $user['id']) ?>" class="btn btn-danger" onclick="return confirm('Hapus user ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#userTable').DataTable();
    });
</script>