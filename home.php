<main>

    <div class="container-fluid px-4">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mt-4 mb-4">

            <div>

                <h1 class="fw-bold text-dark mb-1">
                    Java Resto
                </h1>

                <div class="text-muted">
                    <i class="fas fa-utensils me-1"></i>
                    Dashboard Kasir
                </div>

            </div>

            <div class="text-end">


            </div>

        </div>


        <!-- BANNER -->
        <div class="card bg-dark text-white border-0 shadow-sm mb-4">

            <div class="card-body p-4 p-md-5">

                <div class="row align-items-center">

                    <!-- TEKS -->
                    <div class="col-lg-8">

                        <span class="badge bg-warning text-dark mb-3">
                            <i class="fas fa-star me-1"></i>
                            JAVA RESTO
                        </span>

                        <h2 class="fw-bold mb-3">
                            Selamat Datang di Java Resto
                        </h2>

                        <p class="text-white-50 mb-4">
                            Nikmati kemudahan dalam mengelola pelanggan,
                            produk, dan transaksi penjualan.
                        </p>

                        <a href="?page=pembelian"
                            class="btn btn-warning">

                            <i class="fas fa-shopping-cart me-2"></i>

                            Mulai Transaksi

                        </a>

                    </div>


                    <!-- ICON -->
                    <div class="col-lg-4 text-center mt-4 mt-lg-0">

                        <i class="fas fa-utensils fa-6x text-warning"></i>

                        <h4 class="fw-bold mt-3">
                            JAVA RESTO
                        </h4>

                        <small class="text-white-50">
                            Sistem Kasir Restoran
                        </small>

                    </div>

                </div>

            </div>

        </div>


        <!-- STATISTIK -->
        <div class="row g-4">


            <!-- TOTAL PELANGGAN -->
            <div class="col-xl-3 col-md-6">

                <div class="card bg-primary text-white border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="small text-uppercase">
                                    Total Pelanggan
                                </div>

                                <div class="fs-1 fw-bold">

                                    <?php

                                    echo mysqli_num_rows(
                                        mysqli_query(
                                            $koneksi,
                                            "SELECT * FROM pelanggan"
                                        )
                                    );

                                    ?>

                                </div>

                            </div>

                            <i class="fas fa-users fa-3x opacity-50"></i>

                        </div>

                    </div>

                    <div class="card-footer bg-transparent border-top border-light">

                        <a href="?page=pelanggan"
                            class="text-white text-decoration-none">

                            Lihat Pelanggan

                            <i class="fas fa-arrow-right ms-2"></i>

                        </a>

                    </div>

                </div>

            </div>


            <!-- TOTAL PRODUK -->
            <div class="col-xl-3 col-md-6">

                <div class="card bg-warning text-white border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="small text-uppercase">
                                    Total Produk
                                </div>

                                <div class="fs-1 fw-bold">

                                    <?php

                                    echo mysqli_num_rows(
                                        mysqli_query(
                                            $koneksi,
                                            "SELECT * FROM produk"
                                        )
                                    );

                                    ?>

                                </div>

                            </div>

                            <i class="fas fa-utensils fa-3x opacity-50"></i>

                        </div>

                    </div>

                    <div class="card-footer bg-transparent border-top border-light">

                        <a href="?page=produk"
                            class="text-white text-decoration-none">

                            Lihat Produk

                            <i class="fas fa-arrow-right ms-2"></i>

                        </a>

                    </div>

                </div>

            </div>


            <!-- TOTAL PENJUALAN -->
            <div class="col-xl-3 col-md-6">

                <div class="card bg-success text-white border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="small text-uppercase">
                                    Total Penjualan
                                </div>

                                <div class="fs-1 fw-bold">

                                    <?php

                                    echo mysqli_num_rows(
                                        mysqli_query(
                                            $koneksi,
                                            "SELECT * FROM penjualan"
                                        )
                                    );

                                    ?>

                                </div>

                            </div>

                            <i class="fas fa-cash-register fa-3x opacity-50"></i>

                        </div>

                    </div>

                    <div class="card-footer bg-transparent border-top border-light">

                        <a href="?page=pembelian"
                            class="text-white text-decoration-none">

                            Lihat Penjualan

                            <i class="fas fa-arrow-right ms-2"></i>

                        </a>

                    </div>

                </div>

            </div>


            <!-- TOTAL USER - ADMIN SAJA -->
            <?php if (isset($_SESSION['level']) && $_SESSION['level'] == 'admin') { ?>

                <div class="col-xl-3 col-md-6">

                    <div class="card bg-danger text-white border-0 shadow-sm h-100">

                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>

                                    <div class="small text-uppercase">
                                        Total User
                                    </div>

                                    <div class="fs-1 fw-bold">

                                        <?php

                                        echo mysqli_num_rows(
                                            mysqli_query(
                                                $koneksi,
                                                "SELECT * FROM `user`"
                                            )
                                        );

                                        ?>

                                    </div>

                                </div>

                                <i class="fas fa-user fa-3x opacity-50"></i>

                            </div>

                        </div>

                        <div class="card-footer bg-transparent border-top border-light">

                            <a href="?page=user"
                                class="text-white text-decoration-none">

                                Lihat User

                                <i class="fas fa-arrow-right ms-2"></i>

                            </a>

                        </div>

                    </div>

                </div>

            <?php } ?>


        </div>


        <!-- BANNER BAWAH -->
        <div class="card border-0 shadow-sm mt-5 mb-4">

            <div class="card-body">

                <div class="row align-items-center">

                    <div class="col-md-8">

                        <h4 class="fw-bold mb-2">
                            <i class="fas fa-concierge-bell text-warning me-2"></i>
                            Siap Melayani Pelanggan?
                        </h4>

                        <p class="text-muted mb-3">
                            Mulai transaksi baru dan kelola pesanan
                            pelanggan dengan mudah.
                        </p>

                    </div>

                    <div class="col-md-4 text-center mt-3 mt-md-0">

                        <i class="fas fa-mug-hot fa-4x text-warning"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

</main>