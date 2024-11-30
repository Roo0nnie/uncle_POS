<?php

$sname = "localhost";
$uname = "root";
$password = "ronnie123";
$db_name = "inventory_system";

$conn = mysqli_connect($sname, $uname, $password, $db_name);

if(!$conn) {
    echo "Connection failed!";
}
?>