<?php
include '../php/db_conn.php';
session_start();

  if(isset($_POST['submit'])) {

    $order_date = mysqli_real_escape_string($conn, trim($_POST['order_date']));
    $order_transID = mysqli_real_escape_string($conn, trim($_POST['trans_id']));
    $order_totalCost = mysqli_real_escape_string($conn, trim($_POST['total_cost']));
    $order_name = mysqli_real_escape_string($conn, trim($_POST['f_name']));
    $order_middle = mysqli_real_escape_string($conn, trim($_POST['m_name']));
    $order_last = mysqli_real_escape_string($conn, trim($_POST['l_name']));
    $order_email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $order_phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $order_address = mysqli_real_escape_string($conn, trim($_POST['address']));
    $order_instruction = mysqli_real_escape_string($conn, trim($_POST['instruction']));
    $order_payMethod = mysqli_real_escape_string($conn, trim($_POST['pay_method']));

    $check_sql = "SELECT * FROM `customer` WHERE trans_id = '$order_transID'";
    $check_result = mysqli_query($conn, $check_sql);

    if ($check_result && mysqli_num_rows($check_result) == 0) { 

        $sql = "INSERT INTO customer (firstname, middlename, lastname, date, email, phone, address, instruction, pay_method, total_price, status, created_at, trans_id)  
        VALUES ('$order_name', '$order_middle', '$order_last', '$order_date', '$order_email', '$order_phone', '$order_address', '$order_instruction', '$order_payMethod', '$order_totalCost', 'Pending', NOW(), '$order_transID')";

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

            $_SESSION['error_message'] = "Order added successfully.";
            header("Location: ../orders.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Failed to add order.";
            header("Location: ./orders.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Order already exists.";
        header("Location: ./orders.php");
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
  </head>
  <body>
    <div class="wrapper">

      <div class="cashier-panel">
        <div class="menu-header">
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
            <form action="orders_add.php" method="post" >
            <div class="d-flex">
                <div class="card card-stats card-round me-lg-3">
                  <div class="card-body">
                    <div class="row align-items-center mb-2">
                      <p class="card-category">Menu</p>
                    </div>
                    
                    <!-- Product list -->
                     <div class="flex flex-column">
                        <div id="order-container">
                          <div class="row">
                            <?php
                            $sql = "SELECT * FROM `product`";
                            $result = mysqli_query($conn, $sql);

                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id = $row['id'];
                                    $prod_name = htmlspecialchars($row['prod_name'], ENT_QUOTES, 'UTF-8');
                                    $prod_quantity = $row['prod_quantity'];
                                    $prod_price = number_format($row['prod_price'], 2);

                                    echo '
                                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                                        <div class="card card-black flex-grow-1">
                                            <div class="card-body">
                                                <h4 class="text-center">' . htmlspecialchars($prod_name, ENT_QUOTES, 'UTF-8') . '</h4>
                                                <div class="col-12 mt-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <p class="card-title "><span style="font-size:14px;">Price:</span> $' . $prod_price . '</p>
                                                        <p class="card-title "><span style="font-size:14px;">Stock:</span> ' . $prod_quantity . '</p>
                                                    </div>
                                                    <div class="input-group mt-3">
                                                        <button class="btn btn-outline-secondary" type="button" onclick="decreaseQuantity(this, ' . $prod_quantity . ', ' . $prod_price . ')">-</button>
                                                        <input type="number" name="products[' . $id . '][quantity]" class="form-control text-center quantity-input" value="0" min="0" max="' . $prod_quantity . '" data-price="' . $prod_price . '" readonly>
                                                        <button class="btn btn-outline-secondary" type="button" onclick="increaseQuantity(this, ' . $prod_quantity . ', ' . $prod_price . ')">+</button>
                                                    </div>
                                                    <input type="hidden" name="products[' . $id . '][id]" value="' . $id . '">
                                                    <input type="hidden" name="products[' . $id . '][price]" value="' . $prod_price . '">
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                }
                            } else {
                                echo '<p>No products found.</p>';
                            }
                            ?>

                          </div>
                        </div>
                    </div>
                  </div>
                
                </div>


                 <!-- Payment Process -->
                <div class="card card-stats card-round">
                  <div class="card-body">
                    
                    <!-- Product list -->
                    <div class="flex flex-column">
                      <!-- Order Summary -->
                      <div class="mb-4">
                        <div class="card card-black">
                          <div class="card-body">
                            <h4>Order Summary</h4>
                            <div class="row">
                              <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon2">Order Date: </span>
                                <input type="date" name="order_date" id="order-date" class="form-control"  aria-label="Username" aria-describedby="basic-addon2" required readonly>
                              </div> 

                              <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Transaction ID: </span>
                                <input type="text" name="trans_id" id="order-id" class="form-control"  aria-label="Username" aria-describedby="basic-addon1" required readonly>
                              </div>  
                            
                            </div>
                            <div class="d-flex justify-content-between justify-content-center align-items-center">
                                <h4 class="card-title">Total Cost:</h4>
                                <div>
                                <input type="number" id="total-cost" name="total_cost" class="form-control" value="0.00" readonly>
                                </div>
                              </div>

                            <h5 class="mt-5">Customer Information</h5>
                            <input type="text" name="f_name" class="form-control mb-2" placeholder="Customer name" required>
                            <input type="text" name="m_name" class="form-control mb-2" placeholder="Middle name">
                            <input type="text" name="l_name" class="form-control mb-2" placeholder="Last name">
                            <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                            <input type="text" name="phone" class="form-control mb-2" placeholder="Mobile phone" required>
                            
                          </div>
                        </div>
                      </div>
                    
                      <!-- Delivery and Payment -->
                      <div class="card">
                        <div class="">
                          <div class="card-body">
                            <h5>Delivery Information</h5>
                            <input type="text" name="address" class="form-control mb-2" placeholder="Enter delivery address" required>
                            <textarea name="instruction" class="form-control" rows="3" placeholder="Enter delivery instructions"></textarea>
                          </div>
                        </div>
                        <div class="">
                          <div class="card-body">
                            <h5>Payment Information</h5>
                            <select name="pay_method" class="form-control">
                              <option value="Cash on delivery">Cash On Delivery</option>
                              <option value="Gcash">Gcash</option>
                              <option value="Credit card">Credit Card</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                   
                    <button type="submit" name="submit" class="btn btn-primary mt-3">Submit Order</button>
                    <a href="../orders.php" class="btn btn-secondary mt-3">Back</a>
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