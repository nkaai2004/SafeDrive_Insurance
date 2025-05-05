<?php
include 'session_check.php';
include 'db_connect.php';

if (isset($_GET['id'])) {
    $vehicle_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    $sql = "DELETE FROM vehicles WHERE vehicle_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $vehicle_id, $user_id);
    $stmt->execute();
    header("Location: Userdashboard.php");
    exit();
}
?>