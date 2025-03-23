<?php  
include '../php/db_conn.php';
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete = mysqli_query($conn, "DELETE FROM `discount` WHERE `id` = '$id'");
    $_SESSION['error_message'] = "Discount deleted successfully!";
    header("Location: ../discount.php");
    exit();
}
?>