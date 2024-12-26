<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>
<script>
    const shakeAlert = (msg) => {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            },
        });
        Toast.fire({
            title: msg,
            icon: "success",
        });
    }

    let successMessage = '<?= session()->getFlashdata('success') ?>'
    if (successMessage) {
        console.log(successMessage)

        shakeAlert(successMessage);
    }
    document.addEventListener('DOMContentLoaded', function() {
        const stepper = new Stepper(document.querySelector('#stepper'));
        stepper.next();
        let currentStepPeminjaman = <?= json_encode(session()->get('currentStepPeminjaman')) ?>;
        console.log(currentStepPeminjaman)
        if (currentStepPeminjaman) {
            stepper.to(currentStepPeminjaman);
        }
        window.stepper = stepper;
    });
</script>
<?php $anggota = session()->get('anggota'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Anggota</h3>
    </div>
    <div class="card-body">
        <div class="container">
            <?php // var_dump($anggota); 
            ?>
            <?php // var_dump(session()->get("anggota.ID_Anggota")); 
            ?>
            <h2 class="text-center">Entry Peminjaman</h2>
            <div id="stepper" class="bs-stepper">
                <div class="bs-stepper-header" role="tablist">
                    <div class="step" data-target="#anggota-step">
                        <button type="button" class="step-trigger" role="tab" id="stepper-anggota-trigger">
                            <span class="bs-stepper-circle">1</span>
                            <span class="bs-stepper-label">Check Anggota</span>
                        </button>
                    </div>
                    <div class="line"></div>
                    <div class="step" data-target="#buku-step">
                        <button type="button" class="step-trigger" role="tab" id="stepper-buku-trigger">
                            <span class="bs-stepper-circle">2</span>
                            <span class="bs-stepper-label">Tambah Buku</span>
                        </button>
                    </div>
                </div>
                <div class="bs-stepper-content">
                    <!-- Step 1: Check Anggota -->
                    <div id="anggota-step" class="content" role="tabpanel" aria-labelledby="stepper-anggota-trigger">
                        <form id="check-anggota-form" action="/transaksi/checkAnggota" method="post">
                            <div class="mb-3">
                                <label for="anggota-id" class="form-label">ID Anggota</label>
                                <input type="text" class="form-control <?= session()->get('anggota404') ? 'is-invalid' : '' ?>" id="anggota-id" name="anggota_id" required>
                                <span class="invalid-feedback">
                                    <?= session()->get('anggota404')  ? session()->get('anggota404')  : '' ?>
                                </span>
                                <input type="hidden" name="jenis_transaksi" id="jenis_transaksi" value="peminjaman">
                            </div>
                            <button type="submit" class="btn btn-primary">Check Anggota</button>
                        </form>
                    </div>
                    <!-- Step 2: Tambah Buku -->
                    <div id="buku-step" class="content" role="tabpanel" aria-labelledby="stepper-buku-trigger">
                        <div class="mb-3">
                            <label for="arrayInput" class="form-label">Kode Buku</label>
                            <input type="text" class="form-control" id="arrayInput">
                            <span class="invalid-feedback" id="invalidFeedback">
                            </span>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="button" id="addButton" class="btn btn-primary">Tambah Buku</button>
                            </div>
                            <div class="col"></div>
                            <div class="col-md-auto">
                                <form action="/transaksi/batalkanTransaksi/2" method="post">
                                    <button type="submit" class="btn btn-danger">Batalkan</button>
                                </form>
                            </div>
                            <!-- <button type="button" class="btn btn-danger" onclick="stepper.next()">Confirm</button> -->
                            <div class="col-md-auto">
                                <form action="/transaksi/finalizePeminjaman/<?= session()->get('anggota.ID_Anggota') ?>" method="post">
                                    <input type="hidden" name="data_array" id="dataArrayInput">
                                    <button type="submit" class="btn btn-success">Selesai</button>
                                </form>
                            </div>
                        </div>
                        <hr>
                        <div class="row invoice-info">
                            <!-- /.col -->
                            <div class="col-sm-5 invoice-col" rel="noopener">
                                <h5>
                                    Informasi Anggota :
                                </h5>
                                <address>
                                    <b>ID Anggota :</b> <?= $anggota['ID_Anggota'] ?? '' ?><br>
                                    <b>Nama :</b> <?= $anggota['Nama'] ?? '' ?><br>
                                    <b>Alamat :</b> <?= $anggota['Alamat'] ?? '' ?><br>
                                    <b>No Telepon :</b> <?= $anggota['No_Telepon'] ?? '' ?><br>
                                    <b>Email :</b> <?= $anggota['Email'] ?? '' ?>
                                </address>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <hr>
                        <h5>Buku yang Dipinjam:</h5>
                        <ul id="buku-list" class="list-group">
                            <li class="list-group-item" id="starterListItem">Belum ada buku yang ditambahkan.</li>
                        </ul>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        const arrayInput = $('#arrayInput');
        const addButton = $('#addButton');
        const arrayList = $('#buku-list');
        const dataArrayInput = $('#dataArrayInput');
        const invalidFeedback = $('#invalidFeedback');
        let unavalibleBook = <?= json_encode($buku_tidak_tersedia) ?>;

        let dataArray = [];

        const updateHiddenInput = () => {
            dataArrayInput.val(JSON.stringify(dataArray));
        };
        console.log(unavalibleBook)
        addButton.click(function() {
            const value = arrayInput.val().trim();
            console.log(unavalibleBook.includes(value))
            if (unavalibleBook.includes(value)) {
                arrayInput.val('').addClass('is-invalid');
                invalidFeedback.text('Buku ini Tidak Tersedia');
            } else if (!value || (isNaN(value) && value !== '')) {
                arrayInput.val('').addClass('is-invalid');
                invalidFeedback.text('Kode Buku tidak di temukan');
            } else if (value && !unavalibleBook.includes(value)) {
                let buku_tersedia = <?= json_encode($buku_tersedia) ?>;
                let kodBukuToFind = value;
                let foundBook = buku_tersedia.find(book => book.Kode_Buku === kodBukuToFind);

                if (foundBook) {
                    dataArray.push([value, foundBook.Judul, foundBook.ISBN]);
                    unavalibleBook.push(value);
                    updateHiddenInput();

                    const li = $('<li></li>')
                        .addClass('list-group-item d-flex justify-content-between align-items-center')
                        .text(`${value} - ${foundBook.Judul}`);

                    const removeButton = $('<button></button>')
                        .addClass('btn btn-danger btn-sm')
                        .text('Remove')
                        .on('click', function() {
                            for (let i = 0; i < dataArray.length; i++) {
                                const index = dataArray[i].indexOf(value);
                                console.log(index)
                                if (index > -1) {
                                    dataArray.splice(i, 1);
                                    updateHiddenInput();
                                    li.remove();
                                    break;
                                }
                            }
                        });

                    li.append(removeButton);
                    let starterListItem = $('#starterListItem');
                    starterListItem.remove();
                    arrayList.append(li);
                    arrayInput.val('').removeClass('is-invalid');
                    shakeAlert('Buku Berhasil Di tambahkan');
                } else {
                    arrayInput.val('').addClass('is-invalid');
                    invalidFeedback.text('Kode Buku tidak di temukan')
                }

            } else {}
        });
    });
</script>

<?= $this->endSection() ?>