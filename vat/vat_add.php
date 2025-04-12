<?php
include '../php/db_conn.php';
session_start();

  if(isset($_POST['submit'])) {

    $vat_name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $vat_vat = mysqli_real_escape_string($conn, trim($_POST['vat']));
    $vat_description = mysqli_real_escape_string($conn, trim($_POST['description']));

      if(!empty($vat_name) && !empty($vat_vat) && !empty($vat_description)) {

        $check_sql = "SELECT * FROM `vat` WHERE name = '$vat_name'";
        $check_result = mysqli_query($conn, $check_sql);

        if ($check_result && mysqli_num_rows($check_result) == 0) { 

          $sql = "INSERT INTO vat (name, vat, description, created_at) VALUES ('$vat_name', '$vat_vat', '$vat_description', NOW())";
        
          if (mysqli_query($conn, $sql)) {
            $_SESSION['error_message'] = "Added successfully.";
            header("Location: ../vat.php");
            exit();
          } else {
            $_SESSION['error_message'] = "Failed to add VAT.";
            header("Location: ./vat_add.php");
            exit();
          }

        } else {
          $_SESSION['error_message'] = "VAT already exists.";
          header("Location: ./vat_add.php");
          exit();
      }
    } else {
      $_SESSION['error_message'] = "All fields are required";
      header("Location: ./vat_add.php");
      exit();
  }
  mysqli_close($conn);
}

