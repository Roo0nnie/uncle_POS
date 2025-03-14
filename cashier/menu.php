<?php
include '../php/db_conn.php';
session_start();

  if(isset($_POST['submit'])) {

    $order_date = mysqli_real_escape_string($conn, trim($_POST['order_date']));
    $order_transID = mysqli_real_escape_string($conn, trim($_POST['trans_id']));
    $order_totalCost = mysqli_real_escape_string($conn, trim($_POST['total_cost']));
    $order_name = mysqli_real_escape_string($conn, trim($_POST['f_name']));
    $order_payMethod = mysqli_real_escape_string($conn, trim($_POST['pay_method']));
    $order_payment = mysqli_real_escape_string($conn, trim($_POST['total_payment']));
   

    $check_sql = "SELECT * FROM `customer` WHERE trans_id = '$order_transID'";
    $check_result = mysqli_query($conn, $check_sql);

    if ($check_result && mysqli_num_rows($check_result) == 0) { 
       if($order_totalCost > 0) {
        $sql = "INSERT INTO customer (cus_payment,firstname, date, pay_method, total_price, status, created_at, trans_id)  
        VALUES ('$order_payment','$order_name', '$order_date','$order_payMethod', '$order_totalCost', 'Done', NOW(), '$order_transID')";

        if (mysqli_query($conn, $sql)) {
            $order_id = mysqli_insert_id($conn);

            foreach ($_POST['products'] as $product) {
              if($product['quantity'] != 0) {
                $product_id = mysqli_real_escape_string($conn, $product['id']);
                $product_quantity = mysqli_real_escape_string($conn, $product['quantity']);
                $product_price = mysqli_real_escape_string($conn, $product['price']);

                $item_sql = "INSERT INTO `order` (cust_id, prod_id, order_quantity, order_price)
                             VALUES ('$order_id', '$product_id', '$product_quantity', '$product_price')";
                
                $update_stock_sql = "UPDATE `product` SET prod_quantity = prod_quantity - $product_quantity WHERE id = $product_id";
                mysqli_query($conn, $item_sql);
                mysqli_query($conn, $update_stock_sql);
              }
                
            }

            $_SESSION['success_message'] = "Order added successfully.";
            header("Location: ./menu.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Failed to add order.";
            header("Location: ./menu.php");
            exit();
        }

       } else {
           $_SESSION['error_message'] = "Total cost should be greater than zero.";
            header("Location:./menu.php");
            exit();
       }
    } else {
        $_SESSION['error_message'] = "Order already exists.";
        header("Location: ./menu.php");
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
    <link rel="stylesheet" href="../assets/css/cashier.css">
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
            <li class="nav-item active">
                <a href="./menu.php">
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
                <a href="./order/orders.php">
                  <i class="fas fa-shopping-cart"></i>
                  <p>Orders</p>
                </a>
              </li>
              <li class="nav-item">
                <a  href="./reports/reports.php">
                  <i class="fas fa-clipboard-list"></i>
                  <p>Analytics</p>
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
            </div>

            



            <div class="row">
            <form action="" method="post">
              <div class="row">
                <div class="col-8">
                <!-- Product List -->
                <div>
                <div class="card-body">
                <div>
                <div class="tab-buttons d-flex gap-3">
                  <button class="tab-button btn active card card-black" onclick="showTab('veges')">Vegetables</button>
                  <button class="tab-button btn card" onclick="showTab('fruits')">Fruits</button>
                  <button class="tab-button btn card" onclick="showTab('meat')">Meat</button>
                  <button class="tab-button btn card" onclick="showTab('drinks')">Drinks</button>
                  <button class="tab-button btn card" onclick="showTab('milk')">Milk</button>
              </div>
            </div>

            <div id="veges" class="tab-content active">
            <?php include './product/vege.php'?>
            </div>

            <div id="fruits" class="tab-content">
              <?php include './product/fruit.php'?>
            </div>

            <div id="meat" class="tab-content">
              <?php include './product/meat.php'?>
            </div>

            <div id="drinks" class="tab-content">
              <?php include './product/drink.php'?>
            </div>

            <div id="milk" class="tab-content">
              <?php include './product/milk.php'?>
            </div>
                    
            </div>
          </div>
          </div>
                <!-- Product List -->

              <div class="col-4">
              <div class="card card-stats card-round">
                    <div  class="card-body">
                      <!-- Order Summary --> 
                      <div class="row align-items-center">
                      <?php
                          if (isset($_SESSION['error_message'])) {
                              echo "<p class='text-danger text-center'>" . $_SESSION['error_message'] . "</p>";
                              unset($_SESSION['error_message']); 
                          } else if(isset($_SESSION['success_message'])) {
                            echo "<p class='text-success text-center'>" . $_SESSION['success_message'] . "</p>";
                              unset($_SESSION['success_message']); 
                          }
                        ?>

                        <p class="card-category">Order Summary</p>
                       <div class="d-flex gap-5 mt-3">
                        <div class="">
                            <label for="">Date:</label>
                            <input type="date" name="order_date" id="order-date" class="form-control"  aria-label="Username" aria-describedby="basic-addon2" required readonly>
                          </div>
                          <div class="">
                            <label for="">Transaction ID:</label>
                            <input type="text" name="trans_id" id="order-id" class="form-control"  aria-label="Username" aria-describedby="basic-addon1" required readonly>
                          </div>
                       </div>
                       <div class="mt-2">
                          <div class="">
                            <div class="">
                             
                              <div class="mt-4">
                              <label for="">Customer Name</label>
                              <input type="text" name="f_name" class="form-control mb-2" placeholder="eg. John Doe" required>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="mt-2">
                        <label for="">Payment Method</label>
                            <select name="pay_method" class="form-control">
                              <option value="Cash">Cash</option>
                              <option value="Gcash">Gcash</option>
                              <option value="Credit card">Credit Card</option>
                            </select>
                        </div>
                        
                        <!-- Product Selected display here -->
                        <div class="mt-4">
                            <h5>Items</h5>
                            <div id="selected-products" class="list-group">
                                <!-- Selected products will be displayed here -->
                            </div>
                           <div class="mt-3">
                           <h4 class="card-title">Total Cost:</h4>
                            <div>
                              <input type="number" id="total-cost" name="total_cost" class="form-control" value="0.00" readonly>
                            </div>
                           </div>
                        </div>
                      </div>
                        

                       
                              
                        <div class="mt-3">
                          <div class="mt-3">
                          <label for="">Your Payment</label>
                              <input type="number" 
                                    id="total-payment" 
                                    name="total_payment" 
                                    class="form-control" 
                                    
                                    placeholder="0.00"
                                    step="0.01" required>
                          </div>
                      </div>
                      <button type="submit" name="submit" class="btn btn-primary mt-3 w-100">Submit Order</button>
                    </div>
                </div>
              </div>
              </div>
            </form>
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
    <script src="../assets/js/menu.js"></script>

  </body>
</html>
<?php
} else {
    header("Location: index.php");
    exit();
}
?>