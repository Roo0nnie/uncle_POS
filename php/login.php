<?php
session_start();
include 'db_conn.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $user = validate($_POST['username']);
    $pass = validate($_POST['password']);

    if (empty($user)) {
        $_SESSION['error_message'] = "Username is required.";
        header("Location: ../index.php");
        exit();
    } else if (empty($pass)) {
        $_SESSION['error_message'] = "Password is required.";
        header("Location: ../index.php");
        exit();
    } else {
    
        $sql = "SELECT * FROM user WHERE username = ? AND password = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $user, $pass);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            if ($row['username'] === $user && $row['password'] === $pass) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['last_name'] = $row['last_name'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['role'] = $row['role'];

                if($_SESSION['role'] == 'admin') {
                    header("Location: ../dashboard.php");
                } else {
                    header('Location: ../cashier/menu.php');
                }
               
                exit();
            } else {
                $_SESSION['error_message'] = "Incorrect username or password.";
                header("Location: ../index.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Incorrect username or password.";
            header("Location: ../index.php");
            exit();
        }

        mysqli_stmt_close($stmt);
    }
} else {
    $_SESSION['error_message'] = "Please enter username and password.";
    header("Location: ../index.php");
    exit();
}

mysqli_close($conn);
?>
