<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insurance Seller Dashboard</title>
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
            padding: 10px 15px; /* Increased padding */
            margin: 0 10px; /* Adjusted margin */
            border: 2px solid transparent; /* Added border */
            border-radius: 8px; /* Increased border radius */
            cursor: pointer;
            transition: background-color 0.3s, border-color 0.3s; /* Added transition for border */
            font-size: 16px; /* Increased font size */
        }
        .accept-button, .decline-button {
            padding: 5px 20px; /* Increased padding for accept and decline buttons */
            font-size: 18px; /* Increased font size for accept and decline buttons */
        }
        .accept-button {
            background-color: #4CAF50;
            color: white;
        }
        .accept-button:hover {
            background-color: #45a049;
            border-color: #45a049; /* Change border color on hover */
        }
        .decline-button {
            background-color: #f44336;
            color: white;
        }
        .decline-button:hover {
            background-color: #db4436;
            border-color: #db4436; /* Change border color on hover */
        }
        /* CSS for percentage circle */
        .risk-score-circle {
            width: 80px; /* Increased width */
            height: 80px; /* Increased height */
            border-radius: 50%;
            background-color: transparent;
            position: relative;
            border: 2px solid #ddd; /* Default border color */
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .risk-score-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 23px;
            color: #333; /* Text color */
        }
        /* Colors based on risk levels */
        .risk-score-circle[data-risk='very-low'] {
            border-color: blue; /* Blue for very low risk */
        }
        .risk-score-circle[data-risk='low'] {
            border-color: yellow; /* Yellow for low risk */
        }
        .risk-score-circle[data-risk='medium'] {
            border-color: orange; /* Orange for medium risk */
        }
        .risk-score-circle[data-risk='high'] {
            border-color: red; /* Red for high risk */
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
        .risk-score-circle[data-risk] {
            animation: pulse 1.5s infinite; /* Apply animation */
        }
    </style>
</head>
<body>
    <?php
    session_start();

    if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'seller') {
        header("Location: login.html");
        exit();
    }

    $username = $_SESSION['username'];
    ?>
    <div class="container">
        <div class="welcome">
            <h2>Welcome, <?php echo $username; ?> [Insurance Seller]</h2>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Risk Score</th>
                        <th>Premium Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $servername = "localhost";
                    $username_db = "root";
                    $password_db = "root";
                    $dbname = "insurance";

                    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT * FROM insurance_info";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Determine risk level
                            $risk_score = $row["risk_score"];
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
                            // Display table row
                            echo "<tr>";
                            echo "<td>".$row["username"]."</td>";
                            echo "<td><div class='risk-score-circle' data-risk='".$risk_level."'><span class='risk-score-text'>".$row["risk_score"]."%</span></div></td>";
                            echo "<td>Rs.".$row["premium_amount"]."</td>";
                            echo "<td>";
                            echo "<form action='process_application.php' method='POST'>";
                            echo "<input type='hidden' name='username' value='".$row["username"]."'>";
                            echo "<button class='action-buttons accept-button' type='submit' name='accept'>Accept</button>";
                            echo "&nbsp;"; 
                            echo "&nbsp;";
                            echo "&nbsp;";
                            echo "&nbsp;";
                            echo "&nbsp;";
                            echo "<button class='action-buttons decline-button' type='submit' name='decline'>Decline</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No buyers have applied for insurance yet.</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
        <div class="action-buttons">
            <button onclick="location.href='logout.php';">Logout</button>
        </div>
    </div>
</body>
</html>
