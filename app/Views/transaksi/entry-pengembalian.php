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
        let currentStepPengembalian = <?= json_encode(session()->get('currentStepPengembalian')) ?>;
        console.log(currentStepPengembalian)
        if (currentStepPengembalian) {
            stepper.to(currentStepPengembalian);
        }
        window.stepper = stepper;
    });
</script>
<?php $anggota = session()->get('anggota'); ?>
<div class="card">
    <?php
    // echo json_encode(isset($buku_dipinjam) ? $buku_dipinjam : 'rawr', JSON_PRETTY_PRINT);
    ?>
    <div class="card-header">
        <h3 class="card-title">Daftar Anggota</h3>
    </div>
    <div class="card-body">
        <div class="container">
            <h2 class="text-center">Entry Pengembalian</h2>
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
                                <input type="hidden" name="jenis_transaksi" id="jenis_transaksi" value="pengembalian">
                            </div>
                            <button type="submit" class="btn btn-primary">Check Anggota</button>
                        </form>
                    </div>
                    <!-- Step 2: Tambah Buku -->
                    <div id="buku-step" class="content" role="tabpanel" aria-labelledby="stepper-buku-trigger">
                        <div class="row">
                            <div class="col">
                                <form action="/transaksi/batalkanTransaksi/1" method="post">
                                    <button type="submit" class="btn btn-danger">Batal</button>
                                </form>
                            </div>
                            <div class="col-md-auto">

                                <form action="/transaksi/handlePengembalian" method="post" id="pengembalianForm">
                                    <input type="hidden" id="dikembalikan" name="buku_dikembalikan" value="">
                                    <input type="hidden" id="diperpanjang" name="buku_diperpanjang" value="">
                                    <button type="submit" class="btn btn-warning">Confirm</button>
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
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Kode Buku</th>
                                    <th>Judul</th>
                                    <th>Batas Pengembalian</th>
                                    <th>Denda</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($buku_dipinjam as $buku): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($buku['Kode_Buku']); ?></td>
                                        <td><?= htmlspecialchars($buku['Judul']); ?></td>
                                        <td id="batasKembali_<?= htmlspecialchars($buku['Kode_Buku']); ?>"><?= date('d-m-Y', strtotime($buku['Tanggal_Kembali_Rencana'])); ?></td>
                                        <td id="denda_<?= htmlspecialchars($buku['Kode_Buku']); ?>">
                                            <?= $buku['Denda'] !== null ? 'IDR ' . number_format($buku['Denda'], 0, ',', '.') : '-'; ?>
                                        </td>
                                        <td id="action_wrap" data-kode="data-kode=" <?= htmlspecialchars($buku['Kode_Buku']); ?>"">
                                            <button
                                                class="btn btn-success btn-sm perpanjangBuku"
                                                id="perpanjangBuku_<?= htmlspecialchars($buku['Kode_Buku']); ?>"
                                                data-kode="<?= htmlspecialchars($buku['Kode_Buku']); ?>">
                                                Perpanjang
                                            </button>
                                            <button
                                                class="btn btn-primary btn-sm kembalikanBuku"
                                                id="kembalikanBuku_<?= htmlspecialchars($buku['Kode_Buku']); ?>"
                                                data-kode="<?= htmlspecialchars($buku['Kode_Buku']); ?>">
                                                Dikembalikan
                                            </button>
                                            <button
                                                class="btn btn-danger btn-sm d-none"
                                                id="batalkanAksi_<?= htmlspecialchars($buku['Kode_Buku']); ?>"
                                                data-kode="<?= htmlspecialchars($buku['Kode_Buku']); ?>"
                                                data-action="">
                                                Batalkan Aksi
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>


                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let diPerpanjang = []
    let diKembalikan = []
    $(document).ready(function() {
        const buku_dikembalikan = $('#dikembalikan');
        const buku_diperpanjang = $('#diperpanjang');

        const updateHiddenPengembalian = () => {
            buku_diperpanjang.val(JSON.stringify(diPerpanjang));
            buku_dikembalikan.val(JSON.stringify(diKembalikan));
            console.log('buku_diperpanjang' + buku_diperpanjang.val());
            console.log('buku_dikembalikan : ' + buku_dikembalikan.val());
        };

        $('#pengembalianForm').on('submit', function(event) {
            let dikembalikanValue = $('#dikembalikan').val();
            let diperpanjangValue = $('#diperpanjang').val();

            if (dikembalikanValue === "" && diperpanjangValue === "") {
                event.preventDefault();
                Swal.fire({
                    title: "Tidak ada Aksi Apapun!",
                    text: "Lakukan Pengembalian atau Perpanjangan terlebih dahulu",
                    icon: "warning"
                });
            }
        });

        $('[id^="perpanjangBuku_"]').on('click', function() {
            const clickedId = $(this).attr('id');
            const kodeBuku = $(this).data('kode');
            const batasKembaliEl = $(`#batasKembali_${kodeBuku}`);
            const batasKembali = $(`#batasKembali_${kodeBuku}`).text().trim();
            const denda = $(`#denda_${kodeBuku}`).text().trim();
            const KembaliBtn = $(`#kembalikanBuku_${kodeBuku}`);
            const BatalkanBtn = $(`#batalkanAksi_${kodeBuku}`);

            if (denda == '-') {
                $(this).addClass('d-none');
                KembaliBtn.addClass('d-none');
                BatalkanBtn.removeClass('d-none');
                BatalkanBtn.attr('data-action', 'diperpanjang');
                BatalkanBtn.text('Batalkan Perpanjangan');
                diPerpanjang.push(kodeBuku);

                const [day, month, year] = batasKembali.split('-').map(Number);
                const batasKembaliDate = new Date(year, month - 1, day);

                batasKembaliDate.setDate(batasKembaliDate.getDate() + 14);

                const options = {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric',
                };

                const formattedDate = new Intl.DateTimeFormat('id-ID', options).format(batasKembaliDate).replace(/\//g, '-');

                console.log(formattedDate);
                batasKembaliEl.text(`${formattedDate}`);
                updateHiddenPengembalian();
            } else {
                Swal.fire({
                    title: "Gagal Memperpanjang!",
                    text: "Buku yang kena denda hanya bisa di kembalikan",
                    icon: "warning"
                });
            }
        });

        $('[id^="kembalikanBuku_"]').on('click', function() {
            const clickedId = $(this).attr('id');
            const kodeBuku = $(this).data('kode');
            const batasKembali = $(`#batasKembali_${kodeBuku}`).text().trim();
            const denda = $(`#denda_${kodeBuku}`).text().trim();
            const PerpanjangBtn = $(`#perpanjangBuku_${kodeBuku}`);
            const BatalkanBtn = $(`#batalkanAksi_${kodeBuku}`);

            $(this).addClass('d-none');
            PerpanjangBtn.addClass('d-none');
            BatalkanBtn.removeClass('d-none');
            BatalkanBtn.attr('data-action', 'dikembalikan');
            BatalkanBtn.text('Batalkan Pengembalian');
            diKembalikan.push(kodeBuku);

            updateHiddenPengembalian();
        });

        $('[id^="batalkanAksi_"]').on('click', function() {
            const clickedId = $(this).attr('id');
            const action = $(this).data('action');
            const kodeBuku = $(this).data('kode');
            const batasKembaliEl = $(`#batasKembali_${kodeBuku}`);
            const batasKembali = $(`#batasKembali_${kodeBuku}`).text().trim();
            const denda = $(`#denda_${kodeBuku}`).text().trim();
            const PerpanjangBtn = $(`#perpanjangBuku_${kodeBuku}`);
            const KembaliBtn = $(`#kembalikanBuku_${kodeBuku}`);


            if (action == 'dikembalikan') {
                $(this).addClass('d-none');
                PerpanjangBtn.removeClass('d-none');
                KembaliBtn.removeClass('d-none');
                $(this).attr('data-action', '');
                diKembalikan = diKembalikan.filter(item => item !== kodeBuku)
                updateHiddenPengembalian();
            } else if (action == 'diperpanjang') {
                $(this).addClass('d-none');
                PerpanjangBtn.removeClass('d-none');
                KembaliBtn.removeClass('d-none');
                $(this).attr('data-action', '');

                const [day, month, year] = batasKembali.split('-').map(Number);
                const batasKembaliDate = new Date(year, month - 1, day);

                batasKembaliDate.setDate(batasKembaliDate.getDate() - 14);

                const options = {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric',
                };

                const formattedDate = new Intl.DateTimeFormat('id-ID', options).format(batasKembaliDate).replace(/\//g, '-');
                batasKembaliEl.text(`${formattedDate}`);

                diPerpanjang = diPerpanjang.filter(item => item !== kodeBuku)

                updateHiddenPengembalian();
            }
        });
    });
</script>

<?= $this->endSection() ?>