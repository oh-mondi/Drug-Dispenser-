<!DOCTYPE html>
<html>
<head>
    <title>Prescription Orders</title>
    <style>
        /* CSS for the sidebar */
        .sidebar {
            width: 200px;
            height: 100vh;
            background-color: #40E0D0; /* Turquoise Blue */
            color: white;
            padding-top: 20px;
            position: fixed;
            top: 0;
            left: 0;
            transition: width 0.3s ease;
        }

        .sidebar.collapsed {
            width: 60px;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .sidebar li {
            margin-bottom: 10px;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px;
            font-weight: bold;
        }

        .sidebar a:hover {
            background-color: #008080; /* Dark Turquoise Blue */
        }

        /* CSS for the main content */
        .main-content {
            margin-left: 200px;
            padding: 20px;
        }

        /* CSS for the heading */
        h1 {
            color: #40E0D0; /* Turquoise Blue */
            text-align: center;
            margin-top: 50px;
        }

        /* CSS for the table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #40E0D0; /* Turquoise Blue */
            color: white;
            font-weight: bold;
        }

        /* CSS for the toggle button */
        .toggle-button {
            background-color: transparent;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 24px;
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
        }

        .toggle-button svg {
            width: 24px;
            height: 24px;
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <ul>
            <li><a href="pharmacy.php">Home</a></li>
            <li><a href="drug_management.php">Drug management</a></li>
            <li><a href="inventory.php">Inventory</a></li>
            <li><a href="dispense_history.php">History</a></li>
            <li><a href="#" onclick="logout()">Logout</a></li>
        </ul>
    </div>

    <button class="toggle-button" onclick="toggleSidebar()">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z" fill="#fff"/> <!-- White -->
        </svg>
    </button>

    <div class="main-content" id="mainContent">
       

        <h1>Dispense Drugs</h1>

<?php
require_once("database.php");

// Check if the prescription ID is provided in the query parameter
if (isset($_GET["prescriptionId"])) {
    $prescriptionId = $_GET["prescriptionId"];

    // Retrieve prescription information
    $query = "SELECT * FROM prescription WHERE PRESCRIPTION_ID = '$prescriptionId'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $prescription = mysqli_fetch_assoc($result);

        // Display prescription details
        echo "<h2>Prescription Details</h2>";
        echo "<p><strong>Prescription ID:</strong> " . $prescription["PRESCRIPTION_ID"] . "</p>";
        echo "<p><strong>Patient Username:</strong> " . $prescription["PATIENT_USERNAME"] . "</p>";
        echo "<p><strong>Doctor Username:</strong> " . $prescription["DOCTOR_USERNAME"] . "</p>";
        echo "<p><strong>Drug ID:</strong> " . $prescription["DRUG_ID"] . "</p>";
        echo "<p><strong>Prescription Date:</strong> " . $prescription["PRESCRIPTION_DATE"] . "</p>";
        echo "<p><strong>Dosage:</strong> " . $prescription["DOSAGE"] . "</p>";
        echo "<p><strong>Instruction:</strong> " . $prescription["INSTRUCTION"] . "</p>";

        // Form to enter the quantity and dispense date
        echo "<h2>Dispense Drugs</h2>";
        echo "<form action='process_dispense.php' method='post'>";
        echo "<input type='hidden' name='prescriptionId' value='$prescriptionId'>";
        echo "<label for='quantity'>Quantity:</label>";
        echo "<input type='number' name='quantity' id='quantity' min='1' required><br>";
        echo "<label for='dispenseDate'>Dispense Date:</label>";
        echo "<input type='date' name='dispenseDate' id='dispenseDate' required><br>";
        echo "<input type='submit' value='Dispense'>";
        echo "</form>";
    } else {
        echo "Invalid prescription ID.";
    }
} else {
    echo "Prescription ID not provided.";
}

// Close the database connection
mysqli_close($conn);
?>
    </div>

    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("collapsed");
        }

        function logout() {
            // Perform logout actions
        }
    </script>
</body>
</html>
