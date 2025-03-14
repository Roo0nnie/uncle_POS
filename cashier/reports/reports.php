<?php
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function handleDatabaseError($conn, $query) {
    error_log("Database error in $query: " . mysqli_error($conn));
    die("A database error occurred. Please contact support.");
}

include '../../php/db_conn.php';
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
    <title>Inventory System - Reports</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="../../assets/img/admin/favicon.ico"
      type="image/x-icon"
    />

    <!-- Fonts and icons -->
    <script src="../../assets/js/plugin/webfont/webfont.min.js"></script>
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
          urls: ["../../assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../assets/css/plugins.min.css" />
    <link rel="stylesheet" href="../../assets/css/admin.min.css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />
  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <div class="logo-header" data-background-color="dark">
            <a href="dashboard.php" class="logo">
              <img
                src="../../assets/img/admin/logo_light.svg"
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
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
            <li class="nav-item">
                <a href="../menu.php">
                  <i class="fas fa-shopping-cart"></i>
                  <p>Menu</p>
                </a>
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Components</h4>
              </li>
              <li class="nav-item ">
                <a href="../order/orders.php">
                  <i class="fas fa-shopping-cart"></i>
                  <p>Orders</p>
                </a>
              </li>
              <li class="nav-item active">
                <a  href="../reports/reports.php">
                  <i class="fas fa-clipboard-list"></i>
                  <p>Analytics</p>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="main-panel">
        <div class="main-header">
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
                        src="../../assets/img/profile.png"
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
                              src="../assets/img/profile.jpg"
                              alt="image profile"
                              class="avatar-img rounded"
                            />
                          </div>
                          <div class="u-text">
                            <h4><?php print $_SESSION['name'] ?> <?php print $_SESSION['last_name'] ?></h4>
                            <p class="text-muted">sample@gmail.com</p>
                          
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../../index.php">Logout</a>
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
                <h3 class="fw-bold mb-3">Overall Reports</h3>
                <div class="page-header">
                  <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                      <a href="#"><i class="icon-home"></i></a>
                    </li>
                    <li class="separator">
                      <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                      <a href="#">Reports</a>
                    </li>
                  </ul>
                </div>
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
            $total_revenue = 0;
            $highest_sale = 0;
            $lowest_sale = PHP_FLOAT_MAX;

            while ($row = mysqli_fetch_assoc($result)) {
                $product_revenue[] = [
                    'name' => sanitizeInput($row['prod_name']),
                    'revenue' => $row['estimated_revenue']
                ];

                $total_revenue += $row['estimated_revenue'];
                $highest_sale = max($highest_sale, $row['estimated_revenue']);
                $lowest_sale = min($lowest_sale, $row['estimated_revenue']);
            }
            ?>

            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Product Revenue Line Chart</div>
                  </div>
                  <div class="card-body">
                    <div class="chart-container">
                      <canvas id="lineChart"></canvas>
                    </div>
                  </div>
                </div>
              </div>
            </div>

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
                          <p class="card-category">Highest Product Revenue</p>
                          <h4 class="card-title">$ <?php echo number_format($highest_sale, 2); ?></h4>
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
                          <p class="card-category">Lowest Product Revenue</p>
                          <h4 class="card-title">$ <?php echo number_format($lowest_sale, 2); ?></h4>
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
                          <p class="card-category">Total Sales Revenue</p>
                          <h4 class="card-title">$ <?php echo number_format($total_revenue, 2); ?></h4>
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
                    <h4 class="card-title">Product Sales</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="multi-filter-select" class="display table table-striped table-hover">
                        <thead>
                          <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Stock Quantity</th>
                            <th>Unit Price</th>
                            <th>Total Sold</th>
                            <th>Total Sales Value</th>
                            <th>Estimated Revenue</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          mysqli_data_seek($result, 0);
                          while ($row = mysqli_fetch_assoc($result)) {
                              echo '<tr>
                                  <td>' . sanitizeInput($row['prod_name']) . '</td>
                                  <td>' . sanitizeInput($row['category_name']) . '</td>
                                  <td>' . $row['stock_quantity'] . '</td>
                                  <td>'.'$ ' . number_format($row['prod_price'], 2) . '</td>
                                  <td>'. $row['total_sold_quantity'] . '</td>
                                  <td>'.'$ ' . number_format($row['total_sales_value'], 2) . '</td>
                                  <td>'.'$ ' . number_format($row['estimated_revenue'], 2) . '</td>
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
    <script src="../../assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="../../assets/js/core/popper.min.js"></script>
    <script src="../../assets/js/core/bootstrap.min.js"></script>
    <script src="../../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script src="../../assets/js/plugin/chart.js/chart.min.js"></script>
    <script src="../../assets/js/plugin/datatables/datatables.min.js"></script>
    <script src="../../assets/js/admin.min.js"></script>

    <script>
      var productRevenueData = <?php echo json_encode($product_revenue); ?>;

      if (productRevenueData.length > 0) {
          var lineChart = document.getElementById("lineChart").getContext("2d");
          var myLineChart = new Chart(lineChart, {
              type: "line",
              data: {
                  labels: productRevenueData.map(product => product.name),
                  datasets: [{
                      label: "Product Revenue",
                      data: productRevenueData.map(product => product.revenue),
                      borderColor: "#1d7af3",
                      pointBorderColor: "#FFF",
                      pointBackgroundColor: "#1d7af3",
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
    </script>
  </body>
</html>
<?php
mysqli_close($conn);
?>