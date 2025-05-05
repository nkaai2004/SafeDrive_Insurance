<?php
include 'session_check.php';
include 'db_connect.php';

$user_id = $_SESSION['user_id'];

// Fetch vehicles
$sql_vehicles = "SELECT * FROM vehicles WHERE user_id = ?";
$stmt_vehicles = $conn->prepare($sql_vehicles);
$stmt_vehicles->bind_param("i", $user_id);
$stmt_vehicles->execute();
$vehicles = $stmt_vehicles->get_result();

// Fetch active policies
$sql_policies = "SELECT up.*, p.policy_name, v.make, v.model 
                 FROM user_policies up 
                 JOIN policies p ON up.policy_id = p.policy_id 
                 JOIN vehicles v ON up.vehicle_id = v.vehicle_id 
                 WHERE up.user_id = ? AND up.status = 'active'";
$stmt_policies = $conn->prepare($sql_policies);
$stmt_policies->bind_param("i", $user_id);
$stmt_policies->execute();
$policies = $stmt_policies->get_result();

// Fetch claims history
$sql_claims = "SELECT c.*, v.make, v.model 
               FROM claims c 
               JOIN vehicles v ON c.vehicle_id = v.vehicle_id 
               WHERE c.user_id = ?";
$stmt_claims = $conn->prepare($sql_claims);
$stmt_claims->bind_param("i", $user_id);
$stmt_claims->execute();
$claims = $stmt_claims->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - SafeDrive Insurance</title>
    <link rel="stylesheet" href="Userdashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"/>
</head>
<body>
    <header>
        <div class="container">
            <button class="menu-button" onclick="showsidebar()" aria-label="Open sidebar">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path d="M3 6h18c0.552 0 1-0.448 1-1s-0.448-1-1-1H3C2.448 4 2 4.448 2 5s0.448 1 1 1zm18 5H3c-0.552 0-1 0.448-1 1s0.448 1 1 1h18c0.552 0 1-0.448 1-1s-0.448-1-1-1zm0 7H3c-0.552 0-1 0.448-1 1s0.448 1 1 1h18c0.552 0 1-0.448 1-1s-0.448-1-1-1z"/>
                </svg>
            </button>
            <div class="header-logo">
                <img alt="SafeDrive Insurance Logo" src="Images/logo.jpg"/>
                <h1>User Dashboard</h1>
            </div>
            <div class="header-actions">
                <button class="notification-button"><i class="fas fa-bell"></i></button>
                <div class="user-menu">
                    <button class="user-button">
                        <img alt="User Avatar" src="Images/user.jpg"/>
                        <span>User</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>
    <div class="container main-content">
        <nav class="navigation-bar">
            <ul class="sidebar">
                <li>
                    <button class="close-button" onclick="hidesidebar()" aria-label="Close sidebar">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path d="M18.3 5.71a1 1 0 0 0-1.42 0L12 10.59 7.12 5.71a1 1 0 0 0-1.42 1.42L10.59 12l-4.89 4.88a1 1 0 0 0 1.42 1.42L12 13.41l4.88 4.89a1 1 0 0 0 1.42-1.42L13.41 12l4.89-4.88a1 1 0 0 0 0-1.42z"/>
                        </svg>
                    </button>
                </li>
                <li><a href="Home.php">Home</a></li>
                <li><a href="#policies.php">Policies</a></li>
                <li><a href="claims.php">Claims History</a></li>
                <li><a href="contact.php">Support</a></li>
                <a href="logout.php">Logout</a>
            </ul>
        </nav>
        <main>
            <section class="vehicles-section" id="vehicles">
                <h2>Your Insured Vehicles</h2>
                <?php while ($vehicle = $vehicles->fetch_assoc()): ?>
                    <div class="vehicle-card">
                        <div class="vehicle-details">
                            <img alt="Thumbnail of <?php echo $vehicle['make'] . ' ' . $vehicle['model']; ?>" src="Images/vehicle_placeholder.jpg"/>
                            <div>
                                <h3><?php echo $vehicle['make'] . ', ' . $vehicle['model'] . ', ' . $vehicle['year']; ?></h3>
                                <p>Valuation: $<?php echo number_format($vehicle['valuation'], 2); ?></p>
                                <p>Status: <?php echo $vehicle['status']; ?></p>
                            </div>
                            <div class="vehicle-actions">
                                <button class="edit-button" onclick="location.href='edit_vehicle.php?id=<?php echo $vehicle['vehicle_id']; ?>'">Edit</button>
                                <button class="remove-button" onclick="if(confirm('Are you sure?')) location.href='remove_vehicle.php?id=<?php echo $vehicle['vehicle_id']; ?>'">Remove</button>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                <button class="add-button" onclick="location.href='add_vehicle.php'">Add New Car</button>
            </section>
            <section class="policies-section" id="policies">
                <h2>Your Active Policies</h2>
                <?php while ($policy = $policies->fetch_assoc()): ?>
                    <div class="policy-card">
                        <h3><?php echo $policy['policy_name']; ?></h3>
                        <p>Covered Car: <?php echo $policy['make'] . ' ' . $policy['model']; ?></p>
                        <p>Duration: <?php echo (strtotime($policy['end_date']) - strtotime($policy['start_date'])) / (60 * 60 * 24 * 30) . ' months (Exp: ' . date('M d, Y', strtotime($policy['end_date'])) . ')'; ?></p>
                        <button class="terminate-button" onclick="if(confirm('Are you sure?')) location.href='terminate_policy.php?id=<?php echo $policy['user_policy_id']; ?>'">Terminate Plan</button>
                    </div>
                <?php endwhile; ?>
            </section>
            <section class="claim-section">
    <h2>File a New Claim</h2>
    <div class="claim-form">
        <form action="file_claim.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="car-select">Select Insured Car</label>
                <select id="car-select" name="vehicle_id" required>
                    <?php
                    $stmt_vehicles->execute();
                    $vehicles = $stmt_vehicles->get_result();
                    while ($vehicle = $vehicles->fetch_assoc()):
                    ?>
                        <option value="<?php echo $vehicle['vehicle_id']; ?>"><?php echo $vehicle['make'] . ' ' . $vehicle['model']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="incident-date">Incident Date</label>
                <input id="incident-date" type="date" name="incident_date" required/>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="documents">Upload Documents</label>
                <input id="documents" type="file" name="documents"/>
            </div>
            <button type="submit" class="submit-button">Submit Claim</button>
        </form>
    </div>
</section>
            <section class="claims-history-section" id="claims">
    <h2>Claims History</h2>
    <div class="claims-table">
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
                <?php while ($claim = $claims->fetch_assoc()): ?>
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
                        <td>
                            <button class="view-button" onclick="location.href='view_claim.php?id=<?php echo $claim['claim_id']; ?>'">View</button>
                            <button class="pdf-button">PDF</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</section>
        </main>
    </div>
    <footer>
        <div class="container">
            <div class="footer-links">
                <a href="#">Contact Agent</a>
                <a href="#">FAQ</a>
                <a href="#">Terms of Service</a>
            </div>
            <button class="chat-button">Live Chat</button>
        </div>
    </footer>
    <script src="scripts.js"></script>
</body>
</html>