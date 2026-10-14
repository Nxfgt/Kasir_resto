<style>
    /* ===== STYLE HALAMAN PRODUK ===== */

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

    main a.btn-primary {
        background: linear-gradient(135deg, #2563eb, #3b82f6);
        border: none;
        border-radius: 8px;
        padding: 10px 18px;
        font-size: 14px;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.18);
        transition: all 0.2s ease;
    }

    main a.btn-primary:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(37, 99, 235, 0.25);
    }

    main hr {
        border: 0;
        border-top: 1px solid #e2e8f0;
        margin: 22px 0;
        opacity: 1;
    }

    /* ===== TABEL PRODUK ===== */

    main table.table {
        width: 100%;
        margin-top: 18px;
        margin-bottom: 24px;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        border-collapse: separate;
        border-spacing: 0;
        overflow: hidden;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.05);
    }

    main table.table th {
        background: #f1f5f9;
        color: #334155;
        font-size: 13px;
        font-weight: 700;
        padding: 16px;
        border: none;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    main table.table td {
        padding: 14px 16px;
        color: #475569;
        font-size: 14px;
        vertical-align: middle;
        border: none;
        border-bottom: 1px solid #edf2f7;
        transition: background-color 0.2s ease;
    }

    main table.table tr:last-child td {
        border-bottom: none;
    }

    main table.table tr:hover td {
        background-color: #f8fafc;
    }

    main table.table td:first-child {
        color: #1e293b;
        font-weight: 600;
    }

    /* ===== GAMBAR PRODUK ===== */

    .gambar-produk {
        width: 80px;
        height: 70px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        display: block;
        margin: auto;
        transition: transform 0.2s ease;
    }

    .gambar-produk:hover {
        transform: scale(1.08);
    }

    .gambar-kosong {
        width: 80px;
        height: 70px;
        border-radius: 10px;
        background: #f1f5f9;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: auto;
        font-size: 11px;
        text-align: center;
        border: 1px dashed #cbd5e1;
    }

    /* ===== TOMBOL AKSI ===== */

    main table.table td:last-child {
        white-space: nowrap;
    }

    main table.table .btn {
        border: none;
        border-radius: 7px;
        padding: 8px 14px;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    main table.table .btn-secondary {
        background: #64748b;
        color: #fff;
    }

    main table.table .btn-secondary:hover {
        background: #475569;
        transform: translateY(-1px);
    }

    main table.table .btn-danger {
        background: #ef4444;
        color: #fff;
        margin-left: 3px;
    }

    main table.table .btn-danger:hover {
        background: #dc2626;
        transform: translateY(-1px);
    }

    /* ===== RESPONSIVE ===== */

    @media (max-width: 768px) {
        main .container-fluid {
            padding: 20px 14px !important;
        }

        main h1 {
            font-size: 25px;
        }

        main table.table {
            min-width: 700px;
        }

        main table.table th,
        main table.table td {
            padding: 12px;
        }

        main {
            overflow-x: auto;
        }
    }
</style>

<main>
    <div class="container-fluid px-4">

        <h1 class="mt-4">Produk</h1>

        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Produk</li>
        </ol>

        <a href="?page=produk_tambah" class="btn btn-primary">
            + Tambah Data
        </a>

        <hr>

        <table class="table table-bordered">

            <thead>
                <tr>
                    <th style="width: 110px; text-align: center;">Gambar</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $query = mysqli_query($koneksi, "SELECT * FROM produk");

                while ($data = mysqli_fetch_array($query)) {
                ?>

                    <tr>
                        <td style="text-align: center;">

                            <?php
                            $gambar = $data['gambar'] ?? '';

                            if (!empty($gambar) && file_exists('uploads/' . basename($gambar))) {
                            ?>
                                <img
                                    src="<?php echo 'uploads/' . rawurlencode(basename($gambar)); ?>"
                                    alt="<?php echo htmlspecialchars($data['nama_produk']); ?>"
                                    class="gambar-produk"
                                >
                            <?php
                            } else {
                            ?>
                                <div class="gambar-kosong">
                                    Tidak ada gambar
                                </div>
                            <?php
                            }
                            ?>

                        </td>

                        <td>
                            <?php echo htmlspecialchars($data['nama_produk']); ?>
                        </td>

                        <td>
                            Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?>
                        </td>

                        <td>
                            <?php echo $data['stok']; ?>
                        </td>

                        <td>
                            <a href="?page=produk_ubah&&id=<?php echo $data['id_produk']; ?>"
                               class="btn btn-secondary">
                                Ubah
                            </a>

                            <a href="?page=produk_hapus&&id=<?php echo $data['id_produk']; ?>"
                               class="btn btn-danger"
                               onclick="return confirm('Yakin ingin menghapus produk ini?')">
                                Hapus
                            </a>
                        </td>
                    </tr>

                <?php
                }
                ?>
            </tbody>

        </table>

    </div>
</main>