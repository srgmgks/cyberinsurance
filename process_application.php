<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "localhost"; // Assuming the database is hosted locally
    $username_db = "root"; // Your MySQL username
    $password_db = "root"; // Your MySQL password
    $dbname = "insurance"; // Your database name

    // Create connection
    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST['accept'])) {
        // Accept the application
        $buyerUsername = $_POST['username'];
        $sql = "UPDATE insurance_info SET status = 'Accepted' WHERE username = '$buyerUsername'";
        if ($conn->query($sql) === TRUE) {
            $message = "Application accepted for $buyerUsername";
        } else {
            $message = "Error accepting application: " . $conn->error;
        }
    } elseif (isset($_POST['decline'])) {
        // Decline the application
        $buyerUsername = $_POST['username'];
        $sql = "UPDATE insurance_info SET status = 'Declined' WHERE username = '$buyerUsername'";
        if ($conn->query($sql) === TRUE) {
            $message = "Application declined for $buyerUsername";
        } else {
            $message = "Error declining application: " . $conn->error;
        }
    }

    // Display the alert message and redirect
    echo "<script>alert('$message'); window.location.href = 'seller_dashboard.php';</script>";

    // Close connection
    $conn->close();
}
?>
