<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message_text = $_POST['message'];

    $sql = "INSERT INTO contact_messages (name, email, subject, message, created_at) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $subject, $message_text);

    if ($stmt->execute()) {
        $success = "Message sent successfully.";
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
    <title>Contact Us - SafeDrive Insurance</title>
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
        <h1>Contact Us</h1>
        <section>
            <h2>Our Contact Information</h2>
            <p>Address: Ongata Rongai, Nairobi, 0511</p>
            <p>Phone: +254 795684258</p>
            <p>Email: SafeDrive@gmail.com</p>
        </section>
        <section>
            <h2>Send Us a Message</h2>
            <?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
            <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
            <form action="Contact.php" method="POST">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" required>
                <label for="message">Message</label>
                <textarea id="message" name="message" rows="5" required></textarea>
                <button type="submit">Send Message</button>
            </form>
        </section>
    </main>
    <footer>
        <div class="container">
            <p>© 2023 SafeDrive Insurance. All rights reserved.</p>
            <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a>
        </div>
    </footer>
</body>
</html>