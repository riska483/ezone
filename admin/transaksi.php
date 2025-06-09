<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['status']) || $_SESSION['status'] !== 'admin') {
    echo "<script>alert('Anda tidak memiliki akses sebagai admin');</script>";
    header("Location: login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Transaksi - ezone Admin</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.php" class="logo d-flex align-items-center">
                <img src="assets/img/logo.png" alt="">
                <span class="d-none d-lg-block">ezone</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->


        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="assets/img/2.jpg" alt="Profile" class="rounded-circle">
                        <!-- profile-img.jpg diganti dengan foto kalian -->
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?php echo ($_SESSION['username']) ? htmlspecialchars(($_SESSION['username'])) : 'Guest'; ?></h6>
                            <span>Admin</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="logout.php">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="index.php">
          <i class="bi bi-grid"></i>
          <span>Beranda</span>
        </a>
      </li><!-- End Beranda Nav -->


      <li class="nav-item">
        <a class="nav-link collapsed" href="kategori.php">
        <i class="bi bi-list-task"></i>
          <span>Kategori Produk</span>
        </a>
      </li><!-- End Kategori Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="produk.php">
          <i class="bi bi-bag-heart"></i>
          <span>Produk</span>
        </a>
      </li><!-- End Produk Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="keranjang.php">
          <i class="bi bi-cart"></i>
          <span>Keranjang</span>
        </a>
      </li><!-- End Keranjang Page Nav -->

      <li class="nav-item">
        <a class="nav-link" href="transaksi.php">
          <i class="bi bi-cash"></i>
          <span>Transaksi</span>
        </a>
      </li><!-- End Transaksi Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="laporan.php">
          <i class="bi bi-clipboard-data"></i>
          <span>Laporan</span>
        </a>
      </li><!-- End Laporan Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pengguna.php">
          <i class="bi bi-person"></i>
          <span>Pengguna</span>
        </a>
      </li><!-- End pengguna Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Transaksi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                    <li class="breadcrumb-item active">Transaksi</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <?php
        include 'koneksi.php';

        // Ambil kategori dari database untuk dropdown filter
        $sql_kategori = "SELECT id_kategori, nm_kategori FROM tb_kategori";
        $result_kategori = $koneksi->query($sql_kategori);
        
        $kategori_filter = isset($_GET['kategori']) ? $_GET['kategori'] : "";

        // Query untuk mengambil data penjualan dengan filter kategori jika ada
        $sql = "SELECT j.id_jual, u.username, j.tgl_jual, j.total, j.diskon 
        FROM tb_jual j 
        JOIN tb_user u ON j.id_user = u.id_user";

if (!empty($kategori_filter)) {
    $sql .= " JOIN tb_jualdtl jd ON j.id_jual = jd.id_jual 
              JOIN tb_produk p ON jd.id_produk = p.id_produk 
              WHERE p.id_kategori = '$kategori_filter'";
        }

        $sql .= " GROUP BY j.id_jual ORDER BY j.tgl_jual ASC";
        $result = $koneksi->query($sql);
        ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="filter-bar mt-3">
                            <form class="filter-form d-flex align-items-center" method="GET" action="">
                                <select name="kategori" class="form-select me-2" style="max-width: 200px;
                                " title="Pilih kategori">
                                    <option value="">-- Semua Kategori --</option>
                                    <?php
                                    if ($result_kategori->num_rows > 0) {
                                        while ($row = $result_kategori->fetch_assoc()) {
                                            $selected = ($kategori_filter == $row['id_kategori']) ? 
                                            "selected" : "";
                                            echo "<option value='" . $row['id_kategori'] . "'
                                            $selected>" . htmlspecialchars($row['nm_kategori']) . "</
                                            option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <button type="submit" class="btn btn-primary ms-2">Filter</button>
                            </form>
                        </div><!-- End Filter Bar -->
                    </div>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped mt-2">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Kode Belanja</th>
                                        <th scope="col">Pengguna</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Total Bayar</th>
                                        <th scope="col">Diskon</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $no++ . "</td>";
                                            echo "<td>" . $row["id_jual"] . "</td>";
                                            echo "<td>" . $row["username"] . "</td>";
                                            echo "<td>" . date("d-m-Y H:i:s", strtotime($row["tgl_jual"])) . "</td>";
                                            echo "<td>Rp " . number_format($row["total"], 0, ",", ".") . "</td>";
                                            echo "<td>Rp " . number_format($row["diskon"], 0, ",", ".") . "</td>";
                                            echo "<td>
                                            <a href='detail_jual.php?id=" . $row["id_jual"] . "' class='btn btn-info btn-sm'>Detail</a>
                                          </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='7' class='text-center'>Belum ada data penjualan</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>ezone</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            Designed by <a href="https://www.instagram.com/rskaaadr">Riska Andriani</a>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>