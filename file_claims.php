<?php
include 'session_check.php';
include 'db_connect.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $vehicle_id = $_POST['vehicle_id'];
    $incident_date = $_POST['incident_date'];
    $description = $_POST['description'];
    $document_path = NULL; // Default to NULL if no file is uploaded

    // Handle file upload
    if (isset($_FILES['documents']) && $_FILES['documents']['error'] != UPLOAD_ERR_NO_FILE) {
        $file = $_FILES['documents'];
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];
        $file_error = $file['error'];

        // Validate the file
        $allowed_types = ['application/pdf', 'image/jpeg', 'image/png']; // Allowed MIME types
        $max_size = 5 * 1024 * 1024; // 5MB max size
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $file_mime = mime_content_type($file_tmp);

        if ($file_error === UPLOAD_ERR_OK) {
            if (!in_array($file_mime, $allowed_types)) {
                die("Error: Only PDF, JPEG, and PNG files are allowed.");
            }
            if ($file_size > $max_size) {
                die("Error: File size exceeds 5MB limit.");
            }

            // Create uploads directory if it doesn't exist
            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Generate a unique filename to avoid overwriting
            $unique_name = 'claim_' . time() . '_' . uniqid() . '.' . $file_ext;
            $document_path = $upload_dir . $unique_name;

            // Move the file to the uploads directory
            if (!move_uploaded_file($file_tmp, $document_path)) {
                die("Error: Failed to move uploaded file.");
            }
        } else {
            die("Error uploading file: " . $file_error);
        }
    }

    // Insert claim into database
    $sql = "INSERT INTO claims (user_id, vehicle_id, incident_date, description, status, created_at, document_path) 
            VALUES (?, ?, ?, ?, 'pending', NOW(), ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisss", $user_id, $vehicle_id, $incident_date, $description, $document_path);

    if ($stmt->execute()) {
        header("Location: Userdashboard.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
