<div class="row">
    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">FORM EDIT DATA PENGGUNA</h5>
                <small class="text-muted float-end">DATA PENGGUNA</small>
            </div>
            <div class="card-body">
                <br>
                <form action="<?= site_url('user/update/' . $user['id']) ?>" method="POST">
                    <div class="form-group">
                        <label>Nama:</label>
                        <input type="text" name="name" class="form-control" value="<?= $user['name'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Username:</label>
                        <input type="text" name="username" class="form-control" value="<?= $user['username'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" class="form-control" value="<?= $user['email'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Role:</label>
                        <select name="role" class="form-control">
                            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="pengguna" <?= $user['role'] == 'pengguna' ? 'selected' : '' ?>>Pengguna</option>
                        </select>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="<?= site_url('user') ?>" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>