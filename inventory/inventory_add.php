<?php
include '../php/db_conn.php';
session_start();

$sup_id = $_GET['sup_id'];
$trans_id = isset($_GET['trans_id']) ? htmlspecialchars($_GET['trans_id']) : '';
$del_date_raw = $_GET['del_date'] ?? '';
$del_date = date('Y-m-d', strtotime($del_date_raw));

if(empty($sup_id) || $sup_id < 0) {
    $_SESSION['error_message'] = "Please select a valid supplier.";
    header("Location: ../delivery.php");
    exit();
}


if (empty($del_date) || !strtotime($del_date)) {
  $_SESSION['error_message'] = "Please provide a valid delivery date.";
  header("Location: ../delivery.php");
  exit();
}

$sql_supplier = "SELECT * FROM `supplier` WHERE id = $sup_id";
$result_supplier = mysqli_query($conn, $sql_supplier);
if ($result_supplier && mysqli_num_rows($result_supplier) > 0) {
    $row_supplier = mysqli_fetch_assoc($result_supplier);
} else {
    $row_supplier = ['sup_name' => '']; 
}



if (isset($_POST['update'])) {
  // Sanitize and validate input
  $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
  $prod_name = trim($_POST['prod_name'] ?? '');
  $prod_quantity = (int)($_POST['prod_quantity'] ?? 0);
  $prod_price = (float)($_POST['prod_price'] ?? 0.00);
  $orig_price = (float)($_POST['orig_price'] ?? 0.00);
  $prod_category = (int)($_POST['prod_category'] ?? 0);
  $vat_percent = (float)($_POST['vat_percent'] ?? 0.00);
  
  $prod_expiry = isset($_POST['prod_expiry']) ? (int)$_POST['prod_expiry'] : 0;

  // Validate required fields
  if (empty($product_id) || empty($prod_name) || empty($prod_quantity) || empty($prod_price) || empty($orig_price) || empty($prod_category) || empty($prod_expiry)) {
      $_SESSION['error_message'] = "All required fields must be filled.";
      header("Location: ./inventory_add.php");
      exit();
  }

  // Prepare SQL update statement
  $sql = "UPDATE product SET 
          prod_name = ?, 
          sup_id = ?, 
          trans_id = ?, 
          del_date = ?, 
          prod_quantity = ?, 
          prod_price = ?, 
          orig_price = ?, 
          prod_category = ?, 
          prod_expiry = ?, 
          vat_percent = ?, 
          updated_at = NOW() 
          WHERE id = ?";

  $stmt = $conn->prepare($sql);
  if (!$stmt) {
      $_SESSION['error_message'] = "Database error: Could not prepare statement.";
      header("Location: ./inventory_add.php");
      exit();
  }

  $stmt->bind_param(
    "sissiiididi", // this format string must match the types below
    $prod_name,      // string (s)
    $sup_id,         // integer (i)
    $trans_id,       // string? integer? (check this)
    $del_date,       // string (s) for date
    $prod_quantity,  // integer (i)
    $prod_price,     // integer? or float?
    $orig_price,     // double (d)
    $prod_category,  // integer or string?
    $prod_expiry,    // string (s) for date
    $vat_percent,    // double (d)
    $product_id      // integer (i)
  );

  if ($stmt->execute()) {
      $_SESSION['error_message'] = "Product updated successfully!";
      header("Location: ../inventory.php?trans_id=$trans_id&del_date=$del_date");
      exit();
  } else {
      $_SESSION['error_message'] = "Could not update product: " . $stmt->error;
      header("Location: ./inventory_add.php");
      exit();
  }

  $stmt->close();
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
              <li class="nav-item active">
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
                <h3 class="fw-bold mb-3">Edit Product</h3>
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
                      <a href="#">Delivery</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                      </li>
                      <li class="nav-item">
                        <a href="#">Edit Product</a>
                      </li>
                  </ul>
                </div>
              </div>
            </div>



            <?php $products = $conn->query("SELECT id, prod_name FROM product");?>

                <form action="" method="post" id="productForm">
                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
                <?php endif; ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Product Information</h5>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Supplier:</strong> <?php echo htmlspecialchars($row_supplier['sup_name']); ?></div>
                            <div class="col-md-4"><strong>Transaction ID:</strong> <?php echo htmlspecialchars($trans_id); ?></div>
                            <div class="col-md-4"><strong>Delivery Date:</strong> <?php echo htmlspecialchars($del_date); ?></div>
                        </div>
                        <input type="hidden" name="sup_id" value="<?php echo $row_supplier['id']; ?>">
                        <input type="hidden" name="trans_id" value="<?php echo $trans_id; ?>">
                        <input type="hidden" name="del_date" value="<?php echo $del_date; ?>">

                        <div class="mb-3">
                            <select id="productSelect" name="product_id" class="form-select" required>
                                <option value="">Browse Products</option>
                                <?php while ($row = $products->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id']; ?>">
                                        <?php echo htmlspecialchars($row['prod_name']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="prod_name" class="form-label">Product Name:</label>
                                <input type="text" class="form-control" id="prod_name" name="prod_name" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="prod_price" class="form-label">Selling Price:</label>
                                <input type="number" step="0.01" class="form-control" name="prod_price" >
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="orig_price" class="form-label">Cost Price:</label>
                                <input type="number" step="0.01" class="form-control" id="orig_price" name="orig_price" >
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="prod_quantity" class="form-label">Quantity:</label>
                                <input type="number" class="form-control"  name="prod_quantity" >
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="prod_category" class="form-label">Category:</label>
                                <select id="prod_category" name="prod_category" class="form-select" >
                                    <option value="">Select Category</option>
                                    <?php
                                    $categories = $conn->query("SELECT * FROM category");
                                    while ($cat = $categories->fetch_assoc()) {
                                        echo "<option value='{$cat['id']}'>" . htmlspecialchars($cat['name']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                          

                            <div class="col-md-6 mb-3">
                                <label for="prod_expiry" class="form-label">With Expiry</label>
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <input type="radio" id="expiry-yes" name="prod_expiry" value="1" class="form-check-input">
                                        <label for="expiry-yes" class="form-check-label">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" id="expiry-no" name="prod_expiry" value="0" class="form-check-input">
                                        <label for="expiry-no" class="form-check-label">No</label>
                                    </div>
                                </div>
                            </div>
                          

                            <div class="col-sm-12 col-md-6 ms-3 ms-sm-0 mb-4">
                              <div class="numbers"  >
                                  <div class="">
                                  <label for="vat_percent" class="form-label">VAT:</label>
                                    <select name="vat_percent" class="form-select">
                                        <option value="0">0%</option>
                                        <?php 
                                            $sql = "SELECT * FROM `vat`";
                                            $result = mysqli_query($conn, $sql);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<option value='". $row['vat']. "'>". $row['vat']. "%</option>";
                                            }
                                        ?>
                                    </select>
                                  </div>
                              </div>
                            </div>
                            
                        </div>

                        

                        <button type="submit" name="update" class="btn btn-primary">Add</button>
                        <a href="../delivery.php" class="btn btn-secondary">Back</a>
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

    <script>
        document.getElementById('productSelect').addEventListener('change', function () {
            const productId = this.value;
            if (!productId) {
                // Clear fields if no product is selected
                document.getElementById('prod_name').value = '';
                document.getElementById('orig_price').value = '';
                document.getElementById('prod_category').value = '';
                document.getElementById('expiry-yes').checked = false;
                document.getElementById('expiry-no').checked = false;
                return;
            }

            // Fetch product details via AJAX
            fetch('fetch_product.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'product_id=' + encodeURIComponent(productId)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('prod_name').value = data.product.prod_name || '';
                    document.getElementById('orig_price').value = data.product.orig_price || '';
                    document.getElementById('prod_category').value = data.product.prod_category || '';
                    const expiry = data.product.prod_expiry != null ? parseInt(data.product.prod_expiry) : 0; 
                    console.log('prod_expiry:', expiry);
                    document.getElementById('expiry-yes').checked = expiry === 1;
                    document.getElementById('expiry-no').checked = expiry === 0;
                } else {
                    alert('Failed to fetch product details.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while fetching product details.');
            });
        });
    </script>

    <script src="../assets/js/setting-demo.js"></script>
    <script src="../assets/js/demo.js"></script>
    <script src="../assets/js/product.js?<?php echo time(); ?>"></script>
  </body>
</html>
<?php
} else {
    header("Location: index.php");
    exit();
}
?>