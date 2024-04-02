<?php
session_start(); // Start the session

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

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

// Fetch premium_amount and risk_score from the database
$sql = "SELECT premium_amount, risk_score FROM insurance_info WHERE username = '$username'";
$result = $conn->query($sql);

$premium_amount = 0; // Default value
$risk_score = 0; // Default value

if ($result->num_rows > 0) {
    // Output data of the first row (assuming username is unique)
    $row = $result->fetch_assoc();
    $premium_amount = $row["premium_amount"];
    $risk_score = $row["risk_score"];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment Gateway</title>
<style>
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f4f4f4;
  }
  .payment-form {
    width: 400px;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  .grid-container {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    grid-gap: 20px;
    margin-bottom: 20px;
  }
  .grid-item {
    background-color: #f0f0f0;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    cursor: pointer;
  }
  .grid-item:hover {
    background-color: #e0e0e0;
  }
  .selected {
    background-color: #007bff;
    color: #fff;
  }
  button {
    width: 100%;
    padding: 10px 20px;
    background-color: #000000; 
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    margin-top: 10px; /* Added margin-top */
  }
  button:hover {
    background-color: #f57c00; /* Darker shade of orange on hover */
  }
  .details-container {
    display: none;
    margin-top: 20px;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
  }
  .details-container.active {
    display: block;
  }
  .details input, select {
    width: calc(100% - 20px);
    margin-bottom: 10px;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
  }
  #qrCodeContainer {
    text-align: center;
    margin-bottom: 20px;
  }
