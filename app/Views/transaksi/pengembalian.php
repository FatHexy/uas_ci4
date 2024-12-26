<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Daftar Pengembalian Anggota</h3>
    </div>
    <div class="card-body">
        <table id="peminjaman_table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID Anggota</th>
                    <th>Nama</th>
                    <th>Transaksi yang Selesai</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tableData as $item): ?>
                    <tr>
                        <td><?= $item['ID_Anggota'] ?></td>
                        <td><?= $item['Nama'] ?></td>
                        <td> <a href="/transaksi/invoice/<?= $item['ID_Transaksi'] ?>"> <?= $item['ID_Transaksi'] ?></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>