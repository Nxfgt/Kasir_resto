<?php
// Mengambil data riwayat transaksi
$query = mysqli_query($koneksi, "
    SELECT
        penjualan.id_penjualan,
        penjualan.tanggal_penjualan,
        penjualan.total_harga,
        pelanggan.nama_pelanggan
    FROM penjualan
    LEFT JOIN pelanggan
        ON pelanggan.id_pelanggan = penjualan.id_pelanggan
    ORDER BY penjualan.id_penjualan DESC
");
?>

<style>
    .riwayat-container {
        padding: 25px;
        color: #1e293b;
    }

    .riwayat-container h1 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .riwayat-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 22px;
        margin-top: 20px;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.06);
    }

    .riwayat-card .table th {
        background: #f1f5f9;
        color: #334155;
        white-space: nowrap;
    }

    .riwayat-card .table th,
    .riwayat-card .table td {
        padding: 13px;
        vertical-align: middle;
    }

    .riwayat-card .table tbody tr:hover {
        background: #f8fafc;
    }

    .total-transaksi {
        font-weight: 700;
        color: #15803d;
        white-space: nowrap;
    }

    .badge-transaksi {
        display: inline-block;
        padding: 6px 10px;
        background: #dbeafe;
        color: #1d4ed8;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .riwayat-container {
            padding: 15px;
        }

        .riwayat-card {
            padding: 12px;
        }
    }
</style>

<div class="container-fluid riwayat-container">

    <h1>
        <i class="fa-solid fa-clock-rotate-left me-2"></i>
        Riwayat Transaksi
    </h1>

    <p class="text-muted">
        Daftar seluruh transaksi yang telah dilakukan.
    </p>

    <div class="riwayat-card">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Daftar Transaksi</h5>

            <span class="badge-transaksi">
                <?php echo mysqli_num_rows($query); ?> Transaksi
            </span>
        </div>

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>No. Transaksi</th>
                        <th>Tanggal</th>
                        <th>Nama Pelanggan</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    $nomor = 1;

                    if (mysqli_num_rows($query) > 0) {
                        while ($data = mysqli_fetch_assoc($query)) {
                    ?>

                        <tr>
                            <td><?php echo $nomor++; ?></td>

                            <td>
                                <span class="badge-transaksi">
                                    #<?php echo (int) $data['id_penjualan']; ?>
                                </span>
                            </td>

                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $data['tanggal_penjualan'] ?? '-'
                                );
                                ?>
                            </td>

                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $data['nama_pelanggan'] ?? '-'
                                );
                                ?>
                            </td>

                            <td class="total-transaksi">
                                Rp <?php
                                echo number_format(
                                    $data['total_harga'] ?? 0,
                                    0,
                                    ',',
                                    '.'
                                );
                                ?>
                            </td>

                            <td>
                                <a
                                    href="?page=pembelian_detail&id=<?php echo (int) $data['id_penjualan']; ?>"
                                    class="btn btn-sm btn-primary mb-1">
                                    <i class="fa-solid fa-eye"></i>
                                    Detail
                                </a>

                                <a
                                    href="struk.php?id=<?php echo (int) $data['id_penjualan']; ?>"
                                    target="_blank"
                                    class="btn btn-sm btn-success mb-1">
                                    <i class="fa-solid fa-print"></i>
                                    Cetak
                                </a>
                            </td>
                        </tr>

                    <?php
                        }
                    } else {
                    ?>

                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fa-solid fa-receipt fa-2x mb-2 text-muted"></i>
                                <p class="mb-0">
                                    Belum ada riwayat transaksi.
                                </p>
                            </td>
                        </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>
    </div>
</div>