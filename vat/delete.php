<?php  
include '../php/db_conn.php';
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete = mysqli_query($conn, "DELETE FROM `vat` WHERE `id` = '$id'");
    $_SESSION['error_message'] = "VAT deleted successfully!";
    header("Location: ../vat.php");
    exit();
}
?>