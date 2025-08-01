<div class="row">
    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">FORM TAMBAH DATA PENGGUNA</h5>
                <small class="text-muted float-end">DATA PENGGUNA</small>
            </div>
            <div class="card-body">
                <br>
                <form action="<?= site_url('user/insert') ?>" method="POST">
                    <div class="form-group">
                        <label>Nama:</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Username:</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password:</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Role:</label>
                        <select name="role" class="form-control">
                            <option value="admin">Admin</option>
                            <option value="pengguna">Pengguna</option>
                        </select>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="<?= site_url('user') ?>" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>