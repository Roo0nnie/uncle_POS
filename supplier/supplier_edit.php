<?php
include '../php/db_conn.php';
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  if(isset($_GET['id'])){

    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql_supplier = "SELECT * FROM `supplier` WHERE id = '$id'";
    $result_supplier = mysqli_query($conn, $sql_supplier);

    if ($result_supplier && mysqli_num_rows($result_supplier) > 0) {

        $row_supplier = mysqli_fetch_assoc($result_supplier);
        $edit_id = $row_supplier['id'];
        $edit_name = $row_supplier['sup_name'];
        $edit_phone = $row_supplier['phone'];
        $edit_remark = $row_supplier['remark'];
        $edit_status = $row_supplier['status'];
        $edit_created = $row_supplier['created_at'];
        $edit_updated = $row_supplier['updated_at'];

    } else {
      $_SESSION['error_message'] = "No category id found!.";
      header("Location: ../category.php");
      exit();
    }
} else {
  $_SESSION['error_message'] = "No ID provided in the URL.";
  header("Location: ../category.php");
  exit();
}

if(isset($_POST['submit'])){
  
    $sup_id = mysqli_real_escape_string($conn, trim($_POST['id']));
    $sup_name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $sup_phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $sup_remark = mysqli_real_escape_string($conn, trim($_POST['remark']));
    $sup_status = mysqli_real_escape_string($conn, trim($_POST['status']));

    $sql_supplier = "UPDATE supplier SET 
    sup_name = '$sup_name',
    phone = '$sup_phone',
    remark = '$sup_remark',
    status = '$sup_status', ";

    $sql_supplier .= "updated_at = now()
        WHERE id = '$sup_id'";

  if(mysqli_query($conn, $sql_supplier)){
    $_SESSION['error_message'] = "Updated supplier successfully!.";
    header("Location: ../supplier.php");
    exit();
  } else {
    $_SESSION['error_message'] = "Could not update record: ". mysqli_error($conn);
    header("Location: ../supplier.php");
    exit();
  }
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Inventory System</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="editport"
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
              <li class="nav-item">
                <a href="../product.php">
                  <i class="fas fa-boxes"></i>
                  <p>Products</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="../category.php">
                <i class="fas fa-folder"></i>  
                  <p>Categories</p>
                </a>
              </li>
             
              <li class="nav-item">
                <a href="../orders.php">
                  <i class="fas fa-shopping-cart"></i>
                  <p>Orders</p>
                </a>
              </li>

              <li class="nav-item ">
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
              <li class="nav-item active">
                <a href="../supplier.php">
                  <i class="fas fa-boxes"></i>
                  <p>Suppliers</p>
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
                      <span class="fw-bold">Admin</span>
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
                            <h4>Admin</h4>
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
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between pt-2 pb-4">
              <div>
                <h3 class="fw-bold mb-3">Edit supplier</h3>
                <div class="page-header">
                  <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                      <a href="#"><i class="icon-home"></i></a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item">
                      <a href="#">supplier</a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item">
                      <a href="#">Edit supplier</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>

            <form action="" method="post">
              <input type="hidden" value="<?php print $edit_id; ?>" name="id">
              <div class="row">
                <div class="col-12">
                  <div class="card card-stats card-round">
                    <div class="card-body">
                      <p class="card-category fw-bold">supplier Information</p>

                      <div class="row g-3">
                        <div class="col-sm-12 col-md-6">
                          <div class="mb-4">
                            <h4 class="card-title">Supplier Name</h4>
                            <input type="text" class="form-control" name="name" placeholder="supplier name" value="<?php print $edit_name; ?>">
                          </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                          <div class="mb-4">
                          <h4 class="card-title">Quantity</h4>
                          <input type="text" class="form-control" name="phone" value="<?php print $edit_phone; ?>">
                          </div>
                        </div>
                      </div>

                      <div class="row g-3">
                        <div class="col-sm-12 col-md-6">
                          <div class="mb-4">
                            <h4 class="card-title">Status</h4>
                            <select name="status" class="form-control">
                              <option value="Active" <?php echo ($edit_status == 'Active') ? 'selected' : ''; ?>>Active</option>
                              <option value="Inactive" <?php echo ($edit_status == 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                          <div class="mb-4">
                            <h4 class="card-title">Remark</h4>
                            <textarea class="form-control" name="remark"><?php echo htmlspecialchars($edit_remark); ?></textarea>
                          </div>
                        </div>
                      </div>
                                  
                      <div class="row g-3">
                        <div class="col-sm-12 col-md-6">
                          <div class="mb-4">
                            <h4 class="card-title">Created</h4>
                            <input type="datetime" class="form-control" value="<?php echo $edit_created; ?>" readonly>
                          </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                          <div class="mb-4">
                            <h4 class="card-title">Updated</h4>
                            <input type="datetime" class="form-control" value="<?php echo $edit_updated; ?>" readonly>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>

              <div class="text-start mt-3">
                  <div class="ms-md-auto py-2 py-md-0">
                    <button type="submit" name="submit" class="btn btn-primary ">
                        <i class="fas fa-cart-plus"></i> Update supplier
                    </button>
                    <a href="../supplier.php" class="btn btn-secondary ">Back</a>
                      </div>
                  </div>
              </div>
            </form>
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
  $_SESSION['error_message'] = "You have to login first.";
  header("Location: ../index.php");
  exit();
}
?>