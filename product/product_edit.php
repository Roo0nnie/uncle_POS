<?php
include '../php/db_conn.php';
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  if(isset($_GET['id'])){

    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql_product = "SELECT * FROM `product` WHERE id = '$id'";
    $result_product = mysqli_query($conn, $sql_product);

    if ($result_product && mysqli_num_rows($result_product) > 0) {

        $row_product = mysqli_fetch_assoc($result_product);
        $edit_id = $row_product['id'];
        $edit_name = $row_product['prod_name'];
        $edit_quantity = $row_product['prod_quantity'];
        $edit_orig_price = $row_product['orig_price'];
        $edit_vat_price = $row_product['vat_percent'];
        $edit_price = $row_product['prod_price'];
        $edit_unit = $row_product['unit'];
        $edit_category = $row_product['prod_category'];
        $edit_expiry = $row_product['prod_expiry'];
        $edit_barcode = $row_product['barcode'];
        $edit_description = $row_product['description'];


        $edit_created = $row_product['created_at'];
        $edit_updated = $row_product['updated_at'];

        $sql_category = "SELECT * FROM `category` WHERE id = $edit_category";
         $result_category = mysqli_query($conn, $sql_category);
         if ($result_category && mysqli_num_rows($result_category) > 0) {
             $row_category = mysqli_fetch_assoc($result_category);
         } else {
             $row_category = ['name' => '']; 
         }


        

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
    $prod_id = mysqli_real_escape_string($conn, trim($_POST['id']));
    $prod_name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $prod_quantity = mysqli_real_escape_string($conn, trim($_POST['quantity']));
    $prod_orig_price = mysqli_real_escape_string($conn, trim($_POST['orig_price']));
    $prod_vat_price = mysqli_real_escape_string($conn, trim($_POST['vat_price']));
    $prod_price = mysqli_real_escape_string($conn, trim($_POST['price']));
    $prod_category = mysqli_real_escape_string($conn, trim($_POST['category']));
    $prod_unit = mysqli_real_escape_string($conn, trim($_POST['unit']));
    $prod_expiry = isset($_POST['expiry']) && !empty($_POST['expiry']) ? mysqli_real_escape_string($conn, trim($_POST['expiry'])) : 0;
    $prod_barcode = mysqli_real_escape_string($conn, trim($_POST['barcode']));
    $prod_description = mysqli_real_escape_string($conn, trim($_POST['description']));

  if(empty($prod_name) && !empty($prod_unit) && !empty($prod_quantity) && !empty($prod_price) && !empty($prod_category) && $prod_category != 0) {
    $_SESSION['error_message'] = "All fields are required.";
    header("Location: ./product_edit.php?id=$prod_id");
    exit();
  }

    $sql_product = "UPDATE product SET 
    prod_name = '$prod_name',
    prod_quantity = '$prod_quantity',
    orig_price = '$prod_orig_price',
    vat_percent = '$prod_vat_price',
    prod_price = '$prod_price',
    barcode = '$prod_barcode',
    description = '$prod_description',
    unit = '$prod_unit',
    prod_category = '$prod_category', ";

    if ($prod_expiry === 0) {
        $sql_product .= "prod_expiry = 0, ";
    } else {
        $sql_product .= "prod_expiry = '$prod_expiry', ";
    }

    $sql_product .= "updated_at = now()";

    $sql_product .= " WHERE id = '$prod_id'";

  if(mysqli_query($conn, $sql_product)){
    $_SESSION['error_message'] = "Updated product successfully!.";
    header("Location: ../product.php");
    exit();
  } else {
    $_SESSION['error_message'] = "Could not update record: ". mysqli_error($conn);
    header("Location: ../product.php");
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
              <li class="nav-item active">
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
                <h3 class="fw-bold mb-3">Edit Product</h3>
                <div class="page-header">
                  <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                      <a href="#"><i class="icon-home"></i></a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item">
                      <a href="#">Product</a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item">
                      <a href="#">Edit Product</a>
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
                      <p class="card-category fw-bold">Product Information</p>

                      <div class="row g-3">
                        <div class="col-sm-12 col-md-6">
                          <div class="mb-4">
                            <h4 class="card-title">Product Name</h4>
                            <input type="text" class="form-control" name="name" placeholder="Product name" value="<?php print $edit_name; ?>">
                          </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                          <div class="mb-4">
                            <h4 class="card-title">Category</h4>
                              <select name="category" class="form-control">
                                <?php 
                                  $sql = "SELECT * FROM  `category`";
                                  $result = mysqli_query($conn, $sql);
                                  echo "<option value='". $edit_category. "'>". $row_category['name']. "</option>";
                                  while ($row = mysqli_fetch_assoc($result)) {
                                    if($edit_category != $row['id']) {
                                      echo "<option value='". $row['id']. "'>". $row['name']. "</option>";
                                    }
                                    
                                  }
                                ?>
                              </select>
                          </div>
                        </div>
                      </div>

                      <div class="row align-items-center">
                      <div class="col-sm-12 col-md-6 ms-3 ms-sm-0">
                            <div class="d-flex justify-content-between">
                            <div class="numbers w-100 me-4">
                                <div class="">
                                <h4 class="card-title">Quantity</h4>
                                <input type="number" class="form-control" name="quantity" value="<?php print $edit_quantity; ?>">
                                </div>
                            </div>
                            <div class="numbers">
                                <div class="">
                                <h4 class="card-title">Unit</h4>
                                <select name="unit" id="" class="form-control">
                                  <option value="pcs" <?php if($edit_unit == 'pcs') echo 'selected'; ?>>pcs</option>
                                  <option value="kg" <?php if($edit_unit == 'kg') echo 'selected'; ?>>kg</option>
                                  <option value="litre" <?php if($edit_unit == 'litre') echo 'selected'; ?>>litre</option>
                                  <option value="box" <?php if($edit_unit == 'box') echo 'selected'; ?>>box</option>
                                  <option value="case" <?php if($edit_unit == 'case') echo 'selected'; ?>>case</option>
                                </select>
                                </div>
                            </div>  
                            </div>
                          </div>


                        <div class="col-sm-12 col-md-6 ms-3 ms-sm-0">
                          <div class="">
                            <h4 class="card-title">Expiry Date</h4>
                            <select name="expiry" class="form-control">
                              <option value="0" <?php if($edit_expiry == 0) echo 'selected'; ?>>No</option>
                              <option value="1" <?php if($edit_expiry == 1) echo 'selected'; ?>>Yes</option>
                            </select>
                          </div>
                        </div>
                      </div>



                      

                      

                      <div class="row align-items-center">
                        <div class="col-sm-12 col-md-6 ms-3 ms-sm-0">
                          <div class="numbers">
                              <div class="mt-4">
                              <h4 class="card-title">Original Price</h4>
                              <input type="number" name="orig_price" class="form-control" value="<?php print $edit_orig_price; ?>">
                              </div>
                          </div>
                        </div>
                        <div class="col-sm-12 col-md-6 ms-3 ms-sm-0" >
                        <div class="numbers" style="display: none;">
                              <div class="mt-4">
                              <h4 class="card-title mt-2">VAT</h4>
                              <select name="vat_price" class="form-control">
                                <?php 
                                    $sql = "SELECT * FROM `vat`";
                                    $result = mysqli_query($conn, $sql);

                                    $found = false;

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $selected = ($edit_vat_price == $row['vat']) ? "selected" : "";
                                        if ($edit_vat_price == $row['vat']) {
                                            $found = true;
                                        }
                                        echo "<option value='". $row['vat']. "' $selected>". $row['vat']. "%</option>";
                                    }

                                    if (!$found) {
                                        $selected = ($edit_vat_price == 0) ? "selected" : "";
                                        echo "<option value='0' $selected>0%</option>";
                                    }
                                ?>
                            </select>
                              </div>
                          </div>
                          <div class="col-sm-12 col-md-6 ms-3 ms-sm-0">
                          <div class="numbers">
                              <div class="mt-4">
                              <div class="card-title mt-2">Selling Price</div>
                              <input type="number" name="price" class="form-control" value="<?php print $edit_price; ?>" readonly>
                              </div>
                          </div>
                        </div>
                        </div>
                      </div>

                      <div class="row align-items-center" >
                        <div class="col-sm-12 col-md-6 ms-3 ms-sm-0">
                            <div class="numbers">
                                <div class="mt-4">
                                <h4 class="card-title">Barcode</h4>
                                <input type="text" name="barcode" class="form-control" value="<?php print $edit_barcode; ?>">
                                </div>
                            </div>
                          </div>
                        <div class="col-sm-12 col-md-6 ms-3 ms-sm-0">
                          <div class="numbers">
                              <div class="mt-4">
                              <h4 class="card-title mt-2">Description</h4>
                                <textarea name="description" class="form-control" placeholder="Description"><?php print $edit_description; ?></textarea>
                              </div>
                          </div>
                        </div>
                      </div>

                      <div class="row align-items-center">
                       
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
                        <i class="fas fa-cart-plus"></i> Update Product
                    </button>
                    <a href="../product.php" class="btn btn-secondary ">Back</a>
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
    <script src="../assets/js/product.js?<?php echo time(); ?>"></script>
  </body>
</html>
<?php
} else {
  $_SESSION['error_message'] = "You have to login first.";
  header("Location: ../index.php");
  exit();
}
?>