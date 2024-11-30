<?php
include './php/db_conn.php';
session_start();

function sanitizeInput($data) {
  return htmlspecialchars(stripslashes(trim($data)));
}

function handleDatabaseError($conn, $query) {
  error_log("Database error in $query: " . mysqli_error($conn));
  die("A database error occurred. Please contact support.");
}

if (isset($_SESSION['id']) && isset($_SESSION['name']) && isset($_SESSION['last_name'])) {
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
      href="./assets/img/admin/favicon.ico"
      type="image/x-icon"
    />

    <!-- Fonts and icons -->
    <script src="./assets/js/plugin/webfont/webfont.min.js"></script>
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
              <li class="nav-item active">
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
              <li class="nav-item">
                <a href="product.php">
                  <i class="fas fa-boxes"></i>
                  <p>Product</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="category.php">
                  <i class="fas fa-tags"></i>
                  <p>Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="orders.php">
                  <i class="fas fa-shopping-cart"></i>
                  <p>Orders</p>
                </a>
              </li>
              <li class="nav-item">
                <a  href="reports.php">
                  <i class="fas fa-store"></i>
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
                  src="./assets/img/admin/logo_light.svg"
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
            <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
              <div>
                <h3 class="fw-bold mb-3">Dashboard</h3>
                <h6 class="op-7 mb-2">Overview of product System</h6>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card card-transparent card-round">
                  <div class="card-body pb-0">
                    <div class="row">
                      <div class="card-title">Stock Level</div>
                      <div class="col-sm-12 col-md-4">
                        <div class="card-body">
                          <div class="chart-container">
                            <canvas
                              id="doughnutChart"
                              style="width: 50%; height: 50%"
                            ></canvas>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-4">
                        <div class="container">
                            <div class="d-flex justify-content-center flex-column">
                                <?php
                                $sql = "SELECT * FROM `product`";
                                $result = mysqli_query($conn, $sql);

                                $highStock = 0;
                                $lowStock = 0;
                                $outOfStock = 0;

                                if ($result) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        if ($row['prod_quantity'] > 50) { 
                                            $highStock++;
                                        } elseif ($row['prod_quantity'] > 0) {
                                            $lowStock++;
                                        } else {
                                            $outOfStock++;
                                        }
                                    }
                                }

                                $chartData = [
                                  'highStock' => $highStock,
                                  'lowStock' => $lowStock,
                                  'outOfStock' => $outOfStock,
                                ];
                                
                                $totalProducts = $highStock + $lowStock + $outOfStock;

                                $highStockPercentage = $totalProducts > 0 ? ($highStock / $totalProducts) * 100 : 0;
                                $lowStockPercentage = $totalProducts > 0 ? ($lowStock / $totalProducts) * 100 : 0;
                                $outOfStockPercentage = $totalProducts > 0 ? ($outOfStock / $totalProducts) * 100 : 0;
                                ?>

                                <div class="mt-4">
                                    <div class="card-title">High Stock Items</div>
                                    <div class="progress" style="height: 20px">
                                        <div class="progress-bar bg-success" style="width: <?= $highStockPercentage; ?>%"></div>
                                    </div>
                                    <div class="card-category"><?= $highStock; ?> Products</div>
                                </div>

                                <div class="mt-4">
                                    <div class="card-title">Low Stock Items</div>
                                    <div class="progress" style="height: 20px">
                                        <div class="progress-bar bg-warning" style="width: <?= $lowStockPercentage; ?>%"></div>
                                    </div>
                                    <div class="card-category"><?= $lowStock; ?> Products</div>
                                </div>

                                <div class="mt-4">
                                    <div class="card-title">Out of Stock Items</div>
                                    <div class="progress" style="height: 20px">
                                        <div class="progress-bar bg-danger" style="width: <?= $outOfStockPercentage; ?>%"></div>
                                    </div>
                                    <div class="card-category"><?= $outOfStock; ?> Products</div>
                                </div>
                            </div>
                        </div>
                   
                      </div>
                      
                      <div class="col-sm-12 col-md-4">
                        <div class="container">
                          <div class="card card-primary card-round">
                            <div class="card-body pb-0">
                            <div class="card-title">Monthly Sales</div>
                                <?php 
                                  $startDate = date('Y-m-01');
                                  $endDate = date('Y-m-t');
                                ?>
                                <div class="card-category"><?php echo $startDate ."  -  ". $endDate; ?></div>
                                <div class="mb-4 mt-2">

                                <?php 
                                    $sql = "SELECT * FROM `customer` WHERE `created_at` BETWEEN '$startDate' AND '$endDate' ORDER BY `created_at`";   
                                    $result = mysqli_query($conn, $sql);
                                    $totalSales = 0;
                                    
                                    if ($result) {
                                      while ($row = mysqli_fetch_assoc($result)) {
                                          $totalSales += $row['total_price'];
                                      }
                                  }

                                  $monthlySale = [
                                    'monthlySale' => $totalSales,
                                  ];
                                
                                ?>
                                <h1><?php echo $totalSales; ?></h1>
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

            <div class="row">
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-primary bubble-shadow-small"
                        >
                          <i class="fas fa-hourglass-half"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                        <?php
                          $expiryQuery = "SELECT COUNT(*) as expiring_supplies FROM product WHERE prod_expiry BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)";
                          $expiryResult = mysqli_query($conn, $expiryQuery);
                          $expiryCount = mysqli_fetch_assoc($expiryResult)['expiring_supplies'];

                          $expiredQuery = "SELECT COUNT(*) as expired_supplies FROM product WHERE prod_expiry < CURDATE()";
                          $expiredResult = mysqli_query($conn, $expiredQuery);
                          $expiredCount = mysqli_fetch_assoc($expiredResult)['expired_supplies'];

                          $deliveryQuery = "SELECT COUNT(*) as recent_deliveries FROM customer WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
                          $deliveryResult = mysqli_query($conn, $deliveryQuery);
                          $recentDeliveries = mysqli_fetch_assoc($deliveryResult)['recent_deliveries'];

                          $orderQuery = "SELECT COUNT(*) as total_orders FROM customer";
                          $orderResult = mysqli_query($conn, $orderQuery);
                          $totalOrders = mysqli_fetch_assoc($orderResult)['total_orders'];
                          ?>
                          <p class="card-category">Supplies Close To Expiry</p>
                          <h4 class="card-title"><?= number_format($expiryCount); ?></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-info bubble-shadow-small"
                        >
                          <i class="fas fa-exclamation-circle"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Supplies Expired</p>
                          <h4 class="card-title"><?= number_format($expiredCount); ?></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-success bubble-shadow-small"
                        >
                          <i class="fas fa-truck"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Recent Deliveries</p>
                          <h4 class="card-title"><?= number_format($recentDeliveries); ?></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-secondary bubble-shadow-small"
                        >
                          <i class="far fa-check-circle"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Order</p>
                          <h4 class="card-title"><?= number_format($totalOrders); ?></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="card card-round">
                  <div class="card-header">
                    <div class="card-head-row">
                      <div class="card-title">Sales Trend</div>
                      
                    </div>
                  </div>

                  <?php
                  $sql = "
                      SELECT 
                          p.id, 
                          p.prod_name, 
                          c.name AS category_name, 
                          p.prod_quantity AS stock_quantity,
                          p.prod_price,
                          COALESCE(SUM(o.order_quantity), 0) AS total_sold_quantity,
                          COALESCE(SUM(o.order_price * o.order_quantity), 0) AS total_sales_value,
                          ROUND(COALESCE(SUM(o.order_price * o.order_quantity * 0.2), 0), 2) AS estimated_revenue
                      FROM product p
                      LEFT JOIN category c ON p.prod_category = c.id
                      LEFT JOIN `order` o ON p.id = o.prod_id
                      GROUP BY p.id
                  ";
                  
                  $result = mysqli_query($conn, $sql);
                  
                  if (!$result) {
                      handleDatabaseError($conn, $sql);
                  }

                  $product_revenue = [];
                  $highest_sale = 0;
                  $lowest_sale = PHP_FLOAT_MAX;

                  // Process query results
                  while ($row = mysqli_fetch_assoc($result)) {
                      $product_sale[] = [
                          'name' => sanitizeInput($row['prod_name']),
                          'revenue' => $row['total_sales_value']
                      ];

                      $highest_sale = max($highest_sale, $row['total_sales_value']);
                      $lowest_sale = min($lowest_sale, $row['total_sales_value']);
                  }
                  ?>

                  
                  <div class="card-body">
                    <div class="chart-container">
                      <canvas id="lineChart"></canvas>
                    </div>
                  </div>



                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6 col-md-6">
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
                          <p class="card-category">Highest Product Sales</p>
                          <h4 class="card-title">$ <?php echo number_format($highest_sale, 2); ?></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-6">
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
                          <p class="card-category">Lowest Product Sales</p>
                          <h4 class="card-title">$ <?php echo number_format($lowest_sale, 2); ?></h4>
                        </div>
                      </div>
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
    <script>

      const chartData = <?= json_encode($chartData); ?>;

      const doughnutChart = document.getElementById("doughnutChart").getContext("2d");
      const myDoughnutChart = new Chart(doughnutChart, {
          type: "doughnut",
          data: {
              datasets: [
                  {
                      data: [chartData.highStock, chartData.lowStock, chartData.outOfStock],
                      backgroundColor: ["#31CE36", "#FFAD46", "#dc3545"], 
                  },
              ],
              labels: ["High Stock", "Low Stock", "Out of Stock"], 
          },
          options: {
              responsive: true,
              maintainAspectRatio: false,
              legend: {
                  position: "bottom",
              },
              layout: {
                  padding: {
                      left: 20,
                      right: 20,
                      top: 20,
                      bottom: 20,
                  },
              },
          },
      });

    var productRevenueData = <?php echo json_encode($product_sale); ?>;
    if (productRevenueData.length > 0) {
        var lineChart = document.getElementById("lineChart").getContext("2d");
        var myLineChart = new Chart(lineChart, {
            type: "line",
            data: {
                labels: productRevenueData.map(product => product.name),
                datasets: [{
                    label: "Product Sales",
                    data: productRevenueData.map(product => product.revenue),
                    borderColor: "#FFAD46",
                    pointBorderColor: "#FFAD46",
                    pointBackgroundColor: "#FFAD46",
                    fill: true,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: { 
                    position: "bottom" 
                }
            }
        });
    } else {
        console.error("No product revenue data available.");
    }
   
    </script>
  </body>
</html>

<?php
} else {
    header("Location: ./index.php");
    exit();
}
?>