if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Inventory System</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="../assets/img/admin/favicon.ico"
      type="image/x-icon"
    />

    <!-- Fonts and icons -->
    <script src="../assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["../assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/plugins.min.css" />
    <link rel="stylesheet" href="../assets/css/admin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="../assets/css/demo.css" />
  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="../dashboard.php" class="logo">
              <img
                src="../assets/img/admin/logo_light.svg"
                alt="navbar brand"
                class="navbar-brand"
                height="20"
              />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item">
                <a href="../dashboard.php">
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Components</h4>
              </li>
              <li class="nav-item ">
                <a href="../user.php">
                <i class="fas fa-user"></i>
                  <p>Users</p>
                </a>
              </li>
              <li class="nav-item ">
                <a href="../product.php">
                  <i class="fas fa-boxes"></i>
                  <p>Products</p>
                </a>
              </li>

              <li class="nav-item ">
                <a href="../category.php">
                <i class="fas fa-folder"></i>  
                  <p>Categories</p>
                </a>
              </li>
             
              <li class="nav-item ">
                <a href="../orders.php">
                  <i class="fas fa-shopping-cart"></i>
                  <p>Orders</p>
                </a>
              </li>

              <li class="nav-item active">
                <a href="../vat.php">
                <i class="fas fa-file-invoice-dollar"></i>
                  <p>Vats</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="../discount.php">
                <i class="fas fa-percentage"></i>
                  <p>Discounts</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../supplier.php">
                  <i class="fas fa-boxes"></i>
                  <p>Suppliers</p>
                </a>
              </li>
              <li class="nav-item ">
                <a  href="../delivery.php">
                  <i class="fas fa-truck"></i>
                  <p>Delivery</p>
                </a>
              </li>
              <li class="nav-item ">
                <a  href="../inventory.php">
                  <i class="fas fa-boxes"></i>
                  <p>Inventory</p>
                </a>
              </li>
              <li class="nav-item">
                <a  href="../sales.php">
                  <i class="fas fa-receipt"></i>
                  <p>Sales</p>
                </a>
              </li>
              <li class="nav-item">
                <a  href="../reports.php">
                  <i class="fas fa-clipboard-list"></i>
                  <p>Reports</p>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
              <a href="../dashboard.php" class="logo">
                <img
                  src="../assets/img/admin/logo_light.svg"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="20"
                />
              </a>
              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                  <i class="gg-menu-left"></i>
                </button>
              </div>
              <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
              </button>
            </div>
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
          <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
            <div class="container-fluid">
              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li class="nav-item topbar-user dropdown hidden-caret">
                  <a
                    class="dropdown-toggle profile-pic"
                    data-bs-toggle="dropdown"
                    href="#"
                    aria-expanded="false"
                  >
                    <div class="avatar-sm">
                      <img
                        src="../assets/img/profile.png"
                        alt="..."
                        class="avatar-img rounded-circle"
                      />
                    </div>
                    <span class="profile-username">
                    <span class="fw-bold"><?php print $_SESSION['name'] ?> <?php print $_SESSION['last_name'] ?></span>
                    </span>
                  </a>
                  <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                      <li>
                        <div class="user-box">
                          <div class="avatar-lg">
                            <img
                              src="assets/img/profile.jpg"
                              alt="image profile"
                              class="avatar-img rounded"
                            />
                          </div>
                          <div class="u-text">
                          <span class="fw-bold"><?php print $_SESSION['name'] ?> <?php print $_SESSION['last_name'] ?></span>
                            <p class="text-muted">sample@gmail.com</p>
                          
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../index.php">Logout</a>
                      </li>
                    </div>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
          <!-- End Navbar -->
        </div>

        <div class="container">
          <div class="page-inner">
          <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
              <div>
                <h3 class="fw-bold mb-3">Add VAT  </h3>
                <div class="page-header">
                  <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                      <a href="#">
                        <i class="icon-home"></i>
                      </a>
                    </li>
                    <li class="separator">
                      <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                      <a href="#">VAT</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                      </li>
                      <li class="nav-item">
                        <a href="#">Add VAT</a>
                      </li>
                  </ul>
                </div>
              </div>
            </div>
            <form action="" method="post">
                <?php
                if (isset($_SESSION['error_message'])) {
                    echo "<p>" . $_SESSION['error_message'] . "</p>";
                    unset($_SESSION['error_message']); 
                }
                ?>
              <div class="row">
                <div class="col-sm-12 col-md-12">
                  <div class="card card-stats card-round">
                    <div class="card-body">
                      <div class="row align-items-center">
                          <p class="card-category">VAT Information</p>
                        <div class="col-sm-12 col-md-12 ms-3 ms-sm-0">
                          <div class="numbers">
                              <div class="mt-4">
                                  <h4 class="card-title">VAT Name</h4>
                                  <div class="form-floating">
                                      <input type="text" name="name" class="form-control" placeholder="VAT name" required>
                                      <label for="floatingTextarea2">Name</label>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <div class="col-sm-12 col-md-12 ms-3 ms-sm-0">
                          <div class="numbers">
                              <div class="mt-4">
                                  <h4 class="card-title">Description</h4>
                                  <div class="form-floating">
                                      <textarea class="form-control" name="description" placeholder="Description" id="floatingTextarea2" style="height: 100px" required></textarea>
                                      <label for="floatingTextarea2">Describe your VAT</label>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <div class="col-sm-12 col-md-12 ms-3 ms-sm-0">
                          <div class="numbers">
                              <div class="mt-4">
                                  <h4 class="card-title">VAT</h4>
                                  <div class="form-floating">
                                      <input type="number" class="form-control" name="vat" placeholder="VAT" id="floatingTextarea2" style="height: 100px" required>
                                      <label for="floatingTextarea2">0.00</label>
                                  </div>
                              </div>
                          </div>
                        </div>
                      </div>
                  </div>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                  <button type="submit" name="submit" class="btn btn-primary">
                      <i class="fas fa-cart-plus"></i> Add VAT
                  </button>
                  <a href="../vat.php" class="btn btn-secondary ">Back</a>
              </div>
            </form>
            </div>
          </div>
        </div>
      </div>

        <footer class="footer">
          <div class="container-fluid d-flex justify-content-between">
            <nav class="pull-left">
              <ul class="nav">
              </ul>
            </nav>
            <div class="copyright">
            </div>
            <div>
            </div>
          </div>
        </footer>
      </div>

      <!-- End Custom template -->
    </div>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="../assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="../assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="../assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="../assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="../assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="../assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="../assets/js/plugin/jsvectormap/world.js"></script>

    <!-- Sweet Alert -->
    <script src="../assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <script src="../assets/js/admin.min.js"></script>

    <script src="../assets/js/setting-demo.js"></script>
    <script src="../assets/js/demo.js"></script>
  </body>
</html>
<?php
} else {
    header("Location: index.php");
    exit();
}
?>