<?php
include '../php/db_conn.php';
session_start();

header('Content-Type: application/json');

if (isset($_POST['product_id'])) {
    $product_id = (int)$_POST['product_id'];
    $sql = "SELECT id, prod_name, prod_quantity, prod_expiry, prod_price, prod_category, unit, vat_percent, orig_price, barcode, description FROM product WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        echo json_encode(['success' => true, 'product' => $product]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Product not found']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}

$conn->close();
?>