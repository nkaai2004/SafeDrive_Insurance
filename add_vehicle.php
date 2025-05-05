<?php
include 'session_check.php';
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $valuation = $_POST['valuation'];

    $sql = "INSERT INTO vehicles (user_id, make, model, year, valuation, status) VALUES (?, ?, ?, ?, ?, 'active')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issid", $user_id, $make, $model, $year, $valuation);

    if ($stmt->execute()) {
        header("Location: Userdashboard.php");
        exit();
    } else {
        $error = "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Vehicle - SafeDrive Insurance</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container header-content">
            <div class="logo">SafeDrive Insurance</div>
            <nav>
                <ul>
                    <li><a href="Home.php">Home</a></li>
                    <li><a href="Policies.php">Policies</a></li>
                    <li><a href="Claims.php">Claims</a></li>
                    <li><a href="Contact.php">Contact Us</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container">
        <h1>Add a New Vehicle</h1>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form action="add_vehicle.php" method="POST">
            <label for="make">Make</label>
            <input type="text" id="make" name="make" required>
            <label for="model">Model</label>
            <input type="text" id="model" name="model" required>
            <label for="year">Year</label>
            <input type="number" id="year" name="year" required>
            <label for="valuation">Valuation ($)</label>
            <input type="number" id="valuation" name="valuation" step="0.01" required>
            <button type="submit">Add Vehicle</button>
        </form>
    </main>
    <footer>
        <div class="container">
            <p>© 2023 SafeDrive Insurance. All rights reserved.</p>
            <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a>
        </div>
    </footer>
</body>
</html>