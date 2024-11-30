<?php  
include '../php/db_conn.php';
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete = mysqli_query($conn, "DELETE FROM `product` WHERE `id` = '$id'");
    $_SESSION['error_message'] = "Product deleted successfully!";
    header("Location: ../product.php");
    exit();
}
?>