<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>
<script>
    let successMessage = '<?= session()->getFlashdata('success') ?>'
    if (successMessage) {
        console.log(successMessage)

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
            title: successMessage,
            icon: "success",
        });
    }
</script>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-file-circle-plus"></i> Daftar Katalog Buku</h3>
    </div>
    <div class="card-body">
        <table id="katalog_table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>ISBN</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun Terbit</th>
                    <th>Jumlah Eksemplar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($katalog as $item): ?>
                    <tr>
                        <td><?= $item['Judul'] ?></td>
                        <td><?= $item['ISBN'] ?></td>
                        <td><?= $item['Penulis'] ?></td>
                        <td><?= $item['Penerbit'] ?></td>
                        <td><?= $item['Tahun_Terbit'] ?></td>
                        <td><?= $item['Jumlah_Eksemplar'] ?></td>
                        <td>
                            <a href="/katalog/edit/<?= $item['ISBN'] ?>" class="btn btn-warning">Edit</a>
                            <a href="/katalog/delete/<?= $item['ISBN'] ?>" class="btn btn-danger" onclick="confirmDelete(event, '<?= $item['ISBN'] ?>')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete(e, ISBN) {
        e.preventDefault()
        Swal.fire({
            title: 'Apakah Anda yakin ingin menghapus buku ini?',
            text: 'Anda tidak akan dapat mengembalikan ini!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yakin',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('katalog/delete/') ?>" + ISBN;
            }
        })
    }
</script>

<?= $this->endSection() ?>