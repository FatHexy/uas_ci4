<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>

<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row d-flex justify-content-center">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3><?= $jumlah_buku ?></h3>
                        <p>Jumlah Buku</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-book"></i> <!-- Ikon Buku -->
                    </div>
                    <a href="/katalog" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= $jumlah_anggota ?></h3>

                        <p>Anggota</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="/anggota" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?= $jumlah_transaksi ?></h3>

                        <p>Transaksi </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                    <a href="/transaksi" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>

        <div class="container mt-5">
            <h3 class="text-center mb-4">Transaksi Aktif</h3>
            <table id="transaksiTable" class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>ID Transaksi</th>
                        <th>ID Anggota</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    if (count($transaksi) > 0) {
                        $no = 1;
                        foreach ($transaksi as $row) { ?>
                            <tr>
                                <td>
                                    <?= $no++ ?>
                                </td>
                                <td>
                                    <a href="/transaksi/invoice/<?= $row['ID_Transaksi'] ?>"> <?= $row['ID_Transaksi'] ?></a>
                                </td>
                                <td>
                                    <?= $row['anggota_ID_Anggota'] ?>
                                </td>
                                <td>
                                    <?= $row['Tanggal_Pinjam'] ?>
                                </td>
                                <td>
                                    <?= $row['Tanggal_Kembali_Rencana'] ?>
                                </td>
                                <td>
                                    <?= $row['Status'] ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td class="text-center" colspan="6">Tidak Ada Transaksi Aktif</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

</section>
<?= $this->endSection() ?>