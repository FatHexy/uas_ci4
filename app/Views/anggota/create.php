<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>
<?php $validationErrors = session()->getFlashdata('validation_errors'); ?>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Tambah Anggota</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form class="form-horizontal" method="post" action="/anggota/store">
        <div class="card-body">
            <div class="form-group">
                <label for="Nama">Nama</label>
                <input type="text" name="Nama"
                    class="form-control <?= isset($validationErrors['Nama']) ? 'is-invalid' : '' ?>"
                    id="Nama"
                    value="<?= old('Nama') ?>">
                <span class="invalid-feedback">
                    <?= $validationErrors['Nama'] ?? '' ?>
                </span>
            </div>
            <div class="form-group">
                <label for="Alamat">Alamat</label>
                <input type="text" name="Alamat"
                    class="form-control <?= isset($validationErrors['Alamat']) ? 'is-invalid' : '' ?>"
                    id="Alamat"
                    value="<?= old('Alamat') ?>">
                <span class="invalid-feedback">
                    <?= $validationErrors['Alamat'] ?? '' ?>
                </span>
            </div>
            <div class="form-group">
                <label for="No_Telepon">No Telepon</label>
                <input type="text" name="No_Telepon"
                    class="form-control <?= isset($validationErrors['No_Telepon']) ? 'is-invalid' : '' ?>"
                    id="No_Telepon"
                    value="<?= old('No_Telepon') ?>">
                <span class="invalid-feedback">
                    <?= $validationErrors['No_Telepon'] ?? '' ?>
                </span>
            </div>
            <div class="form-group">
                <label for="Email">Email</label>
                <input type="text" name="Email"
                    class="form-control <?= isset($validationErrors['Email']) ? 'is-invalid' : '' ?>"
                    id="Email"
                    value="<?= old('Email') ?>">
                <span class="invalid-feedback">
                    <?= $validationErrors['Email'] ?? '' ?>
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