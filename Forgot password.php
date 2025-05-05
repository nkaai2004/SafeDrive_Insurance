<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Placeholder for email sending logic
        $message = "A password reset link has been sent to your email (email sending not implemented).";
    } else {
        $error = "Email not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - SafeDrive Insurance</title>
    <link rel="stylesheet" href="LoginForgotSignup.css">
</head>
<body>
    <div class="forgot-password-container">
        <h2>Forgot Password?</h2>
        <p>Enter your email to receive a password reset link.</p>
        <?php if (isset($message)) echo "<p style='color:green;'>$message</p>"; ?>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form action="Forgotpassword.php" method="POST">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
            <button type="submit">Reset Password</button>
            <div class="links">
                <p><a href="Login.php">Back to Login</a></p>
            </div>
        </form>
    </div>
</body>
</html>