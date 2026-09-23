<?php

    if($page == 'user' && $_SESSION['level'] != 'admin') {

        echo "<script>
                alert('Akses hanya untuk admin!');
                window.location='index.php';
              </script>";

        exit;
    }

?>

<main>

    <div class="container-fluid px-4">

        <h1 class="mt-4">Data User</h1>

        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">User</li>
        </ol>


        <hr>

        <table class="table table-bordered table-hover">

            <tr class="table-dark">

                <th width="5%">No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Level</th>
                <th width="20%">Aksi</th>

            </tr>

            <?php

            $no = 1;

            $query = mysqli_query(
                $koneksi,
                "SELECT * FROM `user`"
            );

            while($data = mysqli_fetch_array($query)){

            ?>

            <tr>

                <td>
                    <?php echo $no++; ?>
                </td>

                <td>
                    <?php echo $data['nama']; ?>
                </td>

                <td>
                    <?php echo $data['username']; ?>
                </td>

                <td>

                    <?php if($data['level'] == 'admin') { ?>

                        <span class="badge bg-danger">
                            Admin
                        </span>

                    <?php } else { ?>

                        <span class="badge bg-primary">
                            <?php echo $data['level']; ?>
                        </span>

                    <?php } ?>

                </td>

                <td>

                    <a href="?page=user_ubah&id=<?php echo $data['id_user']; ?>"
                       class="btn btn-secondary btn-sm">

                        <i class="fas fa-edit"></i>
                        Ubah

                    </a>

                    <a href="?page=user_hapus&id=<?php echo $data['id_user']; ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Yakin ingin menghapus user ini?')">

                        <i class="fas fa-trash"></i>
                        Hapus

                    </a>

                </td>

            </tr>

            <?php

            }

            ?>

        </table>

    </div>

</main>