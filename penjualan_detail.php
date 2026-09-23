               <?php 
                   $id = $_GET['id'];
                   $query = mysqli_query($koneksi, "SELECT*FROM penjualan LEFT JOIN pelanggan on pelanggan.id_pelanggan = penjualan.id_pelanggan");
                   $data = mysqli_fetch_array($query);
               ?>
               <?php
               if(isset($_POST['id_pelanggan'])) {

                $id_pelanggan = $_POST['id_pelanggan'];
                $produk = $_POST['produk'];
                $total = 0;
                $tanggal = date('y/m/d');

                $query = mysqli_query($koneksi, "INSERT INTO penjualan(tanggal_penjualan,id_pelanggan) values ('$tanggal','$id_pelanggan')");

                $idTerakhir = mysqli_fetch_array(mysqli_query($koneksi, "SELECT*FROM penjualan ORDER BY id_penjualan DESC"));
                $id_penjualan = $idTerakhir['id_penjualan'];


                foreach($produk as $key=>$val) {
                    $pr = mysqli_fetch_array(mysqli_query($koneksi, "SELECT*FROM produk WHERE id_produk=$key"));
                   
                    if($val > 0) {
                    $sub = $val * $pr['harga'];
                    $total +=$sub;
                 $query = mysqli_query($koneksi, "INSERT INTO detail_penjualan(id_penjualan,id_produk,jumlah_produk,subtotal) values ('$id_penjualan','$key','$val', '$sub')");


                 $updateProduk = mysqli_query($koneksi, "UPDATE produk set stok=stok-$val WHERE id_produk=$key");
                    }
            }



               $query = mysqli_query($koneksi, "UPDATE penjualan SET total_harga=$total WHERE id_penjualan=$id_penjualan");


                if ($query) {
                    echo '<script>alert("Tambah Data Berhasil"); location.href="?page=pembelian"</script>';

                }else{

                 echo '<script>alert("Tambah Data Gagal")</script>';
                
                }
               }
               ?>
               
               
               
               <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Detail Pembelian</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Detail Pembelian</li>
                        </ol>
                        <a href="?page=pembelian" class="btn btn-danger">Kembali</a>
                        <hr>


                     <form method="post">
                        <table class="table table-bordered">
                            <tr>
                                <td width="200">Nama Pelanggan</td>
                                <td width="1">:</td>
                                <td>
                                     <?php echo $data['nama_pelanggan']; ?>
                                
                                </td>
                            </tr>
                            <?php 
                                        $pro = mysqli_query($koneksi, "SELECT*FROM detail_penjualan LEFT JOIN produk on produk.id_produk = detail_penjualan.id_produk WHERE id_penjualan=$id");
                                        while($produk = mysqli_fetch_array($pro)){

                            ?>
                            <tr>
                                <td><?php echo $produk['nama_produk']; ?></td>
                                <td>:</td>
                                <td>
                                    Harga:<?php echo $produk['harga']; ?><br>
                                    Jumlah :<?php echo $produk['jumlah_produk']; ?><br>
                                    Sub Total :<?php echo $produk['subtotal']; ?><br>
                                </td>
                            </tr>
                            <?php 
                            } 
                            
                            ?>
                                <tr>
                                <td>Total</td>
                                <td>:</td>
                                <td><?php echo $data['total_harga']; ?></td>
                            </tr>
                        </table>
                     </form>   
                    </div>

