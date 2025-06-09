<?php
session_start();
?>
<!doctype html>
<html class="no-js" lang="zxx">

<!-- shopping-cart31:32-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Keranjang - E-Zone</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
    <!-- Material Design Iconic Font-V2.2.0 -->
    <link rel="stylesheet" href="css/material-design-iconic-font.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Font Awesome Stars-->
    <link rel="stylesheet" href="css/fontawesome-stars.css">
    <!-- Meanmenu CSS -->
    <link rel="stylesheet" href="css/meanmenu.css">
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <!-- Slick Carousel CSS -->
    <link rel="stylesheet" href="css/slick.css">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="css/animate.css">
    <!-- Jquery-ui CSS -->
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <!-- Venobox CSS -->
    <link rel="stylesheet" href="css/venobox.css">
    <!-- Nice Select CSS -->
    <link rel="stylesheet" href="css/nice-select.css">
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="css/magnific-popup.css">
    <!-- Bootstrap V4.1.3 Fremwork CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Helper CSS -->
    <link rel="stylesheet" href="css/helper.css">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- Modernizr js -->
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <!--[if lt IE 8]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
    <!-- Begin Body Wrapper -->
    <div class="body-wrapper">
        <!-- Begin Header Area -->
        <header class="li-header-4">
            <!-- Begin Header Top Area -->

            <!-- Header Top Area End Here -->
            <!-- Begin Header Middle Area -->
            <div class="header-middle pl-sm-0 pr-sm-0 pl-xs-0 pr-xs-0">
                <div class="container">
                    <div class="row">
                        <!-- Begin Header Logo Area -->
                        <div class="col-lg-3">
                            <div class="logo pb-sm-30 pb-xs-30">
                                <a href="index.php">
                                    <h1>E-Zone</h1>
                                </a>
                            </div>
                        </div>
                        <!-- Header Logo Area End Here -->
                        <!-- Begin Header Middle Right Area -->
                        <div class="col-lg-9 pl-0 ml-sm-15 ml-xs-15">
                            <!-- Begin Header Middle Right Area -->
                            <div class="header-middle-right">
                                <ul class="hm-menu">
                                    <?php

                                    if (!isset($_SESSION['id_user'])) {
                                    ?>
                                        <!-- Jika belum login -->
                                        <li class="hm-wishlist">
                                            <a href="login.php" title="Login">
                                                <i class="fa fa-user"></i>
                                            </a>
                                        </li>
                                    <?php
                                    } else {
                                        // Ambil nama user dari session atau database jika mau
                                        $nama_user = $_SESSION['username']; // pastikan diset saat login

                                    ?>
                                        <!-- User Icon with Dropdown -->
                                        <li class="hm-wishlist dropdown">
                                            <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-user"></i>
                                            </a>
                                            <ul class="dropdown-menu" style="padding: 10px; min-width: 150px; text-align: center;">
                                                <li style="padding: 5px 10px; font-weight: bold;">
                                                    <?= htmlspecialchars($nama_user) ?>
                                                </li>
                                                <li>
                                                    <hr style="margin: 5px 0;">
                                                </li>
                                                <li>
                                                    <a href="logout.php" style="display: flex; align-items: center; justify-content: center; gap: 5px;">
                                                        <i class="fa fa-sign-out"></i> Logout
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>

                                        <!-- Mini Cart -->
                                        
                                    <?php } ?>
                                </ul>
                            </div>

                            <!-- Header Middle Right Area End Here -->
                        </div>
                        <!-- Header Middle Right Area End Here -->
                    </div>
                </div>
            </div>
            <!-- Header Middle Area End Here -->
            <!-- Begin Header Bottom Area -->
            <div class="header-bottom header-sticky stick d-none d-lg-block d-xl-block">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Begin Header Bottom Menu Area -->
                            <div class="hb-menu">
                                <nav>
                                    <ul>
                                        <li><a href="index.php">Beranda</a></li>
                                        <li><a href="belanja.php">Belanja</a></li>
                                        <li><a href="contact.php">Hubungi Kami</a></li>
                                    </ul>
                                </nav>
                            </div>
                            <!-- Header Bottom Menu Area End Here -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Header Bottom Area End Here -->
            <!-- Begin Mobile Menu Area -->
            <div class="mobile-menu-area mobile-menu-area-4 d-lg-none d-xl-none col-12">
                <div class="container">
                    <div class="row">
                        <div class="mobile-menu">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu Area End Here -->
        </header>
        <!-- Header Area End Here -->
        <!-- Begin Li's Breadcrumb Area -->
        <div class="breadcrumb-area">
            <div class="container">
                <div class="breadcrumb-content">
                    <ul>
                        <li><a href="index.php">Beranda</a></li>
                        <li class="active">Keranjang</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Li's Breadcrumb Area End Here -->
        <!--Shopping Cart Area Strat-->
        <div class="Shopping-cart-area pt-60 pb-60">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <?php
                        include "admin/koneksi.php";

                        if (isset($_POST['update_cart'])) {
                            if (!isset($_SESSION['id_user'])) {
                                echo "<script>alert('User tidak ditemukan!'); window.location='cart.php';</script>";
                                exit;
                            }
                        
                            $qtys = $_POST['qty'];
                            foreach ($qtys as $id_pesanan => $qty) {
                                $qty = (int)$qty;
                                if ($qty < 1) $qty = 1;
                        
                                
                                mysqli_query($koneksi, "UPDATE tb_pesanan SET qty = '$qty' WHERE id_pesanan = '$id_pesanan'");
                            }
                        
                            echo "<script>alert('Keranjang berhasil diperbarui!'); window.location='cart.php';</script>";
                            exit;
                        }
                        

                        if (isset($_POST['checkout'])) {
                            if (!isset($_SESSION['id_user'])) {
                                echo "<script>alert('User tidak ditemukan!'); window.location='cart.php';</script>";
                                exit;
                            }

                            $id_user = $_SESSION['id_user'];

                            // Ambil data pesanan user
                            $query_pesanan = mysqli_query($koneksi, "SELECT p.*, pr.harga 
                                FROM tb_pesanan p
                                JOIN tb_produk pr ON p.id_produk = pr.id_produk
                                WHERE p.id_user = '$id_user'
                            ");

                            if (!$query_pesanan || mysqli_num_rows($query_pesanan) == 0) {
                                echo "<script>alert('Keranjang kosong atau gagal mengambil data pesanan!'); window.location='cart.php';</script>";
                                exit;
                            }

                            // Hitung subtotal dan siapkan item
                            $subtotal = 0;
                            $items = [];
                            while ($row = mysqli_fetch_assoc($query_pesanan)) {
                                $total = $row['qty'] * $row['harga'];
                                $subtotal += $total;
                                $items[] = [
                                    'id_produk' => $row['id_produk'],
                                    'qty' => $row['qty'],
                                    'harga' => $total
                                ];
                            }

                            // Hitung diskon dan total bayar
                            $diskon = 0;
                            if ($subtotal > 3000000) {
                                $diskon = 0.07 * $subtotal;
                            } elseif ($subtotal > 1500000) {
                                $diskon = 0.05 * $subtotal;
                            }
                            $total_bayar = $subtotal - $diskon;

                            // Generate id_jual otomatis (format T001, T002, dst)
                            $result = mysqli_query($koneksi, "SELECT MAX(RIGHT(id_jual, 3)) AS max_id FROM tb_jual");
                            $row = mysqli_fetch_assoc($result);
                            $last_id = $row['max_id'];
                            $next_id = 'T' . str_pad((int)$last_id + 1, 3, '0', STR_PAD_LEFT);

                            // Insert ke tb_jual
                            $tgl = date('Y-m-d H:i:s');
                            $query_insert_jual = mysqli_query($koneksi, "INSERT INTO tb_jual (id_jual, id_user, tgl_jual, total, diskon) 
                                VALUES ('$next_id', '$id_user', '$tgl', '$total_bayar', '$diskon')");

                            if (!$query_insert_jual) {
                                echo "<script>alert('Gagal menyimpan data penjualan!'); window.location='cart.php';</script>";
                                exit;
                            }

                            // Insert ke tb_jualdtl
                            foreach ($items as $item) {
                                $query_dtl = mysqli_query($koneksi, "INSERT INTO tb_jualdtl (id_jual, id_produk, qty, harga) 
                                    VALUES ('$next_id', '{$item['id_produk']}', '{$item['qty']}', '{$item['harga']}')");

                                if (!$query_dtl) {
                                    echo "<script>alert('Gagal menyimpan detail penjualan!'); window.location='cart.php';</script>";
                                    exit;
                                }
                            }

                            // Hapus data pesanan user
                            $hapus = mysqli_query($koneksi, "DELETE FROM tb_pesanan WHERE id_user = '$id_user'");

                            if (!$hapus) {
                                echo "<script>alert('Gagal menghapus keranjang!'); window.location='cart.php';</script>";
                                exit;
                            }

                            echo "<script>alert('Checkout berhasil!'); window.location='cart.php';</script>";
                        }

                        ?>


                        <form method="post" action="">
                            <div class="table-content table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="li-product-remove">Hapus</th>
                                            <th class="li-product-thumbnail">Gambar</th>
                                            <th class="cart-product-name">Produk</th>
                                            <th class="li-product-price">Harga</th>
                                            <th class="li-product-quantity">Jumlah</th>
                                            <th class="li-product-subtotal">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include 'admin/koneksi.php';

                                        // Cek apakah user login
                                        if (!isset($_SESSION['username'])) {
                                            echo "<tr><td colspan='6'>Silakan login terlebih dahulu.</td></tr>";
                                            exit;
                                        }

                                        $username = $_SESSION['username'];

                                        // Ambil id_user dari username
                                        $query_user = mysqli_query($koneksi, "SELECT id_user FROM tb_user WHERE username = '$username'");
                                        $data_user = mysqli_fetch_assoc($query_user);
                                        $id_user = $data_user['id_user'];

                                        // Ambil data pesanan berdasarkan id_user
                                        $query_pesanan = mysqli_query($koneksi, "SELECT p.*, pr.nm_produk, pr.gambar, pr.harga 
    FROM tb_pesanan p
    JOIN tb_produk pr ON p.id_produk = pr.id_produk
    WHERE p.id_user = '$id_user'
");

                                        if (mysqli_num_rows($query_pesanan) > 0) {
                                            while ($row = mysqli_fetch_assoc($query_pesanan)) {
                                                $subtotal = $row['qty'] * $row['harga'];
                                                echo "<tr>
<td class='li-product-remove'>
                <a href='hapus_pesanan.php?id={$row['id_pesanan']}' onclick='return confirm(\"Yakin hapus item ini?\")'>
                    <i class='fa fa-times'></i>
                </a>
            </td>
            <td class='li-product-thumbnail'>
                <a href='#'><img src='admin/produk_img/{$row['gambar']}' alt='{$row['nm_produk']}' width='70'></a>
            </td>
            <td class='li-product-name'><a href='#'>{$row['nm_produk']}</a></td>
            <td class='li-product-price'><span class='amount'>Rp" . number_format($row['harga'], 0, ',', '.') . "</span></td>
            <td class='quantity'>
                <label>Quantity</label>
                <div class='cart-plus-minus'>
                    <input name='qty[{$row['id_pesanan']}]' class='cart-plus-minus-box' value='{$row['qty']}' type='number' min='1'>
                    <div class='dec qtybutton'><i class='fa fa-angle-down'></i></div>
                    <div class='inc qtybutton'><i class='fa fa-angle-up'></i></div>
                </div>
            </td>
            <td class='product-subtotal'>
                <span class='amount'>Rp" . number_format($subtotal, 0, ',', '.') . "</span>
            </td>
        </tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='6'>Keranjang kosong.</td></tr>";
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="coupon-all">
                                        <div class="coupon2">
                                            <input class="button" name="update_cart" value="Update cart" type="submit">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 ml-auto">
                                    <div class="cart-page-total">
                                        <h2>Total Pesanan</h2>
                                        <?php
                                        // Hitung ulang subtotal
                                        $subtotal = 0;
                                        mysqli_data_seek($query_pesanan, 0); // kembalikan ke baris awal jika query sebelumnya sudah digunakan
                                        while ($row = mysqli_fetch_assoc($query_pesanan)) {
                                            $subtotal += $row['qty'] * $row['harga'];
                                        }

                                        // Hitung diskon
                                        $diskon = 0;
                                        if ($subtotal > 3000000) {
                                            $diskon = 0.07 * $subtotal;
                                        } elseif ($subtotal > 1500000) {
                                            $diskon = 0.05 * $subtotal;
                                        }

                                        $total_bayar = $subtotal - $diskon;
                                        ?>

                                        <ul>
                                            <li>Subtotal <span>Rp <?= number_format($subtotal, 0, ',', '.') ?></span></li>
                                            <li>Diskon <span>Rp <?= number_format($diskon, 0, ',', '.') ?></span></li>
                                            <li>Total <span>Rp <?= number_format($total_bayar, 0, ',', '.') ?></span></li>
                                        </ul>

                                        <button type="submit" name="checkout" class="btn btn-dark mt-3">Checkout</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--Shopping Cart Area End-->
        <!-- Begin Footer Area -->
        <div class="footer">
            <!-- Begin Footer Static Top Area -->
            <div class="footer-static-top">
                <div class="container">
                    <!-- Begin Footer Shipping Area -->
                    <div class="footer-shipping pt-60 pb-55 pb-xs-25">
                        <div class="row">
                            <!-- Mulai Area Kotak Pengiriman Li -->
                            <div class="col-lg-3 col-md-6 col-sm-6 pb-sm-55 pb-xs-55">
                                <div class="li-shipping-inner-box">
                                    <div class="shipping-icon">
                                        <img src="images/shipping-icon/1.png" alt="Ikon Pengiriman">
                                    </div>
                                    <div class="shipping-text">
                                        <h2>Pengiriman Gratis</h2>
                                        <p>Dan pengembalian gratis. Lihat di halaman checkout untuk tanggal pengiriman.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Akhir Area Kotak Pengiriman Li -->

                            <!-- Mulai Area Kotak Pengiriman Li -->
                            <div class="col-lg-3 col-md-6 col-sm-6 pb-sm-55 pb-xs-55">
                                <div class="li-shipping-inner-box">
                                    <div class="shipping-icon">
                                        <img src="images/shipping-icon/2.png" alt="Ikon Pengiriman">
                                    </div>
                                    <div class="shipping-text">
                                        <h2>Pembayaran Aman</h2>
                                        <p>Bayar dengan metode pembayaran paling populer dan aman di dunia.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Akhir Area Kotak Pengiriman Li -->

                            <!-- Mulai Area Kotak Pengiriman Li -->
                            <div class="col-lg-3 col-md-6 col-sm-6 pb-xs-30">
                                <div class="li-shipping-inner-box">
                                    <div class="shipping-icon">
                                        <img src="images/shipping-icon/3.png" alt="Ikon Pengiriman">
                                    </div>
                                    <div class="shipping-text">
                                        <h2>Belanja dengan Percaya Diri</h2>
                                        <p Per>Perlindungan Pembeli kami melindungi pembelian Anda dari klik hingga pengiriman.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Akhir Area Kotak Pengiriman Li -->

                            <!-- Mulai Area Kotak Pengiriman Li -->
                            <div class="col-lg-3 col-md-6 col-sm-6 pb-xs-30">
                                <div class="li-shipping-inner-box">
                                    <div class="shipping-icon">
                                        <img src="images/shipping-icon/4.png" alt="Ikon Pengiriman">
                                    </div>
                                    <div class="shipping-text">
                                        <h2>Pusat Bantuan 24/7</h2>
                                        <p>Punya pertanyaan? Hubungi Spesialis kami atau chat secara online.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Akhir Area Kotak Pengiriman Li -->
                        </div>
                    </div>

                    <!-- Footer Shipping Area End Here -->
                </div>
            </div>
            <!-- Footer Static Top Area End Here -->
            <!-- Begin Footer Static Middle Area -->
            <div class="footer-static-middle">
                <div class="container">
                    <div class="footer-logo-wrap pt-50 pb-35">
                        <div class="row">
                            <!-- Begin Footer Logo Area -->
                            <div class="col-lg-4 col-md-6">
                                <div class="footer-logo">
                                    <h1>E-Zone</h1>
                                    <p class="info">
                                    E-Zone adalah toko online yang menyediakan berbagai produk elektronik berkualitas seperti TV, kipas angin dan barang elektronik lainnya dengan harga terbaik dan kualitas yang terbaik juga.
                                    </p>
                                </div>
                                <ul class="des">
                                    <li>
                                        <span>Alamat: </span>
                                        Jl. Melati No. 44, Blora, Jawa Tengah 13336, Indonesia
                                    </li>
                                    <li>
                                        <span>Telepon: </span>
                                        <a href="tel:+6287737893311">(+62) 877 3789 3311</a>
                                    </li>
                                    <li>
                                        <span>Email: </span>
                                        <a href="mailto:dunia@ezone.id">dunia@ezone.id</a>
                                    </li>
                                </ul>
                            </div>


                            <!-- Footer Logo Area End Here -->
                            <!-- Begin Footer Block Area -->
                            <div class="col-lg-2 col-md-3 col-sm-6">

                            </div>
                            <!-- Footer Block Area End Here -->
                            <!-- Begin Footer Block Area -->
                            <div class="col-lg-2 col-md-3 col-sm-6">

                            </div>
                            <!-- Footer Block Area End Here -->
                            <!-- Begin Footer Block Area -->
                            <div class="col-lg-4">
                                <div class="footer-block">
                                    <h3 class="footer-block-title">Ikuti Kami</h3>
                                    <ul class="social-link">
                                    <li class="instagram">
                                        <a href="https://www.instagram.com/rskaaadr" data-toggle="tooltip" target="_blank" title="Instagram">
                                            <i class="fa fa-instagram"></i>
                                        </a>
                                    </li>
                                    </ul>
                                </div>
                                <!-- Begin Footer Newsletter Area -->
                                <!-- Footer Newsletter Area End Here -->
                            </div>
                            <!-- Footer Block Area End Here -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer Static Middle Area End Here -->
            <!-- Begin Footer Static Bottom Area -->
            <div class="footer-static-bottom pt-55 pb-55">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Begin Footer Payment Area -->
                            <div class="copyright text-center">
                                <a href="#">
                                    <img src="images/payment/1.png" alt="">
                                </a>
                            </div>
                            <!-- Footer Payment Area End Here -->
                            <!-- Begin Copyright Area -->
                            <div class="copyright text-center pt-25">
                                <span><a target="_blank" href="https://www.instagram.com/rskaaadr">Designed by: Riska Andriani</a></span>
                            </div>
                            <!-- Copyright Area End Here -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer Static Bottom Area End Here -->
        </div>
    </div>
    <!-- Body Wrapper End Here -->
    <!-- jQuery-V1.12.4 -->
    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <!-- Popper js -->
    <script src="js/vendor/popper.min.js"></script>
    <!-- Bootstrap V4.1.3 Fremwork js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Ajax Mail js -->
    <script src="js/ajax-mail.js"></script>
    <!-- Meanmenu js -->
    <script src="js/jquery.meanmenu.min.js"></script>
    <!-- Wow.min js -->
    <script src="js/wow.min.js"></script>
    <!-- Slick Carousel js -->
    <script src="js/slick.min.js"></script>
    <!-- Owl Carousel-2 js -->
    <script src="js/owl.carousel.min.js"></script>
    <!-- Magnific popup js -->
    <script src="js/jquery.magnific-popup.min.js"></script>
    <!-- Isotope js -->
    <script src="js/isotope.pkgd.min.js"></script>
    <!-- Imagesloaded js -->
    <script src="js/imagesloaded.pkgd.min.js"></script>
    <!-- Mixitup js -->
    <script src="js/jquery.mixitup.min.js"></script>
    <!-- Countdown -->
    <script src="js/jquery.countdown.min.js"></script>
    <!-- Counterup -->
    <script src="js/jquery.counterup.min.js"></script>
    <!-- Waypoints -->
    <script src="js/waypoints.min.js"></script>
    <!-- Barrating -->
    <script src="js/jquery.barrating.min.js"></script>
    <!-- Jquery-ui -->
    <script src="js/jquery-ui.min.js"></script>
    <!-- Venobox -->
    <script src="js/venobox.min.js"></script>
    <!-- Nice Select js -->
    <script src="js/jquery.nice-select.min.js"></script>
    <!-- ScrollUp js -->
    <script src="js/scrollUp.min.js"></script>
    <!-- Main/Activator js -->
    <script src="js/main.js"></script>
</body>

<!-- shopping-cart31:32-->

</html>