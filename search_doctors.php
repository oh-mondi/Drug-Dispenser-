<!DOCTYPE html>
<html>
<head>
    <title>Patients Dashboard</title>
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

        /* CSS to adjust the Appointments tab */
        .sidebar ul li:first-child {
            padding-top: 30px;
        }

        /* CSS for the Logout tab */
        .sidebar ul li:last-child {
            margin-top: auto;
        }

        /* CSS for the doctor search results table */
        .doctor-table {
            width: 100%;
            border-collapse: collapse;
        }

        .doctor-table th,
        .doctor-table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        .doctor-table th {
            background-color: #40E0D0; 
            color: white;
            font-weight: bold;
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
            <li><a href="patient.php">Home</a></li>
            <li><a href="appointments.php">Appointments</a></li>
            <li><a href="patient_prescription.php">Prescriptions</a></li>
            <li><a href="user_management.php">User Management</a></li>
            <li style="margin-top: auto;"><a href="#" onclick="Logout()">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Welcome, Patient!</h1>

        <?php
        // Make sure the form was submitted
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Retrieve the selected specialty from the form data
            $selectedSpecialty = $_GET['specialty'];

            // Perform your database query to retrieve doctors with the selected specialty
            require_once("database.php");

            $sql = "SELECT * FROM doctors WHERE SPECIALITY = '$selectedSpecialty'";
            $result = $conn->query($sql);

            // Display the search results
            if ($result->num_rows > 0) {
                echo "<h3>Doctors with specialty: $selectedSpecialty</h3>";
                echo "<table class='doctor-table'>";
                echo "<tr><th class='column-username'>Username</th><th class='column-name'>Name</th><th class='column-speciality'>Speciality</th><th class='column-experience'>Years of Experience</th><th class='column-email'>Email
                Address</th><th class='column-action'>Action</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='column-username'>" . $row['USER_NAME'] . "</td>";
                    echo "<td class='column-name'>" . $row['NAME'] . "</td>";
                    echo "<td class='column-speciality'>" . $row['SPECIALITY'] . "</td>";
                    echo "<td class='column-experience'>" . $row['YRS_OF_EXPERIENCE'] . "</td>";
                    echo "<td class='column-email'>" . $row['EMAIL_ADDRESS'] . "</td>";
                    echo "<td class='column-action'><a href='appointment_request.php?doctor_id=" . $row['USER_NAME'] . "'>Request Appointment</a></td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No doctors found with specialty: $selectedSpecialty</p>";
            }

            // Free the result set
            $result->free();

            // Close the database connection
            $conn->close();
        }
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

        function toggleSidebar() {
            var sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("collapsed");
        }
    </script>

    <!-- Add your content here -->

</body>
</html>
