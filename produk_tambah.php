               <?php 
               if(isset($_POST['nama_produk'])) {
                $nama = $_POST['nama_produk'];
                $harga = $_POST['harga'];
                $stok = $_POST['stok'];

                $query = mysqli_query($koneksi, "INSERT INTO produk(nama_produk,harga,stok) values ('$nama','$harga','$stok')");
                if ($query) {
                    echo '<script>alert("Tambah Data Berhasil"); location.href="?page=produk"</script>';

                }else{

                 echo '<script>alert("Tambah Data Gagal")</script>';
                
                }
               }
               ?>
               
               
               
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
                                <td><input class="form-control" type="text" name="nama_produk"></td>
                            </tr>
                            <tr>
                                <td>Harga</td>
                                <td>:</td>
                                <td><input class="form-control" type="number" step="0" name="harga"></td>
                                <tr>
                            <tr>
                                <td>Stok</td>
                                <td>:</td>
                                <td><input class="form-control" type="number" step="0" name="stok"></td>
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

