<div class="mt-4">
    <h5 class="card-title mt-5 mb-3">Fruit Products</h5>
</div>

<!-- Search bar -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
            <input type="text" id="searchInputFruits" class="form-control" placeholder="Search by name...">
        </div>
    </div>
</div>

<!-- Product list -->
<div id="order-container">
    <div class="row">
        <?php
            $sql = "SELECT * FROM product WHERE prod_category = 21";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $prod_name = htmlspecialchars($row['prod_name'], ENT_QUOTES, 'UTF-8');
                    $prod_quantity = $row['prod_quantity'];
                    $prod_price = number_format($row['prod_price'], 2);
                    $prod_unit =  $row['unit'];

                    echo '
                    <div class="col-lg-4 col-sm-12 col-md-6 product-card" 
            data-name="' . strtolower(htmlspecialchars($prod_name, ENT_QUOTES, 'UTF-8')) . '" 
            data-price="' . $prod_price . '">
            <div class="card flex-grow-1">
                <div class="card-body">
                        <h4 class="text-center">' . htmlspecialchars($prod_name, ENT_QUOTES, 'UTF-8') . '</h4>
                        <div class="col-12 mt-3">
                            <div class="d-flex justify-content-between align-items-center">
                               <p class="card-title mb-0"> $'. $prod_price . '/<span style="font-size:12px;">' . $prod_unit . '</span></p>
                    <p class="card-title mb-0"> <span style="font-size:12px;">Stocks:</span> ' . $prod_quantity . ' <span style="font-size:10px;">' . $prod_unit . '</span></p>
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
                </div>
                    ';
                }
            } else {
                echo '
                <div> <p>No products found.</p></div>';
            }
            ?>
    </div>
</div>