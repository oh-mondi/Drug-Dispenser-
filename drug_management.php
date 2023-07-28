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
       

        

        <h1>Drug Management</h1>

<?php
require_once("database.php");

// Function to delete a drug
function deleteDrug($conn, $drugId) {
    $query = "DELETE FROM drugs WHERE DRUG_ID = '$drugId'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Drug deleted successfully.";
    } else {
        echo "Error deleting drug: " . mysqli_error($conn);
    }
}

// Handle drug deletion
if (isset($_GET['deleteDrugId'])) {
    $deleteDrugId = $_GET['deleteDrugId'];
    deleteDrug($conn, $deleteDrugId);
}

// Retrieve drugs data from the database
$query = "SELECT * FROM drugs";
$result = mysqli_query($conn, $query);

// Check if there are any drugs
if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr><th>Drug ID</th><th>Chemical Name</th><th>Mass</th><th>Price</th><th>Actions</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["DRUG_ID"] . "</td>";
        echo "<td>" . $row["CHEMICAL_NAME"] . "</td>";
        echo "<td>" . $row["MASS"] . "</td>";
        echo "<td>" . $row["PRICE"] . "</td>";
        echo "<td>
                  <a href='inventory.php?drugId=" . $row["DRUG_ID"] . "'>Add to Inventory</a> |
                  <a href='?editDrugId=" . $row["DRUG_ID"] . "'>Edit</a> |
                  <a href='?deleteDrugId=" . $row["DRUG_ID"] . "' onclick='return confirm(\"Are you sure you want to delete this drug?\")'>Delete</a>
              </td>";
        echo "</tr>";

        // Check if the current drug is being edited
        if (isset($_GET['editDrugId']) && $_GET['editDrugId'] == $row["DRUG_ID"]) {
            echo "<tr>";
            echo "<td colspan='4'>";
            echo "<form id='editForm' action='process_edit.php' method='post'>";
            echo "<input type='hidden' name='editDrugId' value='" . $row["DRUG_ID"] . "'>";
            echo "<label for='editChemicalName'>Chemical Name:</label>";
            echo "<input type='text' id='editChemicalName' name='editChemicalName' value='" . $row["CHEMICAL_NAME"] . "'>";
            echo "<label for='editMass'>Mass:</label>";
            echo "<input type='text' id='editMass' name='editMass' value='" . $row["MASS"] . "'>";
            echo "<label for='editPrice'>Price:</label>";
            echo "<input type='number' id='editPrice' name='editPrice' step='0.01' value='" . $row["PRICE"] . "'>";
            echo "<input type='submit' value='Save'>";
            echo "<button type='button' onclick='cancelEdit()'>Cancel</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
} else {
    echo "<p>No drugs found.</p>";
}

// Close the database connection
mysqli_close($conn);
?>

<div>
    <button onclick="location.href='add_drug.php'">Add Drugs</button>
</div>

    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("collapsed");
        }

        function logout() {
            // Perform logout actions
        }
        function cancelEdit() {
            window.location.href = 'drug_management.php';
        }
    </script
</body>
</html>
