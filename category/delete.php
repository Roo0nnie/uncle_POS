<?php  
include '../php/db_conn.php';
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete = mysqli_query($conn, "DELETE FROM `category` WHERE `id` = '$id'");
    $_SESSION['error_message'] = "Category deleted successfully!";
    header("Location: ../category.php");
    exit();
}
?>