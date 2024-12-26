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
        <h3 class="card-title">Daftar Anggota</h3>
    </div>
    <div class="card-body">
        <table id="anggota_table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID Anggota</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No Telepon</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($anggota as $item): ?>
                    <tr>
                        <td><?= $item['ID_Anggota'] ?></td>
                        <td><?= $item['Nama'] ?></td>
                        <td><?= $item['Alamat'] ?></td>
                        <td><?= $item['No_Telepon'] ?></td>
                        <td><?= $item['Email'] ?></td>
                        <td>
                            <a href="/anggota/edit/<?= $item['ID_Anggota'] ?>" class="btn btn-warning">Edit</a>
                            <a href="/anggota/delete/<?= $item['ID_Anggota'] ?>" class="btn btn-danger" onclick="confirmDelete(event, '<?= $item['ID_Anggota'] ?>')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete(e, ID_Anggota) {
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
                window.location.href = "<?= base_url('anggota/delete/') ?>" + ID_Anggota;
            }
        })
    }
</script>

<?= $this->endSection() ?>