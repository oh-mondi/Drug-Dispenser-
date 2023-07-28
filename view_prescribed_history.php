<!DOCTYPE html>
<html>
<head>
    <title>View Prescribed Drugs</title>
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
        h1, h2 {
            color: #40E0D0; /* Turquoise Blue */
            text-align: center;
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
        <button class="toggle-button" onclick="toggleSidebar()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/>
            </svg>
        </button>
        <ul>
        <li><a href="doctor.php">Home</a></li>
            <li><a href="doctors_appointments.php">Appointments</a></li>
            <li><a href="doctors_patients.php">Patients</a></li>
            <li style="margin-top: auto;"><a href="#" onclick="Logout()">Logout</a></li>
        </ul>
    </div>

  

    <div class="main-content" id="mainContent">
        <h1>View Prescribed Drugs</h1>

        <?php
        require_once("database.php");

        session_start();

        // Check if the username is set in the session
        if (isset($_SESSION["user_name"])) {
            // Retrieve the patient's username from the URL parameter
            $patientUsername = $_GET["patientUsername"];

            // Query to retrieve the prescribed drugs for the specific patient
            $query = "SELECT p.PATIENT_USERNAME, d.DRUG_ID, p.PRESCRIPTION_DATE, p.DOSAGE, p.INSTRUCTION
            FROM prescription p
            INNER JOIN drugs d ON p.DRUG_ID = d.DRUG_ID
            WHERE p.PATIENT_USERNAME = '$patientUsername'";
            
            $result = mysqli_query($conn, $query);

            // Check if there are any prescribed drugs for the patient
            if (mysqli_num_rows($result) > 0) {
                echo "<h2>Prescribed Drugs for Patient: " . $patientUsername . "</h2>";
                echo "<table>";
                echo "<tr><th>Drug ID</th><th>Prescription date</th><th>Dosage</th><th>Instruction</th></tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["DRUG_ID"] . "</td>";
                    echo "<td>" . $row["PRESCRIPTION_DATE"] . "</td>";
                    echo "<td>" . $row["DOSAGE"] . "</td>";
                    echo "<td>" . $row["INSTRUCTION"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No prescribed drugs found for the patient: " . $patientUsername;
            }
        } else {
            echo "Session not found. Please login again.";
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
