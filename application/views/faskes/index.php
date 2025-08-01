<a href="<?= site_url('faskes/seed') ?>" class="btn btn-success mb-3" onclick="return confirm('Yakin ingin impor semua Puskesmas di Purworejo?')">
	Tambah Puskesmas Purworejo
</a>

<div class="card">
	<div class="card-header">
		<h5>Data Puskesmas Kabupaten Purworejo</h5>
	</div>
	<div class="card-body">
		<br>
		<table id="faskesTable" class="table table-bordered">
			<thead>
				<tr>
					<th>NO</th>
					<th>Nama Faskes</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$no = 1;
				foreach ($faskes as $f) : ?>
					<tr>
						<td><?= $f->id; ?></td>
						<td><?= $f->nama_faskes ?></td>
						<td>
							<a href="<?= site_url('faskes/edit/' . $f->id) ?>" class="btn btn-warning">Edit</a>
							<a href="<?= site_url('faskes/delete/' . $f->id) ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus faskes ini?');">Hapus</a>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<script>
	$(document).ready(function() {
		$('#faskesTable').DataTable();
	});
</script>
<!-- Footer -->