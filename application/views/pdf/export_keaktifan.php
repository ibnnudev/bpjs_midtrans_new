<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Keaktifan Kepesertaan BPJS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .center {
            text-align: center;
        }
    </style>
</head>

<body>

    <h2 class="center">Laporan Keaktifan Kepesertaan BPJS</h2>
    <hr>

    <table class="table">
        <tr>
            <th>Nomor Kartu BPJS</th>
            <td><?= $kepesertaan->no_kartu; ?></td>
        </tr>
        <tr>
            <th>NIK</th>
            <td><?= $kepesertaan->nik; ?></td>
        </tr>
        <tr>
            <th>Nama</th>
            <td><?= $kepesertaan->nama; ?></td>
        </tr>
        <tr>
            <th>Faskes</th>
            <td><?= $faskes->nama_faskes; ?></td>
        </tr>
        <tr>
            <th>Kelas BPJS</th>
            <td><?= $kelas->nama_kelas; ?></td>
        </tr>
        <tr>
            <th>Status Kepesertaan</th>
            <td>
                <span style="color: <?= ($status_aktif == 'Aktif') ? 'green' : 'red'; ?>;">
                    <?= $status_aktif; ?>
                </span>
            </td>
        </tr>
    </table>

    <p class="center">Dokumen ini sebagai bukti keaktifan kepesertaan BPJS.</p>

</body>

</html>