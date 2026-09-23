<?php

// Pastikan hanya admin yang bisa mengakses
if ($_SESSION['level'] != 'admin') {

    echo "<script>
            alert('Akses hanya untuk admin!');
            window.location='index.php';
          </script>";

    exit;
}


// Ambil ID user
$id = $_GET['id'];


// Ambil data user
$query = mysqli_query(
    $koneksi,
    "SELECT * FROM `user` WHERE id_user='$id'"
);

$data = mysqli_fetch_array($query);


// Jika data tidak ditemukan
if (!$data) {

    echo "<script>
            alert('Data user tidak ditemukan!');
            window.location='index.php?page=user';
          </script>";

    exit;
}


// Proses update
if (isset($_POST['submit'])) {

    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    $level    = $_POST['level'];

    // Jika password dikosongkan,
    // password lama tetap digunakan
    if (!empty($_POST['password'])) {

        $password = md5($_POST['password']);

        $update = mysqli_query(
            $koneksi,
            "UPDATE `user` SET
                nama='$nama',
                username='$username',
                password='$password',
                level='$level'
             WHERE id_user='$id'"
        );

    } else {

        $update = mysqli_query(
            $koneksi,
            "UPDATE `user` SET
                nama='$nama',
                username='$username',
                level='$level'
             WHERE id_user='$id'"
        );

    }


    if ($update) {

        echo "<script>
                alert('Data user berhasil diubah!');
                window.location='index.php?page=user';
              </script>";

    } else {

        echo "<script>
                alert('Data user gagal diubah!');
              </script>";

    }

}

?>


<main>

    <div class="container-fluid px-4">

        <h1 class="mt-4">
            Ubah Data User
        </h1>

        <ol class="breadcrumb mb-4">

            <li class="breadcrumb-item">
                <a href="index.php?page=user">
                    User
                </a>
            </li>

            <li class="breadcrumb-item active">
                Ubah Data
            </li>

        </ol>


        <div class="card mb-4">

            <div class="card-header">

                <i class="fas fa-user-edit me-1"></i>

                Form Ubah User

            </div>


            <div class="card-body">

                <form method="post">


                    <!-- NAMA -->

                    <div class="mb-3">

                        <label class="form-label">
                            Nama
                        </label>

                        <input
                            type="text"
                            name="nama"
                            class="form-control"
                            value="<?php echo $data['nama']; ?>"
                            required
                        >

                    </div>


                    <!-- USERNAME -->

                    <div class="mb-3">

                        <label class="form-label">
                            Username
                        </label>

                        <input
                            type="text"
                            name="username"
                            class="form-control"
                            value="<?php echo $data['username']; ?>"
                            required
                        >

                    </div>


                    <!-- PASSWORD -->

                    <div class="mb-3">

                        <label class="form-label">
                            Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Kosongkan jika tidak ingin mengubah password"
                        >

                        <div class="form-text">
                            Isi password hanya jika ingin mengganti password.
                        </div>

                    </div>


                    <!-- LEVEL -->

                    <div class="mb-3">

                        <label class="form-label">
                            Level
                        </label>

                        <select
                            name="level"
                            class="form-select"
                            required
                        >

                            <option value="admin"
                                <?php
                                if ($data['level'] == 'admin') {
                                    echo 'selected';
                                }
                                ?>>
                                Admin
                            </option>

                            <option value="petugas"
                                <?php
                                if ($data['level'] == 'petugas') {
                                    echo 'selected';
                                }
                                ?>>
                                Petugas
                            </option>

                        </select>

                    </div>


                    <!-- TOMBOL -->

                    <button
                        type="submit"
                        name="submit"
                        class="btn btn-primary"
                    >

                        <i class="fas fa-save me-1"></i>

                        Simpan Perubahan

                    </button>


                    <a
                        href="?page=user"
                        class="btn btn-secondary"
                    >

                        <i class="fas fa-arrow-left me-1"></i>

                        Kembali

                    </a>


                </form>

            </div>

        </div>

    </div>

</main>