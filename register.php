<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "localhost"; // Assuming the database is hosted locally
    $username = "root"; // Your MySQL username
    $password = "root"; // Your MySQL password
    $dbname = "insurance"; // Your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Function to sanitize input data
    function sanitize_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Process insurance seller registration
    if (isset($_POST['sellerUsername']) && isset($_POST['sellerPassword'])) {
        $sellerUsername = sanitize_input($_POST['sellerUsername']);
        $sellerPassword = sanitize_input($_POST['sellerPassword']);

        // Insert into seller_register table
        $sql = "INSERT INTO seller_register (username, password) VALUES ('$sellerUsername', '$sellerPassword')";

        if ($conn->query($sql) === TRUE) {
            echo "Insurance seller registered successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Process insurance buyer registration
    if (isset($_POST['buyerUsername']) && isset($_POST['buyerPassword'])) {
        $buyerUsername = sanitize_input($_POST['buyerUsername']);
        $buyerPassword = sanitize_input($_POST['buyerPassword']);

        // Insert into buyer_register table
        $sql = "INSERT INTO buyer_register (username, password) VALUES ('$buyerUsername', '$buyerPassword')";

        if ($conn->query($sql) === TRUE) {
            echo "Insurance buyer registered successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Close connection
    $conn->close();
}
?>

