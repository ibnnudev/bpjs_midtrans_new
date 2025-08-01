<div class="row">
    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">FORM EDIT DATA FASILITAS KESEHATAN</h5>
                <small class="text-muted float-end">DATA FASILITAS KESEHATAN</small>
            </div>
            <div class="card-body">
                <br>
                <form action="<?= site_url('faskes/update/' . $faskes->id) ?>" method="post">
                    <div class="mb-3">
                        <label class="form-label" for="nama_faskes">Nama:</label>
                        <input type="text" class="form-control" name="nama_faskes" id="nama_faskes" value="<?= $faskes->nama_faskes ?>" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="alamat">Alamat:</label>
                        <textarea class="form-control" name="alamat" id="alamat" required><?= $faskes->alamat ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="telepon">No HP:</label>
                        <input type="text" class="form-control" name="telepon" id="telepon" value="<?= $faskes->telepon ?>" required />
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="<?= site_url('faskes') ?>" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>