<?php
include '../php/db_conn.php';
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['name'])) {

    if (isset($_GET['id'])) {
        $order_id = mysqli_real_escape_string($conn, $_GET['id']);

        // Retrieve customer order details
        $sql = "SELECT * FROM `customer` WHERE id = '$order_id'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $order = mysqli_fetch_assoc($result);
            $cust_id = $order['id'];
            $order_date = $order['date'];
            $order_transID = $order['trans_id'];
            $order_totalCost = $order['total_price'];
            $order_name = $order['firstname'];
            $order_middle = $order['middlename'];
            $order_last = $order['lastname'];
            $order_phone = $order['phone'];
            $order_address = $order['address'];
            $order_status = $order['status'];
            $order_payMethod = $order['pay_method'];
        } else {
            $_SESSION['error_message'] = "No order found with this ID.";
            header("Location: ./orders.php");
            exit();
        }

        $order_items_sql = "SELECT oi.*, order_quantity, order_price FROM `order` oi
                            JOIN `product` p ON oi.prod_id = p.id
                            WHERE oi.id = '$order_id'";
        $order_items_result = mysqli_query($conn, $order_items_sql);

        if ($order_items_result && mysqli_num_rows($order_items_result) > 0) {
            $ordered_products = [];
            while ($product = mysqli_fetch_assoc($order_items_result)) {
                $ordered_products[] = $product;
            }
        } else {
            $ordered_products = [];
        }
    } else {
        $_SESSION['error_message'] = "No order ID provided.";
        header("Location: ./orders.php");
        exit();
    }


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
             
              <li class="nav-item active">
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
                <h3 class="fw-bold mb-3">View Order</h3>
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
                      <a href="#">Orders</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                      </li>
                      <li class="nav-item">
                        <a href="#">View order</a>
                      </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <h4 class="card-title text-center">Order Details</h4>
                        
                        <!-- Order Summary -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card card-black">
                                    <div class="card-body">
                                        <h4>Order Information</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Order Date:</strong> <?php echo $order_date; ?></p>
                                                <p><strong>Transaction ID:</strong> <?php echo $order_transID; ?></p>
                                                <p><strong>Total Cost:</strong> ₱<?php echo number_format($order_totalCost, 2); ?></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Name:</strong> <?php echo $order_name . ' ' . $order_middle . ' ' . $order_last; ?></p>
                                   
                                                <p><strong>Phone:</strong> <?php echo $order_phone; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Address and Instructions -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card card-black">
                                    <div class="card-body">
                                        <h4>Delivery Information</h4>
                                        <p><strong>Address:</strong> <?php echo $order_address; ?></p>
                                    
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card card-black">
                                    <div class="card-body">
                                        <h4>Payment Information</h4>
                                        <p><strong>Payment Method:</strong> <?php echo $order_payMethod; ?></p>
                                        <p><strong>Delivery Status:</strong> <?php echo $order_status; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ordered Products -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4>Ordered Products</h4>
                                        <div class="row">

                                        <?php
                                            $sql = "SELECT * FROM `order` WHERE cust_id = '$cust_id'";
                                            $result_order = mysqli_query($conn, $sql);

                                            if ($result_order && mysqli_num_rows($result_order) > 0) {
                                                while ($row = mysqli_fetch_assoc($result_order)) {
                                                    $prod_id = $row['prod_id'];
                                                    $sql_product = "SELECT * FROM `product` WHERE id = '$prod_id'";
                                                    $result_product = mysqli_query($conn, $sql_product);

                                                    if ($result_product && mysqli_num_rows($result_product) > 0) {
                                                        $row_product = mysqli_fetch_assoc($result_product);
                                                        $prod_name = $row_product['prod_name']; 

                                                        echo '<div class="col-md-4">
                                                                  <div class="card card-black">
                                                                      <div class="card-body">
                                                                          <h4>' . htmlspecialchars($prod_name, ENT_QUOTES, 'UTF-8') . '</h4>
                                                                          <p><strong>Quantity:</strong> ' . htmlspecialchars($row['order_quantity'], ENT_QUOTES, 'UTF-8') . '</p>
                                                                          <p><strong>Price:</strong> ₱' . number_format($row['order_price'], 2) . '</p>
                                                                      </div>
                                                                  </div>
                                                              </div>';
                                                    } else {
                                                        echo '<p>Product details not found for Product ID: ' . htmlspecialchars($prod_id, ENT_QUOTES, 'UTF-8') . '</p>';
                                                    }
                                                }
                                            } else {
                                                echo '<p>No orders found for this customer.</p>';
                                            }
                                            ?>
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="../orders.php" class="btn btn-secondary mt-3">Back to Orders</a>
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
    <script>

// Add order item
function updateStockAndTotal(inputElement, price) {
    let quantity = parseInt(inputElement.value);
    if (isNaN(quantity) || quantity < 0) {
        quantity = 0; 
        inputElement.value = quantity; 
    }

    let totalCost = 0;

    let allQuantities = document.querySelectorAll('.quantity-input');
    allQuantities.forEach(function (input) {
        let prodQuantity = parseInt(input.value);
        if (!isNaN(prodQuantity)) {
            let prodPrice = parseFloat(input.getAttribute('data-price'));
            if (!isNaN(prodPrice)) {
                totalCost += prodQuantity * prodPrice;
            } else {
                console.error("Invalid price attribute detected for an element.");
            }
        }
    });

    let totalCostElement = document.getElementById('total-cost');
    if (totalCostElement) {
        totalCostElement.value = totalCost.toFixed(2); 
    } else {
        console.error("Total cost element not found.");
    }
}

function increaseQuantity(button, stock, price) {
    let quantityInput = button.parentElement.querySelector('.quantity-input');
    let currentQuantity = parseInt(quantityInput.value);
    
    if (currentQuantity < stock) {
      
        quantityInput.value = currentQuantity + 1;
        updateStockAndTotal(quantityInput, price); 
    }
}

function decreaseQuantity(button, stock, price) {
    let quantityInput = button.parentElement.querySelector('.quantity-input');
    let currentQuantity = parseInt(quantityInput.value);
    if (currentQuantity > 0) {
        quantityInput.value = currentQuantity - 1;
        updateStockAndTotal(quantityInput, price); 
    }
}

let orderId = Math.floor(Math.random() * 1000000000);
document.getElementById('order-id').value = orderId;

document.addEventListener('DOMContentLoaded', function () {
    const today = new Date();
    const formattedDate = today.toISOString().split('T')[0];
    document.getElementById('order-date').value = formattedDate;
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