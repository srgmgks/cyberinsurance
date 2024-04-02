<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber Insurance Application</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .success-message {
            font-size: 1.2em;
            color: #007bff;
            margin-bottom: 20px;
        }
        .result-section {
            margin-bottom: 30px;
        }
        .result-section h3 {
            margin-bottom: 10px;
            color: #333;
        }
        .result-value {
            font-size: 1.1em;
            color: #28a745;
            margin-bottom: 15px;
        }
        .logout-button {
            margin-top: 30px;
        }
        .logout-button button {
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }
        .logout-button button:hover {
            background-color: #bd2130;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>HG CYBERGUARD</h2> <br>
        <?php
        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $name = $_POST["name"];
            $sum_insured = $_POST["sum_insured"];
            $data_protection_policy = $_POST["data_protection_policy"];
            $employee_compliance = $_POST["employee_compliance"];
            $compliance_check = $_POST["compliance_check"];
            $safe_harbor = $_POST["safe_harbor"];
            $data_protection_officer = $_POST["data_protection_officer"];
            $firewall = $_POST["firewall"];
            $anti_virus = $_POST["anti_virus"];
            $network_weakness = $_POST["network_weakness"];
            $monitor_breaches = $_POST["monitor_breaches"];
            $physical_security = $_POST["physical_security"];
            $payment_processing = $_POST["payment_processing"];
            $encryption_requirements = $_POST["encryption_requirements"];
            $backup_mission_critical = $_POST["backup_mission_critical"];
            $backup_data_assets = $_POST["backup_data_assets"];
            $background_checks = $_POST["background_checks"];
            $remote_authentication = $_POST["remote_authentication"];
            $outsourcing = $_POST["outsourcing"];
            $data_outsourcing = $_POST["data_outsourcing"];
            $data_protection_insurance = $_POST["data_protection_insurance"];
            $indemnification = $_POST["indemnification"];
            $outsourcers_compliance = $_POST["outsourcers_compliance"];
            $investigation_audit = $_POST["investigation_audit"];
            $subject_access_request = $_POST["subject_access_request"];
            $enforcement_notice = $_POST["enforcement_notice"];
            $potential_claim = $_POST["potential_claim"];

            // Connect to your database (replace with your database details)
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $dbname = "insurance";

            // Create a connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare SQL statement to insert data into the database
            $sql = "INSERT INTO cyber_insurance_application (
                name, sum_insured, data_protection_policy, employee_compliance, compliance_check, safe_harbor, 
                data_protection_officer, firewall, anti_virus, network_weakness, monitor_breaches, physical_security, 
                payment_processing, encryption_requirements, backup_mission_critical, backup_data_assets, background_checks, 
                remote_authentication, outsourcing, data_outsourcing, data_protection_insurance, indemnification, 
                outsourcers_compliance, investigation_audit, subject_access_request, enforcement_notice, potential_claim
            ) VALUES (
                '$name', '$sum_insured', '$data_protection_policy', '$employee_compliance', '$compliance_check', '$safe_harbor', 
                '$data_protection_officer', '$firewall', '$anti_virus', '$network_weakness', '$monitor_breaches', '$physical_security', 
                '$payment_processing', '$encryption_requirements', '$backup_mission_critical', '$backup_data_assets', '$background_checks', 
                '$remote_authentication', '$outsourcing', '$data_outsourcing', '$data_protection_insurance', '$indemnification', 
                '$outsourcers_compliance', '$investigation_audit', '$subject_access_request', '$enforcement_notice', '$potential_claim'
            )";

            // Execute the SQL statement
            if ($conn->query($sql) === TRUE) {
                echo "<div class='success-message'>Cyber Insurance Application Submitted Successfully!</div><br>";

                // Count the number of "no" responses
                $sql_no_count = "SELECT 
                                    SUM(IF(data_protection_policy = 'no', 1, 0)) +
                                    SUM(IF(employee_compliance = 'no', 1, 0)) +
                                    SUM(IF(compliance_check = 'no', 1, 0)) +
                                    SUM(IF(safe_harbor = 'no', 1, 0)) +
                                    SUM(IF(data_protection_officer = 'no', 1, 0)) +
                                    SUM(IF(firewall = 'no', 1, 0)) +
                                    SUM(IF(anti_virus = 'no', 1, 0)) +
                                    SUM(IF(network_weakness = 'no', 1, 0)) +
                                    SUM(IF(monitor_breaches = 'no', 1, 0)) +
                                    SUM(IF(physical_security = 'no', 1, 0)) +
                                    SUM(IF(payment_processing = 'no', 1, 0)) +
                                    SUM(IF(encryption_requirements = 'no', 1, 0)) +
                                    SUM(IF(backup_mission_critical = 'no', 1, 0)) +
                                    SUM(IF(backup_data_assets = 'no', 1, 0)) +
                                    SUM(IF(background_checks = 'no', 1, 0)) +
                                    SUM(IF(remote_authentication = 'no', 1, 0)) +
                                    SUM(IF(outsourcing = 'no', 1, 0)) +
                                    SUM(IF(data_outsourcing = 'no', 1, 0)) +
                                    SUM(IF(data_protection_insurance = 'no', 1, 0)) +
                                    SUM(IF(indemnification = 'no', 1, 0)) +
                                    SUM(IF(outsourcers_compliance = 'no', 1, 0)) +
                                    SUM(IF(investigation_audit = 'no', 1, 0)) +
                                    SUM(IF(subject_access_request = 'no', 1, 0)) +
                                    SUM(IF(enforcement_notice = 'no', 1, 0)) +
                                    SUM(IF(potential_claim = 'no', 1, 0)) AS no_count 
                                FROM cyber_insurance_application";
                
                $result = $conn->query($sql_no_count);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $noCount = $row["no_count"];
                } else {
                    $noCount = 0;
                }

                // Calculate total questions
                $totalQuestions = 25; // Assuming there are 25 questions

                // Calculate risk score
                $riskScore = $noCount / $totalQuestions;

                // Calculate premium amount
                $premiumAmount = $riskScore * $sum_insured;

                

                // Print risk score and premium amount
                echo "<div class='result-section'>";
                echo "<h3>Vulnerability</h3> <br>";
                echo "<div class='result-value'>Risk Score = " . round($riskScore * 100, 2) . "%</div>";
                echo "</div>";

                echo "<div class='result-section'>";
                echo "<h3>To safeguard the system</h3> <br>";
                echo "<div class='result-value'>Premium Amount = Rs." . round($premiumAmount, 2) . "</div>";
                echo "</div>";

                // Store risk score and premium amount in the database
                $roundedRiskScore = round($riskScore * 100, 2);
                $roundedPremiumAmount = round($premiumAmount, 2);

                // Prepare SQL statement to store risk score and premium amount in the database
                $sql_store_info = "INSERT INTO insurance_info (username, risk_score, premium_amount) VALUES ('$name', '$roundedRiskScore', '$roundedPremiumAmount')";
                if ($conn->query($sql_store_info) === TRUE) 
                {
                    
                } else 
                {
                    echo "<div class='error-message'>Error in storing risk score and premium amount: " . $conn->error . "</div>";
                }

            } else {
                echo "<div class='error-message'>Error: " . $sql . "<br>" . $conn->error . "</div>";
            }

            // Close the database connection
            $conn->close();
        }
        ?>
        <div class="logout-button">
            <form action="logout.php" method="post">
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>
</body>
</html>
