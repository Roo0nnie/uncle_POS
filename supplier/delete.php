<?php  
include '../php/db_conn.php';
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete = mysqli_query($conn, "DELETE FROM `supplier` WHERE `id` = '$id'");
    $_SESSION['error_message'] = "Supplier deleted successfully!";
    header("Location: ../supplier.php");
    exit();
}
?>