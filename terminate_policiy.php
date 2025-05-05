<?php
include 'session_check.php';
include 'db_connect.php';

if (isset($_GET['id'])) {
    $user_policy_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    $sql = "UPDATE user_policies SET status = 'terminated' WHERE user_policy_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_policy_id, $user_id);
    $stmt->execute();
    header("Location: Userdashboard.php");
    exit();
}
?>