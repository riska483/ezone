<?php
session_start();
?>
<!doctype html>
<html class="no-js" lang="zxx">

<!-- single-product31:30-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Detail Produk - E-Zone</title>
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
        <header class='li-header-4'>
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

                                        $nama_user = $_SESSION['username'];

                                    ?>

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
                                                </li> <!-- Garis pembatas -->
                                                <li>
                                                    <a href="logout.php" style="display: flex; align-items: center; justify-content: center; gap: 5px;">
                                                        <i class="fa fa-sign-out"></i> Logout
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>

                                        <?php
                                        include 'admin/koneksi.php';

                                        $id_user = $_SESSION['id_user'];

                                        $query_pesanan = mysqli_query($koneksi, "SELECT p.id_pesanan, p.qty, p.total, pr.nm_produk, pr.gambar, pr.id_produk
                                        FROM tb_pesanan p JOIN tb_produk pr ON p.id_produk = pr.id_produk 
                                        WHERE p.id_user = '$id_user'");

                                        $total_bayar = 0;
                                        $total_qty = 0;

                                        $produk_list = [];

                                        if (mysqli_num_rows($query_pesanan) > 0) {
                                            while ($row = mysqli_fetch_assoc($query_pesanan)) {
                                                $produk_list[] = $row;
                                                $subtotal = $row['total'];
                                                $total_bayar += $subtotal;
                                                $total_qty += $row['qty'];
                                            }
                                        }
                                        ?>

                                        <!-- Mini Cart -->
                                        <li class="hm-minicart">
                                            <div class="hm-minicart-trigger">
                                                <span class="item-icon"></span>

                                                <?php
                                                include 'admin/koneksi.php';

                                                $username = $_SESSION['username'];
                                                $query_user = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE username = '$username'");
                                                $data_user = mysqli_fetch_assoc($query_user);
                                                $id_user = $data_user['id_user'];

                                                $query_pesanan = mysqli_query($koneksi, "SELECT p.*, pr.harga 
                                                FROM tb_pesanan p
                                                JOIN tb_produk pr ON p.id_produk = pr.id_produk
                                                WHERE p.id_user = '$id_user'");

                                                $subtotal = 0;
                                                $total_item = 0;
                                                while ($row = mysqli_fetch_assoc($query_pesanan)) {
                                                    $subtotal += $row['total'];
                                                    $total_item += $row['qty'];
                                                }

                                                $diskon = 0;
                                                if ($subtotal >= 3000000) {
                                                    $diskon = 0.07 * $subtotal;
                                                } elseif ($subtotal >= 1500000) {
                                                    $diskon = 0.05 * $subtotal;
                                                }

                                                $total_bayar = $subtotal - $diskon;

                                                echo "<span class='item-text'>Rp" . number_format($total_bayar, 0) . " <span class='cart-item-count'>$total_item</span></span>";
                                                ?>
                                            </div>
                                            <span></span>

                                            <div class="minicart">
                                                <ul class="minicart-product-list">
                                                    <?php if (!empty($produk_list)): ?>
                                                        <?php foreach ($produk_list as $row): ?>
                                                            <li>
                                                                <a href="detail_produk.php?id=<?= $row['id_produk']; ?>" class="minicart-product-image">
                                                                    <img src="admin/produk_img/<?= $row['gambar']; ?>" alt="cart product" width="70">
                                                                </a>
                                                                <div class="minicart-product-details">
                                                                    <h6><a href="detail_produk.php?id=<?= $row['id_produk']; ?>"><?= $row['nm_produk']; ?></a></h6>
                                                                    <span>Rp<?= number_format($row['total'], 0, ',', '.') ?> x <?= $row['qty']; ?></span>
                                                                </div>
                                                                <form method="POST" action="hapus_pesanan.php?id=<?= $row['id_pesanan']; ?>" style="display:inline;">
                                                                    <button class="close" type="submit"><i class="fa fa-close"></i></button>
                                                                </form>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <li class='minicart-empty'>Keranjang kosong.</li>
                                                    <?php endif; ?>
                                                </ul>

                                                <p class="minicart-total">TOTAL BAYAR: <span>Rp<?= number_format($total_bayar, 0, ',', '.'); ?></span></p>
                                                <div class="minicart-button">
                                                    <a href="cart.php" class="li-button li-button-dark li-button-fullwidth li-button-sm">
                                                        <span>View Full Cart</span>
                                                    </a>
                                                    <form method="POST" action="cart.php">
                                                        <input type="hidden" name="checkout" value="1">
                                                        <button type="submit" class="li-button li-button-fullwidth li-button-sm" style="border: none;">
                                                            <span>Checkout</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>
                                    <!-- Header Mini Cart Area End Here -->
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
            <div class="mobile-menu-area d-lg-none d-xl-none col-12">
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
                        <li><a href="belanja.php">Belanja</a></li>
                        <li class="active">Detail Produk</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Li's Breadcrumb Area End Here -->
        <!-- content-wraper start -->
        <?php
        include 'admin/koneksi.php';

        $id = $_GET['id'];
        $query = mysqli_query($koneksi, "SELECT p.*, k.nm_kategori FROM tb_produk p 
                                LEFT JOIN tb_kategori k ON p.id_kategori = k.id_kategori 
                                WHERE id_produk='$id'");
        $data = mysqli_fetch_assoc($query);
        ?>

        <div class="content-wraper">
            <div class="container">
                <div class="row single-product-area">
                    <div class="col-lg-5 col-md-6">
                        <!-- Product Details Left -->
                        <div class="product-details-left">
                            <div class="product-details-images slider-navigation-1">
                                <div class="lg-image">
                                    <a class="popup-img venobox vbox-item" href="admin/produk_img/<?=
                                                                                                    $data['gambar'] ?>" data-gall="myGallery">
                                        <img src="admin/produk_img/<?= $data['gambar'] ?>" alt="<?=
                                                                                                $data['nm_produk'] ?>" width="300" height="300">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!--// Product Details Left -->
                    </div>

                    <?php if ($data['stok'] == 0) : ?>
                        <script>
                            alert('Stok produk ini sudah habis.');
                            window.location.href = 'belanja.php';
                        </script>
                    <?php endif; ?>


                    <div class="col-lg-7 col-md-6">
                        <div class="product-details-view-content p-2">
                            <div class="product-info">
                                <h2><?= $data['nm_produk'] ?></h2>
                                <span class="product-details-ref">Kategori: <?= $data['nm_kategori'] ?></span>
                                <div class="price-box pt-20">
                                    <span class="new-price new-price-2">Rp<?= number_format($data['harga'], 0, ',', '.') ?></span>
                                </div>
                                <div class="product-desc">
                                    <p>
                                        <span><?= nl2br($data['desk']) ?></span>
                                    </p>
                                    <p><strong>Stok tersedia:</strong> <?= $data['stok'] ?> unit</p>
                                </div>

                                <div class="single-add-to-cart">
                                    <form action="tambah_ke_keranjang.php" method="POST" class="cart-quantity">
                                        <input type="hidden" name="id_produk" value="<?= $data['id_produk'] ?>">
                                        <input type="hidden" name="id_user" value="<?= $_SESSION['id_user'] ?>">
                                        <input type="hidden" name="harga" value="<?= $data['harga'] ?>">
                                        <input type="hidden" name="redirect_url" value="<?= $_SERVER['REQUEST_URI'] ?>">
                                        <div class="quantity">
                                            <label>Jumlah</label>
                                            <div class="cart-plus-minus">
                                                <input name="jumlah" class="cart-plus-minus-box" value="1" type="number" min="1" max="<?= $data['stok'] ?>">
                                                <div class="dec qtybutton"><i class="fa fa-angle-down"></i></div>
                                                <div class="inc qtybutton"><i class="fa fa-angle-up"></i></div>
                                            </div>
                                        </div>
                                        <button class="add-to-cart" type="submit">Beli Sekarang</button>
                                    </form>

                                </div>
                                <div class="product-additional-info pt-25">
                                    <div class="product-social-sharing pt-25">
                                        <ul>
                                            <li class="instagram"><a href="https://www.instagram.com/rskaaadr" target="_blank"><i class="fa fa-instagram"></i>Instagram</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wraper end -->
        <!-- Begin Product Area -->
        <div class="product-area pt-35">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="li-product-tab">
                            <ul class="nav li-product-menu">
                                <li><a class="active" data-toggle="tab" href="#description"><span>Deskripsi</span></a></li>
                            </ul>
                        </div>
                        <!-- Begin Li's Tab Menu Content Area -->
                    </div>
                </div>
                <div class="tab-content">
                    <div id="description" class="tab-pane active show" role="tabpanel">
                        <div class="product-description">
                            <span><?= nl2br($data['desk']) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Begin Quick View | Modal Area -->
    <div class="modal fade modal-wrapper" id="mymodal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="review-page-title">Write Your Review</h3>
                    <div class="modal-inner-area row">
                        <div class="col-lg-6">
                            <div class="li-review-product">
                                <img src="images/product/large-size/3.jpg" alt="Li's Product">
                                <div class="li-review-product-desc">
                                    <p class="li-product-name">Today is a good day Framed poster</p>
                                    <p>
                                        <span>Beach Camera Exclusive Bundle - Includes Two Samsung Radiant 360 R3 Wi-Fi Bluetooth Speakers. Fill The Entire Room With Exquisite Sound via Ring Radiator Technology. Stream And Control R3 Speakers Wirelessly With Your Smartphone. Sophisticated, Modern Design </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="li-review-content">
                                <!-- Begin Feedback Area -->
                                <div class="feedback-area">
                                    <div class="feedback">
                                        <h3 class="feedback-title">Our Feedback</h3>
                                        <form action="#">
                                            <p class="your-opinion">
                                                <label>Your Rating</label>
                                                <span>
                                                    <select class="star-rating">
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </span>
                                            </p>
                                            <p class="feedback-form">
                                                <label for="feedback">Your Review</label>
                                                <textarea id="feedback" name="comment" cols="45" rows="8" aria-required="true"></textarea>
                                            </p>
                                            <div class="feedback-input">
                                                <p class="feedback-form-author">
                                                    <label for="author">Name<span class="required">*</span>
                                                    </label>
                                                    <input id="author" name="author" value="" size="30" aria-required="true" type="text">
                                                </p>
                                                <p class="feedback-form-author feedback-form-email">
                                                    <label for="email">Email<span class="required">*</span>
                                                    </label>
                                                    <input id="email" name="email" value="" size="30" aria-required="true" type="text">
                                                    <span class="required"><sub>*</sub> Required fields</span>
                                                </p>
                                                <div class="feedback-btn pb-15">
                                                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">Close</a>
                                                    <a href="#">Submit</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- Feedback Area End Here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quick View | Modal Area End Here -->
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <!-- Product Area End Here -->
    <!-- Begin Li's Laptop Product Area -->
    <section class="product-area li-laptop-product pt-30 pb-50">
        <div class="container">
            <div class="row">
                <!-- Begin Li's Section Area -->
                <div class="col-lg-12">
                    <div class="li-section-title">
                        <h2>
                            <span>Produk Lainnya</span>
                        </h2>
                    </div>
                    <div class="row">
                        <div class="product-active owl-carousel">
                            <?php
                            include 'admin/koneksi.php';
                            $id_produk = $_GET['id'];

                            $query_produk_lain = mysqli_query($koneksi, "SELECT * FROM tb_produk WHERE id_produk != '$id_produk' ORDER BY RAND() LIMIT 6");
                            while ($p = mysqli_fetch_array($query_produk_lain)) {
                            ?>
                                <div class="col-lg-12">
                                    <!-- single-product-wrap start -->
                                    <div class="single-product-wrap">
                                        <div class="product-image">
                                            <a href="detail_produk.php?id_produk=<?= $p['id_produk'] ?>">
                                                <img src="admin/produk_img/<?= $p['gambar'] ?>" alt="<?= $p['nm_produk'] ?>" width="300" height="300">
                                            </a>
                                        </div>
                                        <div class="product_desc">
                                            <div class="product_desc_info">
                                                <div class="product-review">
                                                    <h5 class="manufacturer">
                                                        <a href="#"><?= $p['id_kategori'] ?></a>
                                                        <!-- Bisa diganti nama kategori jika join -->
                                                    </h5>
                                                </div>
                                                <h4>
                                                    <a class="product_name" href="detail_produk.php?id_produk=<?= $p['id_produk'] ?>">
                                                        <?= $p['nm_produk'] ?>
                                                    </a>
                                                </h4>
                                                <div class="price-box">
                                                    <span class="new-price">Rp<?= number_format($p['harga'], 0, ',', '.') ?></span>
                                                </div>
                                            </div>
                                            <div class="add-actions">
                                                <ul class="add-actions-link">
                                                    <li class="add-cart active">
                                                        <a href="detail_produk.php?id=<?= $p['id_produk'] ?>">Beli Sekarang</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- single-product-wrap end -->
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <!-- Li's Section Area End Here -->
            </div>
        </div>
    </section>
    <!-- Li's Laptop Product Area End Here -->
    <!-- Begin Footer Area -->
    <div class="footer">
        <!-- Begin Footer Static Top Area -->
        <div class="footer-static-top">
            <div class="container">
                <!-- Begin Footer Shipping Area -->
                <div class="footer-shipping pt-60 pb-55 pb-xs-25">
                    <div class="row">
                        <!-- Begin Li's Shipping Inner Box Area -->
                        <div class="col-lg-3 col-md-6 col-sm-6 pb-sm-55 pb-xs-55">
                            <div class="li-shipping-inner-box">
                                <div class="shipping-icon">
                                    <img src="images/shipping-icon/1.png" alt="Shipping Icon">
                                </div>
                                <div class="shipping-text">
                                    <h2>Pengiriman Gratis</h2>
                                    <p>Dan pengembalian gratis. Lihat di halaman checkout untuk tanggal pengiriman.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Li's Shipping Inner Box Area End Here -->
                        <!-- Begin Li's Shipping Inner Box Area -->
                        <div class="col-lg-3 col-md-6 col-sm-6 pb-sm-55 pb-xs-55">
                            <div class="li-shipping-inner-box">
                                <div class="shipping-icon">
                                    <img src="images/shipping-icon/2.png" alt="Shipping Icon">
                                </div>
                                <div class="shipping-text">
                                    <h2>Pembayaran Aman</h2>
                                    <p>Bayar dengan metode pembayaran paling populer dan aman di dunia.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Li's Shipping Inner Box Area End Here -->
                        <!-- Begin Li's Shipping Inner Box Area -->
                        <div class="col-lg-3 col-md-6 col-sm-6 pb-xs-30">
                            <div class="li-shipping-inner-box">
                                <div class="shipping-icon">
                                    <img src="images/shipping-icon/3.png" alt="Shipping Icon">
                                </div>
                                <div class="shipping-text">
                                    <h2>Belanja dengan Percaya Diri</h2>
                                    <p Per>Perlindungan Pembeli kami melindungi pembelian Anda dari klik hingga pengiriman.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Li's Shipping Inner Box Area End Here -->
                        <!-- Begin Li's Shipping Inner Box Area -->
                        <div class="col-lg-3 col-md-6 col-sm-6 pb-xs-30">
                            <div class="li-shipping-inner-box">
                                <div class="shipping-icon">
                                    <img src="images/shipping-icon/4.png" alt="Shipping Icon">
                                </div>
                                <div class="shipping-text">
                                    <h2>Pusat Bantuan 24/7</h2>
                                    <p>Punya pertanyaan? Hubungi Spesialis kami atau chat secara online.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Li's Shipping Inner Box Area End Here -->
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
    <!-- Footer Area End Here -->
    </div>
    <!-- Begin Quick View | Modal Area -->
    <div class="modal fade modal-wrapper" id="exampleModalCenter">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="modal-inner-area row">
                        <div class="col-lg-5 col-md-6 col-sm-6">
                            <!-- Product Details Left -->
                            <div class="product-details-left">
                                <div class="product-details-images slider-navigation-1">
                                    <div class="lg-image">
                                        <img src="images/product/large-size/1.jpg" alt="product image">
                                    </div>
                                    <div class="lg-image">
                                        <img src="images/product/large-size/2.jpg" alt="product image">
                                    </div>
                                    <div class="lg-image">
                                        <img src="images/product/large-size/3.jpg" alt="product image">
                                    </div>
                                    <div class="lg-image">
                                        <img src="images/product/large-size/4.jpg" alt="product image">
                                    </div>
                                    <div class="lg-image">
                                        <img src="images/product/large-size/5.jpg" alt="product image">
                                    </div>
                                    <div class="lg-image">
                                        <img src="images/product/large-size/6.jpg" alt="product image">
                                    </div>
                                </div>
                                <div class="product-details-thumbs slider-thumbs-1">
                                    <div class="sm-image"><img src="images/product/small-size/1.jpg" alt="product image thumb"></div>
                                    <div class="sm-image"><img src="images/product/small-size/2.jpg" alt="product image thumb"></div>
                                    <div class="sm-image"><img src="images/product/small-size/3.jpg" alt="product image thumb"></div>
                                    <div class="sm-image"><img src="images/product/small-size/4.jpg" alt="product image thumb"></div>
                                    <div class="sm-image"><img src="images/product/small-size/5.jpg" alt="product image thumb"></div>
                                    <div class="sm-image"><img src="images/product/small-size/6.jpg" alt="product image thumb"></div>
                                </div>
                            </div>
                            <!--// Product Details Left -->
                        </div>

                        <div class="col-lg-7 col-md-6 col-sm-6">
                            <div class="product-details-view-content pt-60">
                                <div class="product-info">
                                    <h2>Today is a good day Framed poster</h2>
                                    <span class="product-details-ref">Reference: demo_15</span>
                                    <div class="rating-box pt-20">
                                        <ul class="rating rating-with-review-item">
                                            <li><i class="fa fa-star-o"></i></li>
                                            <li><i class="fa fa-star-o"></i></li>
                                            <li><i class="fa fa-star-o"></i></li>
                                            <li class="no-star"><i class="fa fa-star-o"></i></li>
                                            <li class="no-star"><i class="fa fa-star-o"></i></li>
                                            <li class="review-item"><a href="#">Read Review</a></li>
                                            <li class="review-item"><a href="#">Write Review</a></li>
                                        </ul>
                                    </div>
                                    <div class="price-box pt-20">
                                        <span class="new-price new-price-2">$57.98</span>
                                    </div>
                                    <div class="product-desc">
                                        <p>
                                            <span>100% cotton double printed dress. Black and white striped top and orange high waisted skater skirt bottom. Lorem ipsum dolor sit amet, consectetur adipisicing elit. quibusdam corporis, earum facilis et nostrum dolorum accusamus similique eveniet quia pariatur.
                                            </span>
                                        </p>
                                    </div>
                                    <div class="product-variants">
                                        <div class="produt-variants-size">
                                            <label>Dimension</label>
                                            <select class="nice-select">
                                                <option value="1" title="S" selected="selected">40x60cm</option>
                                                <option value="2" title="M">60x90cm</option>
                                                <option value="3" title="L">80x120cm</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="single-add-to-cart">
                                        <form action="#" class="cart-quantity">
                                            <div class="quantity">
                                                <label>Quantity</label>
                                                <div class="cart-plus-minus">
                                                    <input class="cart-plus-minus-box" value="1" type="text">
                                                    <div class="dec qtybutton"><i class="fa fa-angle-down"></i></div>
                                                    <div class="inc qtybutton"><i class="fa fa-angle-up"></i></div>
                                                </div>
                                            </div>
                                            <button class="add-to-cart" type="submit">Add to cart</button>
                                        </form>
                                    </div>
                                    <div class="product-additional-info pt-25">
                                        <a class="wishlist-btn" href="wishlist.html"><i class="fa fa-heart-o"></i>Add to wishlist</a>
                                        <div class="product-social-sharing pt-25">
                                            <ul>
                                                <li class="instagram"><a href="https://www.instagram.com/rskaaadr" target="_blank"><i class="fa fa-instagram"></i>Instagram</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quick View | Modal Area End Here -->
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

<!-- single-product31:32-->

</html>