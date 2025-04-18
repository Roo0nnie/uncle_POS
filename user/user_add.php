<?php
include '../php/db_conn.php';
session_start();

  if(isset($_POST['submit'])) {


    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $last_name = mysqli_real_escape_string($conn, trim($_POST['last_name']));
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $role = mysqli_real_escape_string($conn, trim($_POST['role']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));
    $confirm_password = mysqli_real_escape_string($conn, trim($_POST['confirm_password']));

      if(!empty($name) && !empty($last_name) && !empty($username) && !empty($email) && !empty($role) && !empty($password) && !empty($confirm_password)) {

        if($password !== $confirm_password) {
          $_SESSION['error_message'] = "Passwords do not match.";
          header("Location: ./user_add.php");
          exit();
        }

        $check_sql = "SELECT * FROM `user` WHERE username = '$username'";
        $check_result = mysqli_query($conn, $check_sql);

        if ($check_result && mysqli_num_rows($check_result) == 0) {
          $sql = "INSERT INTO user (name, last_name, username, email, role, password, created_at) 
          VALUES ('$name', '$last_name', '$username', '$email', '$role', '$password', NOW())";
         
          if (mysqli_query($conn, $sql)) {
            $_SESSION['success_message'] = "User added successfully.";
            header("Location: ../user.php");
            exit();
          } else {
            $_SESSION['error_message'] = "Failed to add user.";
            header("Location: ./user_add.php");
            exit();
          }

        } else {
          $_SESSION['error_message'] = "Username already exists.";
          header("Location: ./user_add.php");
          exit();
        }
      } else {
        $_SESSION['error_message'] = "All fields are required";
        header("Location: ./user_add.php");
        exit()  ;
      }
    }
  mysqli_close($conn);


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
              <li class="nav-item active">
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
                <h3 class="fw-bold mb-3">Add supplier</h3>
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
                      <a href="#">supplier</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                      </li>
                      <li class="nav-item">
                        <a href="#">Add supplier</a>
                      </li>
                  </ul>
                </div>
              </div>
            </div>
            
            <!--  -->
            <form action="" method="post">
              <?php
                  if (isset($_SESSION['error_message'])) {
                      echo "<p>" . $_SESSION['error_message'] . "</p>";
                      unset($_SESSION['error_message']); 
                  }

                  if (isset($_SESSION['success_message'])) {
                    echo "<p>" . $_SESSION['success_message'] . "</p>";
                    unset($_SESSION['success_message']); 
                  }
                  ?>

              <div class="row">
                <div class="col-sm-12 col-md-12">
                  <div class="card card-stats card-round">
                    <!--  -->
                    <div class="card-body">
                      <div class="row align-items-center">
                          <p class="card-category">User Information</p>
                          <div class="col-sm-12 col-md-6 ms-3 ms-sm-0">
                            <div class="numbers">
                                <div class="mt-4">
                                    <h4 class="card-title">Name</h4>
                                    <input type="text" class="form-control" name="name" placeholder="User name">
                                </div>
                            </div>
                          </div>
                          <div class="col-sm-12 col-md-6 ms-3 ms-sm-0">
                            <div class="numbers">
                                <div class="mt-4">
                                    <h4 class="card-title">Last Name</h4>
                                    <input type="text" class="form-control" name="last_name" placeholder="Last name">
                                </div>
                            </div>
                          </div>

                          <div class="col-sm-12 col-md-6 ms-3 ms-sm-0">
                            <div class="numbers">
                                <div class="mt-4">
                                    <h4 class="card-title">Username</h4>
                                    <input type="text" class="form-control" name="username" placeholder="Username">
                                </div>
                            </div>
                          </div>
                        
                          <div class="col-sm-12 col-md-6 ms-3 ms-sm-0">
                            <div class="numbers">
                                <div class="mt-4">
                                    <h4 class="card-title">Role</h4>
                                    <select name="role" class="form-control">
                                      <option value="cashier">Cashier</option>
                                      <option value="admin">Admin</option>
                                    </select>
                                </div>
                            </div>
                          </div>

                          <div class="col-sm-12 col-md-6 ms-3 ms-sm-0">
                            <div class="numbers">
                                <div class="mt-4">
                                    <h4 class="card-title">Email</h4>
                                    <input type="text" class="form-control" name="email" placeholder="Email">
                                </div>
                            </div>
                          </div>

                          <!--password-->
                          <div class="col-sm-12 col-md-6 ms-3 ms-sm-0">
                            <div class="numbers">
                                <div class="mt-4">
                                    <h4 class="card-title">Password</h4>
                                    <input type="text" class="form-control" name="password" placeholder="Password">
                                </div>
                            </div>
                          </div>

                          <!--confirm password-->
                          <div class="col-sm-12 col-md-6 ms-3 ms-sm-0">
                            <div class="numbers">
                                <div class="mt-4">
                                    <h4 class="card-title">Confirm Password</h4>
                                    <input type="text" class="form-control" name="confirm_password" placeholder="Confirm Password">
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--  -->
                  </div>
                    <div class="ms-md-auto py-2 py-md-0">
                      <button type="submit" name="submit" class="btn btn-primary ">
                        <i class="fas fa-cart-plus"></i> Add User
                      </button>
                       <a href="../user.php" class="btn btn-secondary ">Back</a>
                    </div>
                </div>
              </div>
            </form>
            <!--  -->
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
    header("Location: index.php");
    exit();
}
?>