</style>
</head>
<body>
<div class="payment-form">
  <h2>Select Payment Gateway</h2>
  <p>Premium Amount = Rs.<?php echo $premium_amount; ?></p>
  
  <div class="grid-container">
    <div class="grid-item" onclick="selectGateway('creditCard')" id="creditCardItem">
      <p>Credit Card</p>
    </div>
    <div class="grid-item" onclick="selectGateway('debitCard')" id="debitCardItem">
      <p>Debit Card</p>
    </div>
    <div class="grid-item" onclick="selectGateway('netbanking')" id="netbankingItem">
      <p>Net Banking</p>
    </div>
    <div class="grid-item" onclick="selectGateway('upi')" id="upiItem">
      <p>UPI</p>
    </div>
  </div>

  <div id="detailsContainer" class="details-container">
    <!-- Details will be dynamically added here -->
  </div>
  
  <div id="qrCodeContainer" style="display: none;">
    <!-- QR code will be dynamically added here -->
  </div>

  <button id="payButton" style="display: none;" onclick="payNow()">Pay Now</button>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
  function selectGateway(gateway) {
    var selectedGateway = gateway;
    
    // Remove 'selected' class from all grid items
    var gridItems = document.querySelectorAll('.grid-item');
    gridItems.forEach(function(item) {
      item.classList.remove('selected');
    });
    
    // Add 'selected' class to the clicked grid item
    var selectedItem = document.getElementById(selectedGateway + 'Item');
    selectedItem.classList.add('selected');
    
    showDetails(selectedGateway);
  }

  function showDetails(gateway) {
    var detailsContainer = document.getElementById('detailsContainer');
    detailsContainer.innerHTML = ''; // Clear existing content
    
    var details = document.createElement('div');
    details.classList.add('details');
    
    switch (gateway) {
      case 'creditCard':
        details.innerHTML = `
          <input type="text" placeholder="Cardholder Name" required>
          <input type="text" placeholder="Card Number" required>
          <select required>
            <option value="" disabled selected>Expiry Month</option>
            <option value="01">01</option>
            <option value="02">02</option>
            <option value="03">03</option>
            <option value="04">04</option>
            <option value="05">05</option>
            <option value="06">06</option>
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <!-- Add more months as needed -->
          </select>
          <select required>
            <option value="" disabled selected>Expiry Year</option>
            <option value="2024">2024</option>
            <option value="2025">2025</option>
            <option value="2026">2026</option>
            <option value="2027">2027</option>
            <option value="2028">2028</option>
            <option value="2029">2029</option>
            <option value="2030">2030</option>
            <!-- Add more years as needed -->
          </select>
          <input type="text" placeholder="CVV" required>
        `;
        break;
      case 'debitCard':
        details.innerHTML = `
          <input type="text" placeholder="Cardholder Name" required>
          <input type="text" placeholder="Card Number" required>
          <select required>
            <option value="" disabled selected>Expiry Month</option>
            <option value="01">01</option>
            <option value="02">02</option>
            <option value="03">03</option>
            <option value="04">04</option>
            <option value="05">05</option>
            <option value="06">06</option>
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <!-- Add more months as needed -->
          </select>
          <select required>
            <option value="" disabled selected>Expiry Year</option>
            <option value="2024">2024</option>
            <option value="2025">2025</option>
            <option value="2026">2026</option>
            <option value="2027">2027</option>
            <option value="2028">2028</option>
            <option value="2029">2029</option>
            <option value="2030">2030</option>
            <!-- Add more years as needed -->
          </select>
          <input type="text" placeholder="CVV" required>
        `;
        break;
      case 'netbanking':
        details.innerHTML = `
          <input type="text" placeholder="Bank Name" required>
          <input type="text" placeholder="Username" required>
          <input type="password" placeholder="Password" required>
        `;
        break;
      case 'upi':
        details.innerHTML = `
          <input type="text" placeholder="UPI ID" required>
        `;
        break;
    }
    
    detailsContainer.appendChild(details);
    detailsContainer.classList.add('active');

    if (gateway === 'upi') {
      showQRCode('Cyber Insurance');
    } else {
      document.getElementById('qrCodeContainer').style.display = 'none';
    }
    
    document.getElementById('payButton').style.display = 'block';
  }

  function showQRCode(text) {
    var qrCodeContainer = document.getElementById('qrCodeContainer');
    qrCodeContainer.innerHTML = ''; // Clear existing content
    
    var qrCode = new QRCode(qrCodeContainer, {
      text: text,
      width: 200,
      height: 200
    });

    qrCodeContainer.style.display = 'block';
  }

  function payNow() {
    var inputs = document.querySelectorAll('.details input, .details select');
    var isValid = true;
    inputs.forEach(function(input) {
      if (!input.checkValidity()) {
        isValid = false;
      }
    });

    if (isValid) {
      // Your payment processing logic goes here
      var transactionId = generateTransactionId(); // Generate a unique transaction ID
      var successMessage = 'Cyber insurance payment successfully done! <br><br>' +
                     'Username = <?php echo $username; ?> <br><br>' +
                     'Risk score = <?php echo $risk_score; ?>% <br><br>' +
                     'Premium amount paid = Rs.<?php echo $premium_amount; ?> <br><br>' +
                     'Transaction ID = ' + transactionId;

      var receiptButton = '<button onclick="printReceipt()">Payment Receipt</button>';
      var vulnerabilityReportButton = '<button onclick="fetchVulnerabilityReport()">Vulnerability Report</button>';
      var logoutButton = '<div class="action-buttons"><button onclick="location.href=\'logout.php\';">Logout</button></div>';
      var paymentDetails = document.createElement('p');
      paymentDetails.innerHTML = successMessage + '<br>' + receiptButton + vulnerabilityReportButton + logoutButton;
      document.body.innerHTML = ''; // Clear the current page content
      document.body.appendChild(paymentDetails); // Append payment details to the body
    } else {
      alert('Enter all fields.');
    }
  }


  function fetchVulnerabilityReport() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var vulnerabilities = xhr.responseText;
            alert("Vulnerabilities in the system\n\n" + vulnerabilities);
        }
    };
    xhr.open("GET", "fetch_vulnerability_report.php", true);
    xhr.send();
  }


  function generateTransactionId() {
    // Generate a random numeric transaction ID
    var transactionId = '';
    for (var i = 0; i < 10; i++) {
      transactionId += Math.floor(Math.random() * 10); // Random number from 0 to 9
    }
    return transactionId;
  }

  function printReceipt() {
    window.print(); // Print the receipt
  }
</script>
</body>
</html>

