<!DOCTYPE html>
<html>
<head>
    <title>Prescription History</title>
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
            background-color: white;
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

        table th,
        table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #40E0D0; /* Turquoise Blue */
            color: white;
            font-weight: bold;
        }

        table td {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <ul>
            <li><a href="patient.php">Home</a></li>
            <li><a href="appointments.php">Appointments</a></li>
            <li><a href="patient_prescription.php">Prescriptions</a></li>
            <li><a href="user_management.php">User Management</a></li>
            <li style="margin-top: auto;"><a href="#" onclick="Logout()">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Prescription History</h1>

        <?php
        require_once("database.php");

        session_start();

        // Check if the patient username is set in the session
        if (isset($_SESSION["user_name"])) {
            $patientUsername = $_SESSION["user_name"];

            // Query to retrieve the prescriptions for the specific patient
            $query = "SELECT * FROM prescription WHERE PATIENT_USERNAME = '$patientUsername'";
            $result = mysqli_query($conn, $query);

            // Check if there are any prescriptions
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr><th>Prescription ID</th><th>Doctor Username</th><th>Drug ID</th><th>Prescription Date</th><th>Dosage</th><th>Instruction</th></tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["PRESCRIPTION_ID"] . "</td>";
                    echo "<td>" . $row["DOCTOR_USERNAME"] . "</td>";
                    echo "<td>" . $row["DRUG_ID"] . "</td>";
                    echo "<td>" . $row["PRESCRIPTION_DATE"] . "</td>";
                    echo "<td>" . $row["DOSAGE"] . "</td>";
                    echo "<td>" . $row["INSTRUCTION"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No prescriptions found for the patient.</p>";
            }
        } else {
            echo "<p>Patient session not found. Please login again.</p>";
        }

        // Close the database connection
        mysqli_close($conn);
        ?>
    </div>

    <script>
        function Logout() {
            // Display confirmation alert
            if (confirm("Are you sure you want to end the session?")) {
                // Destroy the session
                window.location.href = "loginform.html";
            }
        }
    </script>
</body>
</html>
