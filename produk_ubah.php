               <?php 
               $id = $_GET['id'];
               if(isset($_POST['nama_produk'])) {
                $nama = $_POST['nama_produk'];
                $harga = $_POST['harga'];
                $stok = $_POST['stok'];

                $query = mysqli_query($koneksi, "UPDATE produk set nama_produk='$nama',harga='$harga',stok='$stok' WHERE id_produk=$id");
                if ($query) {
                    echo '<script>alert("Ubah Data Berhasil"); location.href="?page=produk"</script>';

                }else{

                 echo '<script>alert("Ubah Data Gagal")</script>';
                
                }
               }

               $query = mysqli_query($koneksi, "SELECT*FROM produk WHERE id_produk=$id");
               $data = mysqli_fetch_array($query);
               ?>
               
               <style>
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

    .form-produk {
        max-width: 850px;
        background: #fff;
        padding: 28px;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.05);
    }

    .form-produk .form-label {
        color: #334155;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .form-produk .form-control {
        padding: 11px 13px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 14px;
        box-shadow: none;
    }

    .form-produk .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
    }

    .form-produk .form-text {
        font-size: 12px;
        color: #64748b;
        margin-top: 7px;
    }

    .preview-gambar {
        display: none;
        width: 150px;
        height: 120px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        margin-top: 12px;
    }

    .btn-simpan {
        background: linear-gradient(135deg, #2563eb, #3b82f6);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 22px;
        font-weight: 600;
    }

    .btn-simpan:hover {
        background: #1d4ed8;
        color: #fff;
    }

    .btn-kembali {
        background: #64748b;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 18px;
        font-weight: 600;
    }

    .btn-kembali:hover {
        background: #475569;
        color: #fff;
    }

    .btn-reset {
        border-radius: 8px;
        padding: 10px 18px;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        main .container-fluid {
            padding: 20px 14px !important;
        }

        main h1 {
            font-size: 25px;
        }

        .form-produk {
            padding: 18px;
        }
    }
</style>

               
               <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Produk</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Produk</li>
                        </ol>
                        <a href="?page=produk" class="btn btn-danger">Kembali</a>
                        <hr>


                     <form method="post">
                        <table class="table table-bordered">
                            <tr>
                                <td width="200">Nama Produk</td>
                                <td width="1">:</td>
                                <td><input class="form-control" value="<?php echo $data['nama_produk']; ?>" type="text" name="nama_produk"></td>
                            </tr>
                            <tr>
                                <td>Harga</td>
                                <td>:</td>
                                <td><input class="form-control"value="<?php echo $data['harga']; ?>" type="number" step="0" name="harga"></td>
                                <tr>
                            <tr>
                                <td>Stok</td>
                                <td>:</td>
                                <td><input class="form-control" value="<?php echo $data['stok']; ?>" type="number" step="0" name="stok"></td>
                                <tr>
                                <td>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="reset" class="btn btn-danger">Hapus</button>
                                </td>
                                </tr>
                            </tr>
                        </table>
                     </form>   
                    </div>

