<?php  
include '../php/db_conn.php';
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete = mysqli_query($conn, "DELETE FROM `user` WHERE `id` = '$id'");
    $_SESSION['error_message'] = "User deleted successfully!";
    header("Location: ../user.php");
    exit();
}
?>