<?php
include '../php/db_conn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Validate input
    if (!empty($id) && !empty($status)) {
        $sql = "UPDATE `customer` SET `status` = ? WHERE `id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $status, $id);

        if ($stmt->execute()) {
            echo json_encode(['error_message' => true, 'message' => 'Status updated successfully.']);
        } else {
            echo json_encode(['error_message' => false, 'message' => 'Failed to update status.']);
        }
    } else {
        echo json_encode(['error_message' => false, 'message' => 'Invalid input.']);
    }
} else {
    echo json_encode(['error_message' => false, 'message' => 'Invalid request method.']);
}
?>
