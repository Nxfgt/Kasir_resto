<?php
include "koneksi.php";

if (!isset($_SESSION['user'])) {
    header('location:login.php');
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Nomor transaksi tidak valid.");
}

$id = (int) $_GET['id'];

// Mengambil data transaksi dan pelanggan
$query = mysqli_query($koneksi, "
    SELECT penjualan.*, pelanggan.nama_pelanggan,
           pelanggan.alamat, pelanggan.no_telepon
    FROM penjualan
    LEFT JOIN pelanggan
        ON pelanggan.id_pelanggan = penjualan.id_pelanggan
    WHERE penjualan.id_penjualan = $id
");

$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data transaksi tidak ditemukan.");
}

// Mengambil daftar produk yang dibeli
$detail = mysqli_query($koneksi, "
    SELECT detail_penjualan.*, produk.nama_produk, produk.harga
    FROM detail_penjualan
    LEFT JOIN produk
        ON produk.id_produk = detail_penjualan.id_produk
    WHERE detail_penjualan.id_penjualan = $id
");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Struk Pembelian</title>

    <style>
    body {
        font-family: Arial, sans-serif;
        background: #9eaab6;
        margin: 0;
        padding: 20px;
    }

    .struk {
        width: 320px;
        max-width: 100%;
        margin: 20px auto;
        padding: 20px;
        background: white;
        color: #111;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
    }

    .judul {
        text-align: center;
        border-bottom: 1px dashed #333;
        padding-bottom: 12px;
        margin-bottom: 12px;
    }

    .judul h2 {
        margin: 0 0 5px;
        font-size: 20px;
    }

    .judul p {
        margin: 4px 0;
        font-size: 12px;
    }

    .info {
        font-size: 12px;
        margin-bottom: 12px;
        line-height: 1.7;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    th {
        border-top: 1px dashed #333;
        border-bottom: 1px dashed #333;
        padding: 7px 2px;
        text-align: left;
    }

    td {
        padding: 7px 2px;
        vertical-align: top;
    }

    .angka {
        text-align: right;
        white-space: nowrap;
    }

    .total {
        border-top: 1px dashed #333;
        margin-top: 8px;
        padding-top: 10px;
        font-size: 14px;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
    }

    .terima-kasih {
        text-align: center;
        border-top: 1px dashed #333;
        margin-top: 15px;
        padding-top: 12px;
        font-size: 12px;
    }

    .tombol {
        text-align: center;
        margin: 20px auto;
    }

    .tombol button,
    .tombol a {
        display: inline-block;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        color: white;
        cursor: pointer;
        font-size: 14px;
    }

    .cetak {
        background: #2563eb;
    }

    .kembali {
        background: #64748b;
    }

    @media print {
        body {
            background: white;
            padding: 0;
        }

        .struk {
            width: 100%;
            max-width: none;
            margin: 0;
            padding: 0;
            box-shadow: none;
        }

        .tombol {
            display: none;
        }

        @page {
            margin: 5mm;
            size: 80mm auto;
        }
    }
    </style>
</head>

<body>

    <div class="struk">

        <div class="judul">
            <h2>KASIR RESTORAN</h2>
            <p>Struk Pembelian</p>
            <p>Terima kasih telah berbelanja</p>
        </div>

        <div class="info">
            <div>
                No. Transaksi:
                <?php echo htmlspecialchars($data['id_penjualan']); ?>
            </div>

            <div>
                Tanggal:
                <?php echo htmlspecialchars($data['tanggal_penjualan']); ?>
            </div>

            <div>
                Pelanggan:
                <?php echo htmlspecialchars($data['nama_pelanggan'] ?? '-'); ?>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th class="angka">Jumlah</th>
                    <th class="angka">Subtotal</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($produk = mysqli_fetch_assoc($detail)) { ?>
                <tr>
                    <td>
                        <?php echo htmlspecialchars($produk['nama_produk'] ?? '-'); ?>
                        <br>
                        <small>
                            Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?>
                        </small>
                    </td>

                    <td class="angka">
                        <?php echo (int) $produk['jumlah_produk']; ?>
                    </td>

                    <td class="angka">
                        <?php echo number_format($produk['subtotal'], 0, ',', '.'); ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="total">
            <span>TOTAL</span>
            <span>
                Rp <?php echo number_format($data['total_harga'], 0, ',', '.'); ?>
            </span>
        </div>

        <div class="terima-kasih">
            <p>Terima kasih atas kunjungan Anda.</p>
            <p>Semoga hari Anda menyenangkan!</p>
        </div>

    </div>

    <div class="tombol">
        <button class="cetak" onclick="window.print()">
            <i class="fa-solid fa-print"></i> Cetak Struk
        </button>

        <a class="kembali" href="index.php?page=pembelian">
            Kembali
        </a>
    </div>

</body>

</html>