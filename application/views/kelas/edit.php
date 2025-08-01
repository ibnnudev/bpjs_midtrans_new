<div class="row">
    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">FORM EDIT DATA KELAS</h5>
                <small class="text-muted float-end">DATA KELAS</small>
            </div>
            <div class="card-body">
                <br>
                <form action="<?= site_url('kelas/update/' . $kelas_bpjs->id) ?>" method="post">
                    <div class="mb-3">
                        <label class="form-label" for="nama_kelas">Nama:</label>
                        <input type="text" class="form-control" name="nama_kelas" id="nama_kelas" value="<?= $kelas_bpjs->nama_kelas ?>" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="harga">Harga:</label>
                        <input type="number" class="form-control" name="harga" id="harga" value="<?= $kelas_bpjs->harga ?>" required />
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="<?= site_url('kelas') ?>" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>