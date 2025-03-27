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
    $order_discount = mysqli_real_escape_string($conn, trim($_POST['discount']));
   

    $check_sql = "SELECT * FROM `customer` WHERE trans_id = '$order_transID'";
    $check_result = mysqli_query($conn, $check_sql);

    if ($check_result && mysqli_num_rows($check_result) == 0) { 
       if($order_totalCost > 0) {
        $sql = "INSERT INTO customer (cus_payment,firstname, date, pay_method, total_price, status, created_at, trans_id, discount)  
        VALUES ('$order_payment','$order_name', '$order_date','$order_payMethod', '$order_totalCost', 'Done', NOW(), '$order_transID', '$order_discount')";

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
              <div>
                <h3 class="fw-bold mb-3">Menu</h3>
              </div>
            </div>


            <div class="row">
            <form action="" method="post">
              <div class="row">
                <!-- Product List -->
                <div class="col-8">
                <?php
                  $sql = "SELECT p.*, c.id AS category_id, c.name AS category_name 
                          FROM product p 
                          JOIN category c ON p.prod_category = c.id 
                          ORDER BY c.name, p.prod_name";
                  $result = mysqli_query($conn, $sql);

                  function slugify($text) {
                      $text = preg_replace('~[^\pL\d]+~u', '-', $text);
                      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
                      $text = preg_replace('~[^-\w]+~', '', $text);
                      $text = trim($text, '-');
                      $text = preg_replace('~-+~', '-', $text);
                      $text = strtolower($text);
                      return empty($text) ? 'n-a' : $text;
                  }

                  // Group products by category
                  $products_by_category = [];
                  if ($result) {
                      while ($row = mysqli_fetch_assoc($result)) {
                          $category_slug = slugify($row['category_name']);
                          if (!isset($products_by_category[$category_slug])) {
                              $products_by_category[$category_slug] = [
                                  'name' => $row['category_name'],
                                  'products' => []
                              ];
                          }
                          $products_by_category[$category_slug]['products'][] = $row;
                      }
                  }
                  ?>

                  <div class="row">
                      <form action="" method="post">
                          <div class="row">
                              <!-- Product List -->
                              <div class="col-12">
                                  <div class="card-body">
                                      <!-- Tab Buttons -->
                                      <div class="tab-buttons d-flex gap-3">
                                          <?php
                                          $first = true;
                                          foreach ($products_by_category as $slug => $category_data) {
                                              $active_class = $first ? 'active card card-black' : '';
                                              echo '<button class="tab-button btn card ' . $active_class . '" onclick="showTab(\'' . $slug . '\')">' . htmlspecialchars($category_data['name']) . '</button>';
                                              $first = false;
                                          }
                                          ?>
                                      </div>

                                      <!-- Tab Contents -->
                                      <?php
                                      $first = true;
                                      foreach ($products_by_category as $slug => $category_data) {
                                          $active_class = $first ? 'active' : '';
                                          ?>
                                          <div id="<?php echo $slug; ?>" class="tab-content <?php echo $active_class; ?>">
                                              <div class="mt-4">
                                                  <h5 class="card-title mt-5 mb-3"><?php echo htmlspecialchars($category_data['name']); ?> Products</h5>
                                              </div>

                                              <!-- Search bar -->
                                              <div class="row mb-4">
                                                  <div class="col-md-6">
                                                      <div class="input-group">
                                                          <span class="input-group-text"><i class="fas fa-search"></i></span>
                                                          <input type="text" id="searchInput<?php echo $slug; ?>" class="form-control search-input" placeholder="Search by name...">
                                                      </div>
                                                  </div>
                                              </div>

                                              <!-- Product list -->
                                              <div id="order-container">
                                                  <div class="row">
                                                      <?php
                                                      foreach ($category_data['products'] as $product) {
                                                          $id = $product['id'];
                                                          $prod_name = htmlspecialchars($product['prod_name'], ENT_QUOTES, 'UTF-8');
                                                          $prod_quantity = $product['prod_quantity'];
                                                          $prod_price = number_format($product['prod_price'], 2);
                                                          $prod_unit = $product['unit'];
                                                          ?>
                                                          <div class="col-lg-4 col-sm-12 col-md-6 product-card" 
                                                              data-name="<?php echo strtolower($prod_name); ?>" 
                                                              data-price="<?php echo $prod_price; ?>">
                                                              <div class="card flex-grow-1">
                                                                  <div class="card-body">
                                                                      <h4 class="text-center"><?php echo $prod_name; ?></h4>
                                                                      <div class="col-12 mt-3">
                                                                          <div class="d-flex justify-content-between align-items-center">
                                                                              <p class="card-title mb-0"> $<?php echo $prod_price; ?>/<span style="font-size:12px;"><?php echo $prod_unit; ?></span></p>
                                                                              <p class="card-title mb-0"> <span style="font-size:12px;">Stocks:</span> <?php echo $prod_quantity; ?> <span style="font-size:10px;"><?php echo $prod_unit; ?></span></p>
                                                                          </div>
                                                                          <div class="input-group mt-3">
                                                                              <button class="btn btn-outline-secondary" type="button" onclick="decreaseQuantity(this, <?php echo $prod_quantity; ?>, <?php echo $prod_price; ?>)">-</button>
                                                                              <input type="number" name="products[<?php echo $id; ?>][quantity]" class="form-control text-center quantity-input" value="0" min="0" max="<?php echo $prod_quantity; ?>" data-price="<?php echo $prod_price; ?>" readonly>
                                                                              <button class="btn btn-outline-secondary" type="button" onclick="increaseQuantity(this, <?php echo $prod_quantity; ?>, <?php echo $prod_price; ?>)">+</button>
                                                                          </div>
                                                                          <input type="hidden" name="products[<?php echo $id; ?>][id]" value="<?php echo $id; ?>">
                                                                          <input type="hidden" name="products[<?php echo $id; ?>][price]" value="<?php echo $prod_price; ?>">
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <?php
                                                      }
                                                      ?>
                                                  </div>
                                              </div>
                                          </div>
                                          <?php
                                          $first = false;
                                      }
                                      if (empty($products_by_category)) {
                                          echo '<div><p>No products found.</p></div>';
                                      }
                                      ?>
                                  </div>
                              </div>
                              <!-- End Product List -->
                          </div>
                      </form>
                  </div>
                </div>
                <!-- End Product List -->

                <!-- Order Summary -->
                <div class="col-4">
                  <div class="card card-stats card-round">
                    <div class="card-body">
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
                          <div>
                            <label for="">Date:</label>
                            <input type="date" name="order_date" id="order-date" class="form-control" required readonly>
                          </div>
                          <div>
                            <label for="">Transaction ID:</label>
                            <input type="text" name="trans_id" id="order-id" class="form-control" required readonly>
                          </div>
                        </div>

                        <div class="mt-4">
                          <label for="">Customer Name</label>
                          <input type="text" name="f_name" class="form-control mb-2" placeholder="eg. John Doe" required>
                        </div>


                        <div class="mt-4">

                            <div class="d-flex gap-5">
                                <div class=" w-75">
                                <label for="">Discount</label>
                                    <select name="vat_price" class="form-control" id="discountSelect" onchange="updateDiscount()">
                                        <option value="0">Ordinary</option>
                                        <?php 
                                            $sql = "SELECT * FROM discount";
                                            $result = mysqli_query($conn, $sql);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<option value='". htmlspecialchars($row['discount'], ENT_QUOTES, 'UTF-8') ."'>". htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') ."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div>
                                <label for="">By Percent (%)</label>
                                    <input type="number" name="discount" id="discountInput" class="form-control mb-2" placeholder="eg. 10" value="0" readonly required>
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

                        <div class="mt-4">
                          <h5>Items</h5>
                          <div id="selected-products" class="list-group">
                            <!-- Selected products will be displayed here -->
                          </div>
                          <div class="mt-3">
                            <h4 class="card-title">Total Cost:</h4>
                            <input type="number" id="total-cost" name="total_cost" class="form-control" value="0.00" readonly>
                          </div>
                        </div>

                        <div class="mt-3">
                          <label for="">Your Payment</label>
                          <input type="number" id="total-payment" name="total_payment" class="form-control"  placeholder="0.00" step="0.01" required>
                        </div>
                        

                        <div class="d-flex align-content-center">
                          <button type="submit" name="submit" class="btn btn-primary w-100 mt-5">Submit Order</button>
                        </div>
                        

                      </div>
                    </div>
                  </div>
                </div>
                <!-- End Order Summary -->
              </div> <!-- Close .row -->
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
    <script src="../assets/js/demo.js?v=<?= time(); ?>"></script>
    <script src="../assets/js/menu.js?v=<?= time(); ?>"></script>

  </body>
</html>
<?php
} else {
    header("Location: index.php");
    exit();
}
?>