<?php  
include '../php/db_conn.php';
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete = mysqli_query($conn, "DELETE FROM `delivery` WHERE `id` = '$id'");
    $_SESSION['error_message'] = "Delivery deleted successfully!";
    header("Location: ../delivery.php");
    exit();
}
?>