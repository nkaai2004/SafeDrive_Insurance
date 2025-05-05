<?php
include 'session_check.php';
include 'db_connect.php';

$user_id = $_SESSION['user_id'];

$sql_all = "SELECT c.*, v.make, v.model 
            FROM claims c 
            JOIN vehicles v ON c.vehicle_id = v.vehicle_id 
            WHERE c.user_id = ?";
$stmt_all = $conn->prepare($sql_all);
$stmt_all->bind_param("i", $user_id);
$stmt_all->execute();
$all_claims = $stmt_all->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claims - SafeDrive Insurance</title>
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
        <h1>Your Claims</h1>
        <section>
            <h2>All Claims</h2>
            <p>Claims found: <?php echo $all_claims->num_rows; ?></p>
            <table>
                <thead>
                    <tr>
                        <th>Claim ID</th>
                        <th>Date</th>
                        <th>Car</th>
                        <th>Status</th>
                        <th>Document</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($claim = $all_claims->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $claim['claim_id']; ?></td>
                            <td><?php echo date('m/d/Y', strtotime($claim['created_at'])); ?></td>
                            <td><?php echo $claim['make'] . ' ' . $claim['model']; ?></td>
                            <td><?php echo $claim['status']; ?></td>
                            <td>
                                <?php if ($claim['document_path']): ?>
                                    <a href="<?php echo $claim['document_path']; ?>" target="_blank">View</a>
                                <?php else: ?>
                                    None
                                <?php endif; ?>
                            </td>
                            <td><a href="view_claim.php?id=<?php echo $claim['claim_id']; ?>">View Details</a></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
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