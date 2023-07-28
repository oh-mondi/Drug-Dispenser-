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
            <li><a href="pharmacy.php">Pharmacy</a></li>
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

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the prescription ID and quantity from the form data
    $prescriptionId = $_POST["prescriptionId"];
    $quantity = $_POST["quantity"];

    // Retrieve the drug ID from the prescription
    $query = "SELECT DRUG_ID FROM prescription WHERE PRESCRIPTION_ID = '$prescriptionId'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $drugId = $row["DRUG_ID"];

        // Check if the drug exists in the inventory
        $inventoryQuery = "SELECT QUANTITY FROM inventory WHERE DRUG_ID = '$drugId'";
        $inventoryResult = mysqli_query($conn, $inventoryQuery);

        if (mysqli_num_rows($inventoryResult) === 1) {
            $inventoryRow = mysqli_fetch_assoc($inventoryResult);
            $currentQuantity = $inventoryRow["QUANTITY"];

            if ($currentQuantity >= $quantity) {
                // Update the quantity in the inventory
                $updatedQuantity = $currentQuantity - $quantity;
                $updateQuery = "UPDATE inventory SET QUANTITY = '$updatedQuantity' WHERE DRUG_ID = '$drugId'";
                $updateResult = mysqli_query($conn, $updateQuery);

                if ($updateResult) {
                    // Insert dispense data into the dispensed_drugs table
                    $dispenseDate = date("Y-m-d"); // Get the current date
                    $insertQuery = "INSERT INTO dispensed_drugs (PRESCRIPTION_ID, DRUG_ID, QUANTITY, DATE_DISPENSED)
                                    VALUES ('$prescriptionId', '$drugId', '$quantity', '$dispenseDate')";
                    $insertResult = mysqli_query($conn, $insertQuery);

                    if ($insertResult) {
                        echo "<script>alert('Dispensed $quantity units of drug $drugId successfully!');</script>";
                echo "<script>window.location.href = 'dispense_history.php';</script>";
                    } else {
                        echo "<script>alert('Error inserting dispense data!');</script>";
                echo "<script>window.location.href = 'patient_drug.php';</script>";
                exit;
                    }
                } else {
                echo "<script>alert('Error updating the inventory!');</script>";
                echo "<script>window.location.href = 'patient_drug.php';</script>";
                exit;  }
            } else {
         
                echo "<script>alert('Insufficient quantity in the inventory!');</script>";
                echo "<script>window.location.href = 'patient_drug.php';</script>";
                exit;
             }
        } else {
           
            echo "<script>alert('Drug not found in the inventory!');</script>";
        echo "<script>window.location.href = 'patient_drug.php';</script>";
        exit;
        }
    } else {
      
        echo "<script>alert('Prescription not found!');</script>";
        echo "<script>window.location.href = 'patient_drug.php';</script>";
        exit;    }
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
