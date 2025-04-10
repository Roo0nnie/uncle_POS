<?php
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function handleDatabaseError($conn, $query) {
    error_log("Database error in $query: " . mysqli_error($conn));
    die("A database error occurred. Please contact support.");
}

include './php/db_conn.php';
session_start();

if (!isset($_SESSION['id']) || !isset($_SESSION['name'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Inventory System - Sales</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="assets/img/admin/favicon.ico"
      type="image/x-icon"
    />

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
    <link rel="stylesheet" href="assets/css/demo.css" />
  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
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
        </div>


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
              <li class="nav-item">
                <a href="product.php">
                  <i class="fas fa-boxes"></i>
                  <p>Products</p>
                </a>
              </li>

              <li class="nav-item ">
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
              <li class="nav-item active">
                <a  href="sales.php">
                  <i class="fas fa-clipboard-list"></i>
                  <p>Sales</p>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->
      </div>

      <div class="main-panel">
        <div class="main-header">
          <?php include 'nav.php'; ?>
        </div>

        <div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Sales</h3>
                <div class="page-header">
                    <ul class="breadcrumbs mb-3">
                        <li class="nav-home">
                            <a href="#"><i class="icon-home"></i></a>
                        </li>
                        <li class="separator">
                            <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">Sales</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <?php
        $today = date('Y-m-d');

        $sql = "
          SELECT 
    c.trans_id AS 'Transaction ID',
    c.date AS 'Sale Date',
    CONCAT(c.firstname, ' ', COALESCE(c.lastname, '')) AS 'Customer Name',
    c.pay_method AS 'Payment Method',
    p.prod_name AS 'Product Name',
    o.order_quantity AS 'Quantity Sold',
    COALESCE(o.order_price, 0) AS 'Unit Price',  -- Prevent null
    COALESCE(o.order_quantity * o.order_price, 0) AS 'Subtotal',  -- Prevent null
    cat.name AS 'Category',
    COALESCE(c.discount, 0) AS 'Discount Applied',  -- Prevent null
    COALESCE(p.vat_percent, 0) AS 'VAT Percent',  -- Prevent null
    COALESCE((o.order_quantity * o.order_price) * (p.vat_percent / 100), 0) AS 'VAT Amount',  -- Prevent null
    COALESCE(c.total_price, 0) AS 'Total Price',  -- Prevent null
    COALESCE(c.cus_payment, 0) AS 'Customer Payment',  -- Prevent null
    COALESCE(c.cus_payment - c.total_price, 0) AS 'Change',  -- Prevent null
    c.status AS 'Status'
FROM 
    customer c
    INNER JOIN `order` o ON c.id = o.cust_id
    INNER JOIN product p ON o.prod_id = p.id
    INNER JOIN category cat ON p.prod_category = cat.id
WHERE 
    c.status = 'Done'
ORDER BY 
    c.date DESC, c.trans_id;
        ";

        $result = mysqli_query($conn, $sql);

        if (!$result) {
            handleDatabaseError($conn, $sql);
        }

        $total_sales = 0;
        $highest_sale = 0;
        $lowest_sale = PHP_FLOAT_MAX;
        $transaction_count = 0;
        $unique_transactions = [];

        while ($row = mysqli_fetch_assoc($result)) {
            if (!isset($unique_transactions[$row['Transaction ID']])) {
                $unique_transactions[$row['Transaction ID']] = $row['Total Price'];
                $total_sales += $row['Total Price'];
                $highest_sale = max($highest_sale, $row['Total Price']);
                $lowest_sale = min($lowest_sale, $row['Total Price']);
                $transaction_count++;
            }
        }
        if ($transaction_count == 0) {
            $lowest_sale = 0;
        }
        ?>

        <div class="row">
            <div class="col-sm-6 col-md-4">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-arrow-up"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Highest Sale</p>
                                    <h4 class="card-title"><?php echo number_format($highest_sale, 2); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-arrow-down"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Lowest Sale</p>
                                    <h4 class="card-title"><?php echo number_format($lowest_sale, 2); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Sales</p>
                                    <h4 class="card-title"><?php echo number_format($total_sales, 2); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Sales</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="multi-filter-select" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Trans ID</th>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th>Method</th>
                                        <th>Product</th>
                                        <th>Sold</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                        <th>Category</th>
                                        <th>Discount</th>
                                        <th>VAT Percent</th>
                                        <th>VAT Amount</th>
                                        <th>Total Price</th>
                                        <th>Payment</th>
                                        <th>Change</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    mysqli_data_seek($result, 0);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<tr>
                                            <td>' . sanitizeInput($row['Transaction ID']) . '</td>
                                            <td>' . sanitizeInput($row['Sale Date']) . '</td>
                                            <td>' . sanitizeInput($row['Customer Name']) . '</td>
                                            <td>' . sanitizeInput($row['Payment Method']) . '</td>
                                            <td>' . sanitizeInput($row['Product Name']) . '</td>
                                            <td>' . $row['Quantity Sold'] . '</td>
                                            <td>' . number_format($row['Unit Price'], 2) . '</td>
                                            <td>' . number_format($row['Subtotal'], 2) . '</td>
                                            <td>' . sanitizeInput($row['Category']) . '</td>
                                            <td>' . number_format($row['Discount Applied'], 2) . '</td>
                                            <td>' . number_format($row['VAT Percent'], 2) . '</td>
                                            <td>' . number_format($row['VAT Amount'], 2) . '</td>
                                            <td>' . number_format($row['Total Price'], 2) . '</td>
                                            <td>' . number_format($row['Customer Payment'], 2) . '</td>
                                            <td>' . number_format($row['Change'], 2) . '</td>
                                            <td>' . sanitizeInput($row['Status']) . '</td>
                                        </tr>';
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
            <div class="copyright">© <?php echo date('Y'); ?> Inventory System</div>
          </div>
        </footer>
      </div>
    </div>

    <!-- JS Files -->
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script src="assets/js/plugin/chart.js/chart.min.js"></script>
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>
    <script src="assets/js/admin.min.js"></script>


    <script>
      $(document).ready(function() {
    $('#multi-filter-select').DataTable({
          pageLength: 5,
        });
      });
    </script>
  </body>
</html>
<?php
mysqli_close($conn);
?>