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

// Retrieve dispense history from the dispensed_drugs table
$query = "SELECT dd.PRESCRIPTION_ID, dd.DRUG_ID, d.CHEMICAL_NAME, dd.QUANTITY, dd.DATE_DISPENSED
          FROM dispensed_drugs dd
          INNER JOIN drugs d ON dd.DRUG_ID = d.DRUG_ID
          ORDER BY dd.DATE_DISPENSED DESC";
$result = mysqli_query($conn, $query);

// Check if there are any dispense records
if (mysqli_num_rows($result) > 0) {
    echo "<h2>Dispense History</h2>"; // Title for the table

    echo "<table>";
    echo "<tr><th>Prescription ID</th><th>Drug ID</th><th>Chemical Name</th><th>Quantity</th><th>Date Dispensed</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["PRESCRIPTION_ID"] . "</td>";
        echo "<td>" . $row["DRUG_ID"] . "</td>";
        echo "<td>" . $row["CHEMICAL_NAME"] . "</td>";
        echo "<td>" . $row["QUANTITY"] . "</td>";
        echo "<td>" . $row["DATE_DISPENSED"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No dispense history found.</p>";
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
