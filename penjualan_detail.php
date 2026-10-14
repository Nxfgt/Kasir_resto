<?php
// ===============================
// AMBIL DATA PENJUALAN
// ===============================

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$query = mysqli_query($koneksi, "
    SELECT
        penjualan.*,
        pelanggan.nama_pelanggan
    FROM penjualan
    LEFT JOIN pelanggan
        ON pelanggan.id_pelanggan = penjualan.id_pelanggan
    WHERE penjualan.id_penjualan = $id
");

$data = mysqli_fetch_assoc($query);
?>

<style>
    /* ===== HALAMAN DETAIL PEMBELIAN ===== */

    main .container-fluid {
        padding: 28px 24px !important;
        color: #1e293b;
    }

    main h1 {
        font-size: 30px;
        font-weight: 700;
        letter-spacing: -0.8px;
        color: #0f172a;
        margin-bottom: 8px !important;
    }

    main .breadcrumb {
        background: transparent;
        padding: 0;
        margin-bottom: 24px !important;
        font-size: 14px;
    }

    main .breadcrumb-item.active {
        color: #64748b;
    }

    main hr {
        border: 0;
        border-top: 1px solid #e2e8f0;
        margin: 22px 0;
        opacity: 1;
    }

    /* Kartu detail */
    .detail-card {
        background: #ffffff;
        padding: 24px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.05);
        margin-bottom: 24px;
    }

    /* Tabel */
    main table.table {
        width: 100%;
        margin-bottom: 0;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        border-collapse: separate;
        border-spacing: 0;
        overflow: hidden;
    }

    main table.table th {
        background: #f1f5f9;
        color: #334155;
        font-size: 13px;
        font-weight: 700;
        padding: 15px;
        border: none;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    main table.table td {
        padding: 14px 15px;
        color: #475569;
        font-size: 14px;
        vertical-align: middle;
        border: none;
        border-bottom: 1px solid #edf2f7;
    }

    main table.table tbody tr:last-child td {
        border-bottom: none;
    }

    main table.table tbody tr:hover td {
        background-color: #f8fafc;
    }

    .label-detail {
        color: #334155;
        font-weight: 600;
        width: 200px;
    }

    .nilai-detail {
        color: #1e293b;
        font-weight: 500;
    }

    .harga-detail {
        white-space: nowrap;
        text-align: right;
        font-weight: 600;
        color: #334155;
    }

    .total-row td {
        background: #eff6ff !important;
        color: #1d4ed8 !important;
        font-weight: 700 !important;
        font-size: 15px !important;
    }

    /* Tombol kembali */
    .btn-kembali {
        display: inline-block;
        background: #64748b;
        color: #ffffff;
        text-decoration: none;
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        transition: 0.2s ease;
    }

    .btn-kembali:hover {
        background: #475569;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .pesan-kosong {
        padding: 20px;
        border-radius: 8px;
        background: #fff7ed;
        color: #9a3412;
        border: 1px solid #fed7aa;
    }

    @media (max-width: 768px) {
        main .container-fluid {
            padding: 20px 14px !important;
        }

        main h1 {
            font-size: 25px;
        }

        .detail-card {
            padding: 14px;
            overflow-x: auto;
        }

        main table.table {
            min-width: 550px;
        }
    }
</style>

<main>
    <div class="container-fluid px-4">

        <h1 class="mt-4">Detail Pembelian</h1>

        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">
                <a href="?page=pembelian">Pembelian</a>
            </li>
            <li class="breadcrumb-item active">
                Detail Pembelian
            </li>
        </ol>

        <a href="?page=pembelian" class="btn-kembali">
            &larr; Kembali
        </a>

        <hr>

        <?php if ($data) { ?>

            <div class="detail-card">

                <table class="table table-bordered">
                    <tbody>

                        <tr>
                            <td class="label-detail">
                                Nama Pelanggan
                            </td>

                            <td style="width: 20px;">:</td>

                            <td class="nilai-detail" colspan="2">
                                <?php
                                echo htmlspecialchars(
                                    $data['nama_pelanggan'] ?? '-'
                                );
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td class="label-detail">
                                Tanggal Pembelian
                            </td>

                            <td>:</td>

                            <td colspan="2">
                                <?php
                                echo htmlspecialchars(
                                    $data['tanggal_penjualan'] ?? '-'
                                );
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <th>Nama Produk</th>
                            <th colspan="2">Rincian</th>
                            <th class="text-end">Subtotal</th>
                        </tr>

                        <?php
                        // ===============================
                        // AMBIL DETAIL PRODUK
                        // ===============================

                        $pro = mysqli_query($koneksi, "
                            SELECT
                                detail_penjualan.*,
                                produk.nama_produk,
                                produk.harga
                            FROM detail_penjualan
                            LEFT JOIN produk
                                ON produk.id_produk = detail_penjualan.id_produk
                            WHERE detail_penjualan.id_penjualan = $id
                        ");

                        $totalRincian = 0;
                        $adaProduk = false;

                        while ($produk = mysqli_fetch_assoc($pro)) {
                            $adaProduk = true;

                            $namaProduk = $produk['nama_produk']
                                ?? 'Produk tidak ditemukan';

                            $harga = (float) ($produk['harga'] ?? 0);

                            $jumlah = (int) (
                                $produk['jumlah_produk'] ?? 0
                            );

                            $subtotal = (float) (
                                $produk['subtotal'] ?? ($harga * $jumlah)
                            );

                            $totalRincian += $subtotal;
                        ?>

                            <tr>
                                <td>
                                    <?php
                                    echo htmlspecialchars($namaProduk);
                                    ?>
                                </td>

                                <td colspan="2">
                                    <div>
                                        Harga:
                                        Rp <?php
                                        echo number_format(
                                            $harga,
                                            0,
                                            ',',
                                            '.'
                                        );
                                        ?>
                                    </div>

                                    <div>
                                        Jumlah:
                                        <?php echo $jumlah; ?>
                                    </div>
                                </td>

                                <td class="harga-detail">
                                    Rp <?php
                                    echo number_format(
                                        $subtotal,
                                        0,
                                        ',',
                                        '.'
                                    );
                                    ?>
                                </td>
                            </tr>

                        <?php
                        }

                        if (!$adaProduk) {
                        ?>

                            <tr>
                                <td colspan="4" class="text-center">
                                    Belum ada detail produk untuk transaksi ini.
                                </td>
                            </tr>

                        <?php
                        }

                        // Gunakan total transaksi yang tersimpan.
                        // Jika NULL, gunakan hasil penjumlahan rincian.
                        $totalHarga = isset($data['total_harga'])
                            && $data['total_harga'] !== null
                            ? (float) $data['total_harga']
                            : $totalRincian;
                        ?>

                        <tr class="total-row">
                            <td colspan="3">
                                TOTAL PEMBELIAN
                            </td>

                            <td class="harga-detail">
                                Rp <?php
                                echo number_format(
                                    $totalHarga,
                                    0,
                                    ',',
                                    '.'
                                );
                                ?>
                            </td>
                        </tr>

                    </tbody>
                </table>

            </div>

        <?php } else { ?>

            <div class="pesan-kosong">
                Data pembelian tidak ditemukan. Periksa kembali ID transaksi
                atau pastikan transaksi tersebut tersedia di database.
            </div>

        <?php } ?>

    </div>
</main>