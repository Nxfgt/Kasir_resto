<?php

// Pastikan hanya admin yang bisa menghapus user
if ($_SESSION['level'] != 'admin') {

    echo "<script>
            alert('Akses hanya untuk admin!');
            window.location='index.php';
          </script>";

    exit;
}


// Ambil ID user
$id = $_GET['id'];


// Cek apakah user tersedia
$query = mysqli_query(
    $koneksi,
    "SELECT * FROM `user` WHERE id_user='$id'"
);

$data = mysqli_fetch_array($query);


if (!$data) {

    echo "<script>
            alert('Data user tidak ditemukan!');
            window.location='index.php?page=user';
          </script>";

    exit;
}


// Jangan izinkan admin menghapus akun sendiri
if ($id == $_SESSION['id_user']) {

    echo "<script>
            alert('Anda tidak dapat menghapus akun yang sedang digunakan!');
            window.location='index.php?page=user';
          </script>";

    exit;
}


// Hapus user
$hapus = mysqli_query(
    $koneksi,
    "DELETE FROM `user` WHERE id_user='$id'"
);


if ($hapus) {

    echo "<script>
            alert('Data user berhasil dihapus!');
            window.location='index.php?page=user';
          </script>";
} else {

    echo "<script>
            alert('Data user gagal dihapus!');
            window.location='index.php?page=user';
          </script>";
}
