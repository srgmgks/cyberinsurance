<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

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

    // Check if the user is a seller
    $sql_seller = "SELECT * FROM seller_register WHERE username='$username' AND password='$password'";
    $result_seller = $conn->query($sql_seller);
    if ($result_seller->num_rows > 0) {
        $_SESSION['user_type'] = 'seller';
        $_SESSION['username'] = $username;
        header("Location: seller_dashboard.php");
        exit();
    }

    // Check if the user is a buyer
    $sql_buyer = "SELECT * FROM buyer_register WHERE username='$username' AND password='$password'";
    $result_buyer = $conn->query($sql_buyer);
    if ($result_buyer->num_rows > 0) {
        $_SESSION['user_type'] = 'buyer';
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit();
    }

    // Invalid credentials
    echo "Invalid username or password";
    $conn->close();
    exit();
}

// If not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.html"); // You can choose any login page
    exit();
}

// Display welcome message based on user type
$user_type = $_SESSION['user_type'];
$username = $_SESSION['username'];

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

// Fetch application status for buyer
if ($user_type === 'buyer') {
    // Fetch application status
    $buyerUsername = $_SESSION['username'];
    $sql_status = "SELECT status FROM insurance_info WHERE username='$buyerUsername'";
    $result_status = $conn->query($sql_status);
    if ($result_status->num_rows > 0) {
        $row = $result_status->fetch_assoc();
        $application_status = $row['status'];
    } else {
        $application_status = "Not found";
    }

    // Fetch risk score and premium amount
    $sql_info = "SELECT risk_score, premium_amount FROM insurance_info WHERE username='$buyerUsername'";
    $result_info = $conn->query($sql_info);
    if ($result_info->num_rows > 0) {
        $row = $result_info->fetch_assoc();
        $risk_score = $row['risk_score'];
        $premium_amount = $row['premium_amount'];

        // Determine risk level
        $risk_level = '';
        if ($risk_score >= 1 && $risk_score <= 20) {
            $risk_level = 'very-low';
        } elseif ($risk_score >= 21 && $risk_score <= 50) {
            $risk_level = 'low';
        } elseif ($risk_score >= 51 && $risk_score <= 80) {
            $risk_level = 'medium';
        } elseif ($risk_score >= 81 && $risk_score <= 100) {
            $risk_level = 'high';
        }
    } else {
        $risk_score = "Not found";
        $premium_amount = "Not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .welcome {
            text-align: center;
            margin-bottom: 20px;
        }
        .table-container {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .action-buttons {
            text-align: center;
            margin-top: 20px;
        }
        .action-buttons button {
            padding: 10px 15px; 
            margin: 0 10px; 
            border: 2px solid transparent; 
            border-radius: 8px; 
            cursor: pointer;
            transition: background-color 0.3s, border-color 0.3s; 
            font-size: 16px; 
            background-color: #4CAF50; /* Green */
            color: white;
        }
        .action-buttons button:hover {
            background-color: #45a049;
            border-color: #45a049;
        }
        .logout-button {
            background-color: #f44336; /* Red */
        }
        .logout-button:hover {
            background-color: #db4436;
            border-color: #db4436;
        }
        /* CSS for percentage circle */
        .risk-score-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: transparent;
            position: relative;
            border: 2px solid #ddd;
            display: flex;
            justify-content: center;
            align-items: center;
            animation: pulse 1.5s infinite;
        }
        .risk-score-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 23px;
            color: #333;
        }
        /* Colors based on risk levels */
        .risk-score-circle[data-risk='very-low'] {
            border-color: blue;
        }
        .risk-score-circle[data-risk='low'] {
            border-color: yellow;
        }
        .risk-score-circle[data-risk='medium'] {
            border-color: orange;
        }
        .risk-score-circle[data-risk='high'] {
            border-color: red;
        }
        /* Animation for risk score circle */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
            }
        }

        /* Styles for sum insured slider container */
        .slidecontainer {
            width: 80%;
            margin: 0 auto;
            text-align: center;
        }

        .slidecontainer p {
            font-size: 20px;
        }

        .slidecontainer input[type=range] {
            width: 100%;
        }

        .slidecontainer span {
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome">
            <h2>Welcome, <?php echo $username; ?> [Insurance Buyer]</h2>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Application Status</th>
                        <th>Risk Score</th>
                        <th>Premium Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $application_status; ?></td>
                        <td><div class="risk-score-circle" data-risk="<?php echo $risk_level; ?>"><span class="risk-score-text"><?php echo $risk_score; ?>%</span></div></td>
                        <td>Rs.<?php echo $premium_amount; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <br>
        
        <br>
        
        <div class="action-buttons">
            <button onclick="scanDocument()">Scan</button>
            <?php if ($application_status === 'Accepted') { ?>
                <button onclick="openNewTab()">Proceed to Payment</button>
            <?php } ?>
        </div>
        <div class="action-buttons">
            <form action="logout.php" method="POST">
                <button class="logout-button" type="submit">Logout</button>
            </form>
        </div>
    </div>

    <script>
       

        function scanDocument() 
        {
            // Redirect to ci_app.html in a new tab
            window.open('ci_app.html', '_blank');

            // Display risk score and premium amount
            //var riskScore = Math.floor(Math.random() * 100);
            //var premiumAmount = Math.floor(Math.random() * 1000) + 500;
            //var message = "Vulnerability Risk Score = " + riskScore + "%\nPremium Amount [To safeguard the system] = Rs." + premiumAmount;
            //alert(message);
            
            // Perform AJAX call to store risk score and premium amount
            //var xhttp = new XMLHttpRequest();
            //xhttp.onreadystatechange = function() {
             //   if (this.readyState == 4 && this.status == 200) {
             //       console.log(this.responseText);
             //   }
            //};
            //xhttp.open("POST", "store_insurance_info.php", true);
            //xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            //xhttp.send("riskScore=" + riskScore + "&premiumAmount=" + premiumAmount);
        }

        function openNewTab() {
            window.open('payment.php', '_blank');
        }
    </script>
</body>
</html>
