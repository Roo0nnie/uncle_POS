<?php
include './php/db_conn.php';
session_start();

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
      href="assets/img/admin/favicon.ico"
      type="image/x-icon"
    />
    
          <!-- Ensure Bootstrap and DataTables CSS are included -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">

    <style>
    #multi-filter-select {
        width: 100%;
        table-layout: fixed;
    }
    #multi-filter-select th {
        width: 120px;
        max-width: 120px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

        /* Custom styling for layout */
        .dataTables_wrapper .top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .dataTables_wrapper .dataTables_filter {
        text-align: left;
        flex-grow: 1;
    }

    .dataTables_wrapper .dt-buttons {
        text-align: right;
    }

    /* Ensure the search bar doesn't take too much space */
    .dataTables_wrapper .dataTables_filter input {
        width: 200px; /* Adjust as needed */
    }
    </style>

    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
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
          urls: ["assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/plugins.min.css" />
    <link rel="stylesheet" href="assets/css/admin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="assets/css/demo.css" />
  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="dashboard.php" class="logo">
              <img
                src="assets/img/admin/logo_light.svg"
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
                <a href="dashboard.php">
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
                <a href="user.php">
                <i class="fas fa-user"></i>
                  <p>Users</p>
                </a>
              </li>
              <li class="nav-item ">
                <a href="product.php">
                  <i class="fas fa-boxes"></i>
                  <p>Products</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="category.php">
                <i class="fas fa-folder"></i>  
                  <p>Categories</p>
                </a>
              </li>
             
              <li class="nav-item">
                <a href="orders.php">
                  <i class="fas fa-shopping-cart"></i>
                  <p>Orders</p>
                </a>
              </li>

              <li class="nav-item ">
                <a href="vat.php">
                <i class="fas fa-file-invoice-dollar"></i>
                  <p>Vats</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="discount.php">
                <i class="fas fa-percentage"></i>
                  <p>Discounts</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="supplier.php">
                  <i class="fas fa-boxes"></i>
                  <p>Suppliers</p>
                </a>
              </li>
              <li class="nav-item">
                <a  href="delivery.php">
                  <i class="fas fa-truck"></i>
                  <p>Delivery</p>
                </a>
              </li>
              <li class="nav-item active">
                <a  href="inventory.php">
                  <i class="fas fa-boxes"></i>
                  <p>Inventory</p>
                </a>
              </li>
              <li class="nav-item">
                <a  href="sales.php">
                  <i class="fas fa-receipt"></i>
                  <p>Sales</p>
                </a>
              </li>
              <li class="nav-item">
                <a  href="reports.php">
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
              <a href="dashboard.php" class="logo">
                <img
                  src="assets/img/admin/logo_light.svg"
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
          <?php include 'nav.php'; ?>
          <!-- End Navbar -->
        </div>

        <div class="container">
          <div class="page-inner">
          <?php
            if (isset($_SESSION['error_message'])) {
                echo "<p>" . $_SESSION['error_message'] . "</p>";
                unset($_SESSION['error_message']); 
            }
          ?>
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
              <div>
                <h3 class="fw-bold mb-3">Inventory Section</h3>
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
                      <a href="#">Inventory</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Inventory</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="multi-filter-select" class="display table table-striped table-hover">
                      <thead>
                          <tr>
                            <th>Supplier</th>
                            <th>Trans ID</th>
                            <th>Delivery Date</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Cost Price</th>
                            <th>Selling </th>
                       
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                            $sql = "Select * from `product` WHERE sup_id IS NOT NULL";

                            $result = mysqli_query($conn, $sql);
                            $id_loop = 0;
                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id = $row['id'];
                                    $sup_id = $row['sup_id'];
                                    $trans_id = $row['trans_id'];
                                    $del_date = $row['del_date'];
                                    $prod_name = $row['prod_name'];
                                    $prod_category = $row['prod_category'];
                                    $prod_quantity = $row['prod_quantity'];
                                    $prod_price = $row['prod_price'];
                                    $prod_orig_price = $row['orig_price'];
                                    $prod_vat_price = $row['vat_percent'];
                                    $id_loop += 1;

                                    $sql_supplier = "SELECT * FROM `supplier` WHERE id = $sup_id";
                                    $result_supplier = mysqli_query($conn, $sql_supplier);
                                    $row_supplier = mysqli_fetch_assoc($result_supplier);

                                    $sql_category = "SELECT * FROM `category` WHERE id = $prod_category";
                                    $result_category = mysqli_query($conn, $sql_category);
                                    $row_category = mysqli_fetch_assoc($result_category);

                                    echo '<tr>
                                    <td>' . $row_supplier['sup_name'] . '</td>
                                    <td>' . $trans_id . '</td>
                                    <td>' . $del_date . '</td>
                                    <td>' . $prod_name . '</td>
                                    <td>'. $row_category['name'] .'</td>
                                    <td>'. $prod_quantity .'</td>
                                    <td>'. $prod_orig_price .'</td>
                                    <td>'. $prod_price .'</td>
                                    <td>
                                        <a href="./inventory/inventory_edit.php?id='. $id .'" class="btn btn-warning btn-sm">Edit Stock</a>
                                    </td>
                                </tr>';
                            ?>
                            <?php
                                }
                            }
                            ?>  
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
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
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="assets/js/plugin/jsvectormap/world.js"></script>

    <!-- Sweet Alert -->
    <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <script src="assets/js/admin.min.js"></script>

    <script src="assets/js/setting-demo.js"></script>
    <script src="assets/js/demo.js"></script>
    <!-- Include jQuery, DataTables, and Buttons JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script>

      
      $("#multi-filter-select").DataTable({
          pageLength: 5,
          
        });
    </script>
  </body>
</html>

<?php
} else {
    header("Location: index.php");
    exit();
}
?>
