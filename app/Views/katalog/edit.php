<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>
<?php $validationErrors = session()->getFlashdata('validation_errors'); ?>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit Deskripsi Buku</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form class="form-horizontal" method="post" action="/katalog/update/<?= $katalog['ISBN'] ?>">
        <div class="card-body">
            <div class="form-group">
                <label for="ISBN">ISBN</label>
                <input type="text" name="ISBN" class="form-control" id="ISBN" value="<?= $katalog['ISBN'] ?>" readonly>
            </div>
            <div class="form-group">
                <label for="Judul">Judul</label>
                <input type="text" name="Judul" class="form-control <?= isset($validationErrors['Judul']) ? 'is-invalid' : '' ?>" id="Judul" value="<?= $katalog['Judul'] ?>">
                <span class="invalid-feedback">
                    <?= $validationErrors['Judul'] ?? '' ?>
                </span>
            </div>
            <div class="form-group">
                <label for="Penulis">Penulis</label>
                <input type="text" name="Penulis" class="form-control <?= isset($validationErrors['Penulis']) ? 'is-invalid' : '' ?>" id="Penulis" value="<?= $katalog['Penulis'] ?>">
                <span class="invalid-feedback">
                    <?= $validationErrors['Penulis'] ?? '' ?>
                </span>
            </div>
            <div class="form-group">
                <label for="Penerbit">Penerbit</label>
                <input type="text" name="Penerbit" class="form-control <?= isset($validationErrors['Penerbit']) ? 'is-invalid' : '' ?>" id="Penerbit" value="<?= $katalog['Penerbit'] ?>">
                <span class="invalid-feedback">
                    <?= $validationErrors['Penerbit'] ?? '' ?>
                </span>
            </div>
            <div class="form-group">
                <label for="Tahun_Terbit">Tahun Terbit</label>
                <input type="number" name="Tahun_Terbit" class="form-control <?= isset($validationErrors['Tahun_Terbit']) ? 'is-invalid' : '' ?>" id="Tahun_Terbit" value="<?= $katalog['Tahun_Terbit'] ?>">
                <span class="invalid-feedback">
                    <?= $validationErrors['Tahun_Terbit'] ?? '' ?>
                </span>
            </div>
            <div class="form-group">
                <label for="Jumlah_Eksemplar">Jumlah Eksemplar</label>
                <input type="number" name="Jumlah_Eksemplar" class="form-control <?= isset($validationErrors['Jumlah_Eksemplar']) ? 'is-invalid' : '' ?>" id="Jumlah_Eksemplar" value="<?= $katalog['Jumlah_Eksemplar'] ?>">
                <span class="invalid-feedback">
                    <?= $validationErrors['Jumlah_Eksemplar'] ?? '' ?>
                </span>
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>