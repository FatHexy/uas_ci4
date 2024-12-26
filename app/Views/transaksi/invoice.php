<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>
<div class="invoice p-3 mb-3">
    <!-- Header Invoice -->
    <div class="row">
        <div class="col-12">
            <h4>
                <i class="fas fa-globe"></i> Invoice Peminjaman
                <small class="float-right">Tanggal: <?= date('d-m-Y', strtotime($transaksi['Tanggal_Pinjam'])); ?></small>
            </h4>
        </div>
    </div>

    <!-- Informasi Anggota dan Transaksi -->
    <div class="row invoice-info">
        <div class="col invoice-col">
            <b>Transaksi ID:</b> <?= $transaksi['ID_Transaksi']; ?><br>
            <b>ID Anggota:</b> <?= $transaksi['anggota_ID_Anggota']; ?><br>
            <b>Status:</b> <?= ucfirst($transaksi['Status']); ?><br>
            <b>Tanggal Pinjam:</b> <?= date('d-m-Y', strtotime($transaksi['Tanggal_Pinjam'])); ?><br>
            <b>Tanggal Kembali (Batas):</b> <?= date('d-m-Y', strtotime($transaksi['Tanggal_Kembali_Rencana'])); ?><br>
        </div>
    </div>

    <!-- Daftar Buku -->
    <div class="row mt-4">
        <div class="col-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Kode Buku</th>
                        <th>Judul</th>
                        <th>ISBN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dataTransaksi as $item): ?>
                        <tr>
                            <td><?= $item['Kode_Buku']; ?></td>
                            <td><?= $item['Judul']; ?></td>
                            <td><?= $item['ISBN']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer Invoice -->
    <div class="row no-print">
        <div class="col-12">
            <button id="printInvoice" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
            <button type="button" id="generatePdf" class="btn btn-primary float-right buttons-pdf" style="margin-right: 5px;">
                <i class="fas fa-download"></i> Generate PDF
            </button>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#printInvoice').click(function() {
            window.print();
        });
    });

    document.getElementById('generatePdf').addEventListener('click', function() {
        const header = [{
                text: 'Kode Buku',
                style: 'tableHeader'
            },
            {
                text: 'Judul',
                style: 'tableHeader'
            },
            {
                text: 'ISBN',
                style: 'tableHeader'
            }
        ];

        const bukuData = [];
        const rows = document.querySelectorAll('.table tbody tr');
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const rowData = Array.from(cells).map(cell => cell.textContent);
            bukuData.push(rowData);
        });

        const docDefinition = {
            content: [{
                    text: 'Invoice Peminjaman',
                    style: 'header',
                    alignment: 'center',
                    margin: [0, 0, 0, 20]
                },
                {
                    text: `Transaksi ID: <?= $transaksi['ID_Transaksi']; ?>\nID Anggota: <?= $transaksi['anggota_ID_Anggota']; ?>`,
                    margin: [0, 0, 0, 20]
                },
                {
                    text: `Tanggal Pinjam: <?= date('d-m-Y', strtotime($transaksi['Tanggal_Pinjam'])); ?>\nTanggal Kembali (Rencana): <?= date('d-m-Y', strtotime($transaksi['Tanggal_Kembali_Rencana'])); ?>`,
                    margin: [0, 0, 0, 20]
                },
                {
                    text: 'Daftar Buku',
                    style: 'subheader',
                    margin: [0, 0, 0, 10]
                },
                {
                    table: {
                        headerRows: 1,
                        widths: ['auto', '*', 'auto'],
                        body: [
                            header,
                            ...bukuData
                        ]
                    },
                    layout: 'lightHorizontalLines'
                }
            ],
            styles: {
                header: {
                    fontSize: 18,
                    bold: true
                },
                subheader: {
                    fontSize: 14,
                    bold: true
                },
                tableHeader: {
                    bold: true,
                    fontSize: 12,
                    color: 'black'
                }
            },
            defaultStyle: {
                fontSize: 10
            }
        };

        pdfMake.createPdf(docDefinition).download('Invoice_<?= $transaksi["ID_Transaksi"]; ?>.pdf');
    });
</script>

<?= $this->endSection() ?>