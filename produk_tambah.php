<?php
if (isset($_POST['nama_produk'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $harga = (int) $_POST['harga'];
    $stok = (int) $_POST['stok'];
    $nama_gambar = '';

    // Proses upload gambar
    if (
        isset($_FILES['gambar']) &&
        $_FILES['gambar']['error'] !== UPLOAD_ERR_NO_FILE
    ) {
        if ($_FILES['gambar']['error'] !== UPLOAD_ERR_OK) {
            echo '<script>alert("Upload gambar gagal");</script>';
        } else {
            $folder = 'uploads/';

            if (!is_dir($folder)) {
                mkdir($folder, 0755, true);
            }

            $tmp = $_FILES['gambar']['tmp_name'];
            $ukuran = $_FILES['gambar']['size'];

            // Validasi tipe gambar berdasarkan isi file
            $info = @getimagesize($tmp);
            $tipe = $info['mime'] ?? '';

            $ekstensiValid = [
                'image/jpeg' => 'jpg',
                'image/png'  => 'png',
                'image/webp' => 'webp'
            ];

            if (!isset($ekstensiValid[$tipe])) {
                echo '<script>alert("Format gambar harus JPG, PNG, atau WEBP");</script>';
            } elseif ($ukuran > 2 * 1024 * 1024) {
                echo '<script>alert("Ukuran gambar maksimal 2 MB");</script>';
            } else {
                $nama_gambar = uniqid('produk_', true) . '.' . $ekstensiValid[$tipe];
                $tujuan = $folder . $nama_gambar;

                if (move_uploaded_file($tmp, $tujuan)) {
                    $query = mysqli_query(
                        $koneksi,
                        "INSERT INTO produk (nama_produk, harga, stok, gambar)
                         VALUES ('$nama', $harga, $stok, '$nama_gambar')"
                    );

                    if ($query) {
                        echo '<script>alert("Tambah Data Berhasil"); location.href="?page=produk";</script>';
                        exit;
                    } else {
                        if (file_exists($tujuan)) {
                            unlink($tujuan);
                        }

                        echo '<script>alert("Tambah Data Gagal menyimpan ke database");</script>';
                    }
                } else {
                    echo '<script>alert("Gagal memindahkan file gambar");</script>';
                }
            }
        }
    } else {
        // Tetap bisa menyimpan produk tanpa gambar
        $query = mysqli_query(
            $koneksi,
            "INSERT INTO produk (nama_produk, harga, stok, gambar)
             VALUES ('$nama', $harga, $stok, '')"
        );

        if ($query) {
            echo '<script>alert("Tambah Data Berhasil"); location.href="?page=produk";</script>';
            exit;
        } else {
            echo '<script>alert("Tambah Data Gagal");</script>';
        }
    }
}
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

        <h1 class="mt-4">Tambah Produk</h1>

        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">
                <a href="?page=produk">Produk</a>
            </li>
            <li class="breadcrumb-item active">Tambah Data</li>
        </ol>

        <a href="?page=produk" class="btn btn-kembali">
            Kembali
        </a>

        <hr>

        <form method="post" enctype="multipart/form-data" class="form-produk">

            <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input
                    class="form-control"
                    type="text"
                    name="nama_produk"
                    placeholder="Masukkan nama produk"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Harga (Rp)</label>
                <input
                    class="form-control"
                    type="number"
                    name="harga"
                    min="0"
                    step="1"
                    placeholder="Contoh: 15000"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Stok</label>
                <input
                    class="form-control"
                    type="number"
                    name="stok"
                    min="0"
                    step="1"
                    placeholder="Masukkan jumlah stok"
                    required
                >
            </div>

            <div class="mb-4">
                <label class="form-label">Gambar Produk</label>

                <input
                    class="form-control"
                    type="file"
                    name="gambar"
                    id="gambar"
                    accept="image/jpeg,image/png,image/webp"
                >

                <div class="form-text">
                    Format JPG, PNG, atau WEBP. Maksimal 2 MB.
                </div>

                <img
                    id="preview"
                    class="preview-gambar"
                    alt="Preview gambar produk"
                >
            </div>

            <hr>

            <button type="submit" class="btn btn-simpan">
                Simpan Produk
            </button>

            <button type="reset" class="btn btn-danger btn-reset">
                Reset
            </button>

        </form>
    </div>
</main>

<script>
    const inputGambar = document.getElementById('gambar');
    const previewGambar = document.getElementById('preview');

    inputGambar.addEventListener('change', function () {
        const file = this.files[0];

        if (file) {
            const tipeValid = [
                'image/jpeg',
                'image/png',
                'image/webp'
            ];

            if (!tipeValid.includes(file.type) || file.size > 2 * 1024 * 1024) {
                alert('Pilih gambar JPG, PNG, atau WEBP maksimal 2 MB.');
                this.value = '';
                previewGambar.removeAttribute('src');
                previewGambar.style.display = 'none';
                return;
            }

            previewGambar.src = URL.createObjectURL(file);
            previewGambar.style.display = 'block';
        }
    });

    document.querySelector('.form-produk').addEventListener('reset', function () {
        previewGambar.removeAttribute('src');
        previewGambar.style.display = 'none';
    });
</script>