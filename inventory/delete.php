<?php  
include '../php/db_conn.php';
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete = mysqli_query($conn, "DELETE FROM `product` WHERE `id` = '$id'");
    $_SESSION['error_message'] = "Inventory deleted successfully!";
    header("Location: ../inventory.php");
    exit();
}
?>