<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Daftar Peminjaman Anggota</h3>
    </div>
    <div class="card-body">
        <table id="peminjaman_table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID Anggota</th>
                    <th>Nama</th>
                    <th>Transaksi yang Aktif</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $currentIdAnggota = null;
                foreach ($tableData as $item):
                    if ($item['ID_Anggota'] !== $currentIdAnggota):
                        $currentIdAnggota = $item['ID_Anggota'];
                ?>
                        <tr>
                            <td><?= $item['ID_Anggota'] ?></td>
                            <td><?= $item['Nama'] ?></td>
                            <td>
                                <a href="/transaksi/invoice/<?= $item['ID_Transaksi'] ?>"><?= $item['ID_Transaksi'] ?></a>
                            </td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="2"></td>
                            <td>
                                <a href="/transaksi/invoice/<?= $item['ID_Transaksi'] ?>"><?= $item['ID_Transaksi'] ?></a>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>