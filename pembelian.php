      <style>
/* ===== STYLE HALAMAN PELANGGAN ===== */

main .container-fluid {
    padding: 28px 24px !important;
    color: #1e293b;
}

/* Judul */
main h1 {
    font-size: 30px;
    font-weight: 700;
    letter-spacing: -0.8px;
    color: #0f172a;
    margin-bottom: 8px !important;
}

/* Breadcrumb */
main .breadcrumb {
    background: transparent;
    padding: 0;
    margin-bottom: 24px !important;
    font-size: 14px;
}

main .breadcrumb-item.active {
    color: #64748b;
}

/* Tombol Tambah Data */
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

/* Garis pemisah */
main hr {
    border: 0;
    border-top: 1px solid #e2e8f0;
    margin: 22px 0;
    opacity: 1;
}

/* Tabel */
main table.table {
    width: 100%;
    margin-top: 18px;
    margin-bottom: 24px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    border-collapse: separate;
    border-spacing: 0;
    overflow: hidden;
    box-shadow: 0 4px 18px rgba(15, 23, 42, 0.05);
}

/* Header tabel */
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

/* Isi tabel */
main table.table td {
    padding: 14px 16px;
    color: #475569;
    font-size: 14px;
    vertical-align: middle;
    border: none;
    border-bottom: 1px solid #edf2f7;
    transition: background-color 0.2s ease;
}

/* Baris terakhir */
main table.table tr:last-child td {
    border-bottom: none;
}

/* Efek hover */
main table.table tr:hover td {
    background-color: #f8fafc;
}

/* Nama pelanggan */
main table.table td:first-child {
    color: #1e293b;
    font-weight: 600;
}

/* Nomor telepon */
main table.table td:nth-child(3) {
    font-variant-numeric: tabular-nums;
}

/* Kolom aksi */
main table.table td:last-child {
    white-space: nowrap;
}

/* Tombol aksi */
main table.table .btn {
    border: none;
    border-radius: 7px;
    padding: 8px 14px;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.2s ease;
}

/* Tombol Ubah */
main table.table .btn-secondary {
    background: #64748b;
    color: #ffffff;
}

main table.table .btn-secondary:hover {
    background: #475569;
    transform: translateY(-1px);
}

/* Tombol Hapus */
main table.table .btn-danger {
    background: #ef4444;
    color: #ffffff;
    margin-left: 3px;
}

main table.table .btn-danger:hover {
    background: #dc2626;
    transform: translateY(-1px);
}

/* Tampilan HP / layar kecil */
@media (max-width: 768px) {
    main .container-fluid {
        padding: 20px 14px !important;
    }

    main h1 {
        font-size: 25px;
    }

    main table.table {
        min-width: 650px;
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
              <h1 class="mt-4">Pembelian</h1>
              <ol class="breadcrumb mb-4">
                  <li class="breadcrumb-item active">Pembelian</li>
              </ol>
              <a href="?page=pembelian_tambah" class="btn btn-primary">+ Tambah Data</a>
              <hr>

              <table class="table table-bordered">
                  <tr>
                      <th>Tanggal Pembelian</th>
                      <th>Pelanggan</th>
                      <th>Total Harga</th>
                      <th>Aksi</th>
                  </tr>

                  <?php 
                            $query = mysqli_query($koneksi, "SELECT*FROM penjualan LEFT JOIN pelanggan on pelanggan.id_pelanggan = penjualan.id_pelanggan");
                            while($data = mysqli_fetch_array($query)){
                            ?>
                  <tr>
                      <td> <?php echo $data['tanggal_penjualan']; ?></td>
                      <td> <?php echo $data['nama_pelanggan']; ?></td>
                      <td><?php echo number_format($data['total_harga'], 0, ',', '.'); ?></td>
                      <td>
                          <a href="?page=penjualan_detail&&id=<?php echo $data['id_penjualan']?>"
                              class="btn btn-secondary">Detail</a>
                          <a href="?page=penjualan_hapus&&id=<?php echo $data['id_penjualan']?>"
                              class="btn btn-danger">Hapus</a>
                          <a href="struk.php?id=<?php echo $data['id_penjualan']; ?>" target="_blank"
                              class="btn btn-success">
                              <i class="fa-solid fa-print"></i> Cetak Struk
                          </a>
                      </td>
                  </tr>
                  <?php
                            }

                            
                            ?>
              </table>