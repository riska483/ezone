<?php
session_start();
?>
<!doctype html>
<html class="no-js" lang="zxx">

<!-- shop-list31:48-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Belanja - E-Zone</title>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .nice-select .list {
            max-height: none !important;
            overflow: visible !important;
        }

        .nice-select .list {
            max-height: 300px !important;
            overflow-y: auto !important;
        }
    </style>

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
                            <!-- Begin Header Middle Searchbox Area -->
                            <form action="" method="GET" class="hm-searchbox">
                                <select name="kategori" class="nice-select select-search-category">
                                    <option value="">All</option>
                                    <?php
                                    include 'admin/koneksi.php';
                                    $kategoriQuery = mysqli_query($koneksi, "SELECT * FROM tb_kategori ORDER BY nm_kategori ASC");
                                    while ($kategori = mysqli_fetch_assoc($kategoriQuery)) {
                                        $selected = (isset($_GET['kategori']) && $_GET['kategori'] == $kategori['id_kategori']) ? 'selected' : '';
                                        echo "<option value='{$kategori['id_kategori']}' $selected>{$kategori['nm_kategori']}</option>";
                                    }
                                    ?>
                                </select>
                                <input type="text" name="keyword" placeholder="Enter your search key ..." value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>">
                                <button class="li-btn" type="submit"><i class="fa fa-search"></i></button>
                            </form>

                            <!-- Header Middle Searchbox Area End Here -->
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
                        <li><a href="index.php">Beranda</a></li>
                        <li class="active">Belanja</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Li's Breadcrumb Area End Here -->
        <!-- Begin Li's Content Wraper Area -->
        <div class="content-wraper pt-60 pb-60">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 order-1 order-lg-2">
                        <!-- Begin Li's Banner Area -->
                        <div class="single-banner shop-page-banner">
                            <a href="#">
                                <img src="images/bg-banner/5.jpg" alt="Li's Static Banner">
                            </a>
                        </div>
                        <!-- Li's Banner Area End Here -->
                        <!-- shop-top-bar start -->
                        <div class="shop-top-bar mt-30">
                            <div class="shop-bar-inner">
                                <div class="product-view-mode">
                                    <!-- shop-item-filter-list start -->
                                    <ul class="nav shop-item-filter-list" role="tablist">
                                        <li role="presentation"><a data-toggle="tab" role="tab" aria-controls="grid-view" href="#grid-view"><i class="fa fa-th"></i></a></li>
                                        <li class="active" role="presentation"><a aria-selected="true" class="active show" data-toggle="tab" role="tab" aria-controls="list-view" href="#list-view"><i class="fa fa-th-list"></i></a></li>
                                    </ul>
                                    <!-- shop-item-filter-list end -->
                                </div>
                                <?php
                                $page     = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                                $limit    = 12;
                                $offset   = ($page - 1) * $limit;
                                $start = $offset + 1;
                                // Hitung total data
                                $countSql = "
                                    SELECT COUNT(*) AS total 
                                    FROM tb_produk p 
                                    JOIN tb_kategori k ON p.id_kategori = k.id_kategori 
                                    WHERE 1=1
                                ";
                                $countQuery = mysqli_query($koneksi, $countSql);
                                $totalData = mysqli_fetch_assoc($countQuery)['total'];
                                $end = min($offset + $limit, $totalData);
                                ?>
                                <span class="mt-1">Menampilkan <?= $start ?> hingga <?= $end ?> dari <?= $totalData ?> produk</span>
                            </div>
                            <!-- product-select-box start -->
                            <!-- product-select-box end -->
                        </div>
                        <!-- shop-top-bar end -->
                        <!-- shop-products-wrapper start -->
                        <div class="shop-products-wrapper">
                            <div class="tab-content">
                                <div id="grid-view" class="tab-pane fade" role="tabpanel">
                                    <div class="product-area shop-product-area">
                                        <div class="row">
                                            <?php
                                            include 'admin/koneksi.php';

                                            // Ambil parameter pencarian dan sorting
                                            $kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
                                            $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
                                            $page     = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                                            $limit    = 12;
                                            $offset   = ($page - 1) * $limit;
                                            $sort     = isset($_GET['sort']) ? $_GET['sort'] : 'default';

                                            // Tentukan urutan sorting
                                            switch ($sort) {
                                                case 'name-asc':
                                                    $orderBy = 'ORDER BY p.nm_produk ASC';
                                                    break;
                                                case 'name-desc':
                                                    $orderBy = 'ORDER BY p.nm_produk DESC';
                                                    break;
                                                case 'price-asc':
                                                    $orderBy = 'ORDER BY p.harga ASC';
                                                    break;
                                                case 'price-desc':
                                                    $orderBy = 'ORDER BY p.harga DESC';
                                                    break;
                                                default:
                                                    $orderBy = 'ORDER BY p.id_produk DESC'; // default terbaru
                                                    break;
                                            }

                                            // Hitung total data
                                            $countSql = "SELECT COUNT(*) AS total 
    FROM tb_produk p 
    JOIN tb_kategori k ON p.id_kategori = k.id_kategori 
    WHERE 1=1
";

                                            if (!empty($kategori)) {
                                                $countSql .= " AND p.id_kategori = '" . mysqli_real_escape_string($koneksi, $kategori) . "'";
                                            }
                                            if (!empty($keyword)) {
                                                $countSql .= " AND p.nm_produk LIKE '%" . mysqli_real_escape_string($koneksi, $keyword) . "%'";
                                            }

                                            $countQuery = mysqli_query($koneksi, $countSql);
                                            $totalData = mysqli_fetch_assoc($countQuery)['total'];
                                            $totalPages = ceil($totalData / $limit);

                                            // Ambil data produk
                                            $sql = "SELECT p.*, k.nm_kategori 
    FROM tb_produk p 
    JOIN tb_kategori k ON p.id_kategori = k.id_kategori 
    WHERE 1=1
";

                                            if (!empty($kategori)) {
                                                $sql .= " AND p.id_kategori = '" . mysqli_real_escape_string($koneksi, $kategori) . "'";
                                            }
                                            if (!empty($keyword)) {
                                                $sql .= " AND p.nm_produk LIKE '%" . mysqli_real_escape_string($koneksi, $keyword) . "%'";
                                            }

                                            $sql .= " $orderBy LIMIT $limit OFFSET $offset";

                                            $query = mysqli_query($koneksi, $sql);
                                            while ($data = mysqli_fetch_assoc($query)) {
                                            ?>

                                                <div class="col-lg-4 col-md-4 col-sm-6 mt-40">
                                                    <div class="single-product-wrap">
                                                        <div class="product-image">
                                                            <a href="detail_produk.php?id=<?= $data['id_produk']; ?>">
                                                                <img src="admin/produk_img/<?= $data['gambar']; ?>" alt="<?= $data['nm_produk']; ?>" width="300" height="300">
                                                            </a>
                                                        </div>
                                                        <div class="product_desc">
                                                            <div class="product_desc_info">
                                                                <div class="product-review">
                                                                    <h5 class="manufacturer">
                                                                        <a href="#"><?= $data['nm_kategori']; ?></a>
                                                                    </h5>
                                                                </div>
                                                                <h4>
                                                                    <a class="product_name" href="detail_produk.php?id=<?= $data['id_produk']; ?>">
                                                                        <?= $data['nm_produk']; ?>
                                                                    </a>
                                                                </h4>
                                                                <div class="price-box">
                                                                    <span class="new-price">Rp<?= number_format($data['harga'], 0, ',', '.'); ?></span>
                                                                </div>
                                                            </div>
                                                            <div class="add-actions">
                                                                <ul class="add-actions-link">
                                                                    <li class="add-cart active">
                                                                        <a href="detail_produk.php?id=<?= $data['id_produk']; ?>">Beli Sekarang</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#" class="quick-view" data-toggle="modal" data-target="#exampleModalCenter" data-id="<?= $data['id_produk']; ?>">
                                                                            <i class="fa fa-eye"></i>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                                <div id="list-view" class="tab-pane fade product-list-view active show" role="tabpanel">
                                    <div class="row">
                                        <div class="col">
                                            <?php
                                            include 'admin/koneksi.php';

                                            // Ambil parameter pencarian dan sorting
                                            $kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
                                            $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
                                            $page     = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                                            $limit    = 12;
                                            $offset   = ($page - 1) * $limit;
                                            $sort     = isset($_GET['sort']) ? $_GET['sort'] : 'default';

                                            // Tentukan urutan sorting
                                            switch ($sort) {
                                                case 'name-asc':
                                                    $orderBy = 'ORDER BY p.nm_produk ASC';
                                                    break;
                                                case 'name-desc':
                                                    $orderBy = 'ORDER BY p.nm_produk DESC';
                                                    break;
                                                case 'price-asc':
                                                    $orderBy = 'ORDER BY p.harga ASC';
                                                    break;
                                                case 'price-desc':
                                                    $orderBy = 'ORDER BY p.harga DESC';
                                                    break;
                                                default:
                                                    $orderBy = 'ORDER BY p.id_produk DESC'; // default terbaru
                                                    break;
                                            }


                                            $countSql = "SELECT COUNT(*) AS total 
    FROM tb_produk p 
    JOIN tb_kategori k ON p.id_kategori = k.id_kategori 
    WHERE 1=1
";

                                            if (!empty($kategori)) {
                                                $countSql .= " AND p.id_kategori = '" . mysqli_real_escape_string($koneksi, $kategori) . "'";
                                            }
                                            if (!empty($keyword)) {
                                                $countSql .= " AND p.nm_produk LIKE '%" . mysqli_real_escape_string($koneksi, $keyword) . "%'";
                                            }

                                            $countQuery = mysqli_query($koneksi, $countSql);
                                            $totalData = mysqli_fetch_assoc($countQuery)['total'];
                                            $totalPages = ceil($totalData / $limit);

                                            // Ambil data produk
                                            $sql = "SELECT p.*, k.nm_kategori 
    FROM tb_produk p 
    JOIN tb_kategori k ON p.id_kategori = k.id_kategori 
    WHERE 1=1
";

                                            if (!empty($kategori)) {
                                                $sql .= " AND p.id_kategori = '" . mysqli_real_escape_string($koneksi, $kategori) . "'";
                                            }
                                            if (!empty($keyword)) {
                                                $sql .= " AND p.nm_produk LIKE '%" . mysqli_real_escape_string($koneksi, $keyword) . "%'";
                                            }

                                            $sql .= " $orderBy LIMIT $limit OFFSET $offset";

                                            $query = mysqli_query($koneksi, $sql);
                                            while ($data = mysqli_fetch_assoc($query)) {
                                            ?>

                                                <div class="row product-layout-list">
                                                    <div class="col-lg-3 col-md-5">
                                                        <div class="product-image">
                                                            <a href="detail_produk.php?id=<?= $data['id_produk']; ?>">
                                                                <img src="admin/produk_img/<?= $data['gambar']; ?>" alt="<?= $data['nm_produk']; ?>" width="300" height="300">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-md-7">
                                                        <div class="product_desc">
                                                            <div class="product_desc_info">
                                                                <div class="product-review">
                                                                    <h5 class="manufacturer">
                                                                        <a href="#"><?= $data['nm_kategori']; ?></a>
                                                                    </h5>
                                                                </div>
                                                                <h4><a class="product_name" href="detail_produk.php?id=<?= $data['id_produk']; ?>">
                                                                        <?= $data['nm_produk']; ?>
                                                                    </a></h4>
                                                                <div class="price-box">
                                                                    <span class="new-price">Rp<?= number_format($data['harga'], 0, ',', '.'); ?></span>
                                                                </div>
                                                                <p><?= substr($data['desk'], 0, 150); ?>...</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="shop-add-action mb-xs-30">
                                                            <ul class="add-actions-link">
                                                                <li class="add-cart">
                                                                    <a href="detail_produk.php?id=<?= $data['id_produk']; ?>">Beli Sekarang</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" class="quick-view" data-toggle="modal" data-target="#exampleModalCenter" data-id="<?= $data['id_produk']; ?>">
                                                                        <i class="fa fa-eye"></i>Lihat Cepat
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="paginatoin-area">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <p>Menampilkan <?= min($limit, $totalData - $offset) ?> dari <?= $totalData ?> produk</p>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <ul class="pagination-box">
                                                <?php if ($page > 1) : ?>
                                                    <li><a href="?page=<?= $page - 1 ?>&kategori=<?= $kategori ?>&keyword=<?= $keyword ?>" class="Previous"><i class="fa fa-chevron-left"></i> Sebelumnya</a></li>
                                                <?php endif; ?>

                                                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                                    <li class="<?= ($i == $page) ? 'active' : '' ?>">
                                                        <a href="?page=<?= $i ?>&kategori=<?= $kategori ?>&keyword=<?= $keyword ?>"><?= $i ?></a>
                                                    </li>
                                                <?php endfor; ?>

                                                <?php if ($page < $totalPages) : ?>
                                                    <li><a href="?page=<?= $page + 1 ?>&kategori=<?= $kategori ?>&keyword=<?= $keyword ?>" class="Next">Berikutnya <i class="fa fa-chevron-right"></i></a></li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- shop-products-wrapper end -->
                    </div>
                    <div class="col-lg-3 order-2 order-lg-1">
                        <!--sidebar-categores-box start  -->
                        <div class="sidebar-categores-box">
                            <div class="sidebar-title">
                                <h2>Filter</h2>
                            </div>
                            <!-- btn-clear-all start -->
                            <button class="btn-clear-all mb-sm-30 mb-xs-30" onclick="window.location.href='<?= basename($_SERVER['PHP_SELF']) ?>'">Clear all</button>
                            <!-- btn-clear-all end -->
                            <!-- filter-sub-area start -->
                            <div class="filter-sub-area pt-sm-10 pt-xs-10">
                                <h5 class="filter-sub-titel">Kategori Produk</h5>
                                <div class="categori-checkbox">
                                    <form action="" method="get">
                                        <ul>
                                            <?php
                                            include 'admin/koneksi.php';
                                            $kategoriQuery = mysqli_query($koneksi, "SELECT * FROM tb_kategori");

                                            while ($kategori = mysqli_fetch_assoc($kategoriQuery)) {
                                                $checked = (isset($_GET['kategori']) && $_GET['kategori'] == $kategori['id_kategori']) ? 'checked' : '';
                                                echo '<li>
                    <label>
                        <input type="radio" name="kategori" value="' . $kategori['id_kategori'] . '" ' . $checked . ' onchange="this.form.submit()">
                        ' . $kategori['nm_kategori'] . '
                    </label>
                  </li>';
                                            }
                                            ?>
                                        </ul>
                                    </form>

                                </div>
                            </div>
                            <!-- filter-sub-area end -->
                        </div>
                        <!--sidebar-categores-box end  -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content Wraper Area End Here -->
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
                                    <img src="images/shipping-icon/1.png" alt="Ikon Pengiriman">
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
                                    <img src="images/shipping-icon/2.png" alt="Ikon Pengiriman">
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
                                    <img src="images/shipping-icon/3.png" alt="Ikon Pengiriman">
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
                                    <img src="images/shipping-icon/4.png" alt="Ikon Pengiriman">
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
                                        <img src="" alt="product image" id="modal-gambar">
                                    </div>
                                </div>
                            </div>
                            <!--// Product Details Left -->
                        </div>

                        <div class="col-lg-7 col-md-6 col-sm-6">
                            <div class="product-details-view-content pt-60">
                                <div class="product-info">
                                    <h2 id="modal-nama-produk"></h2>
                                    <span class="product-details-ref" id="modal-kategori">Kategori</span>
                                    <div class="price-box pt-20">
                                        <span class="new-price new-price-2" id="modal-harga">Rp0</span>
                                    </div>
                                    <div class="product-desc">
                                        <p id="modal-desk"></p>
                                        <p><strong>Stok tersedia:</strong> <span id="modal-stok">0</span> unit</p>
                                    </div>

                                    <div class="single-add-to-cart">
                                        <form action="tambah_ke_keranjang.php" method="POST" class="cart-quantity">
                                            <input type="hidden" name="id_produk" id="input-id-produk">
                                            <input type="hidden" name="id_user" value="<?= isset($_SESSION['id_user']) ? $_SESSION['id_user'] : '' ?>">
                                            <input type="hidden" name="harga" id="input-harga">
                                            <input type="hidden" name="redirect_url" value="belanja.php">

                                            <div class="quantity">
                                                <label>Jumlah</label>
                                                <div class="cart-plus-minus">
                                                    <input class="cart-plus-minus-box" name="jumlah" id="input-jumlah" value="1" type="text">
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
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.quick-view').click(function() {
                var id = $(this).data('id');

                $.ajax({
                    url: 'get-produk.php',
                    type: 'GET',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#modal-nama-produk').text(data.nm_produk);
                        $('#modal-kategori').text(data.nm_kategori);
                        $('#modal-harga').text('Rp' + parseInt(data.harga).toLocaleString('id-ID'));
                        $('#modal-desk').text(data.desk);
                        $('#modal-gambar').attr('src', 'admin/produk_img/' + data.gambar);
                        $('#modal-stok').text(data.stok);

                        // Set hidden form fields
                        $('#input-id-produk').val(data.id_produk);
                        $('#input-harga').val(data.harga);

                        // Reset jumlah
                        $('#input-jumlah').val(1);

                        // Tampilkan modal
                        $('#exampleModalCenter').modal('show');
                    },
                    error: function() {
                        alert('Gagal mengambil data produk.');
                    }
                });
            });
        });
    </script>


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

<!-- shop-list31:48-->

</html>