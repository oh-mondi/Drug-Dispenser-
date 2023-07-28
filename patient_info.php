<!DOCTYPE html>
<html>
<head>
    <title>Patient Information</title>
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

        /* CSS for the profile card */
        .profile-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border: 2px solid black;
            margin-top: 50px;
        }

        .profile-info {
            margin-bottom: 10px;
        }

        .profile-info .title {
            font-weight: bold;
            color: #777;
            margin-bottom: 5px;
        }

        .profile-info .value {
            font-size: 14px;
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
                <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z" fill="#fff"/> <!-- White -->
            </svg>
        </button>
        <ul>
            <li><a href="doctors_appointments.php">Appointments</a></li>
            <li><a href="doctors_patients.php">Patients</a></li>
            <li style="float: right;"><a href="#" onclick="logout()">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Patient Information</h1>

        <?php
        require_once("database.php");

        // Retrieve the patient username from the URL parameter
        $patientUsername = $_GET['username'];

        // Query to retrieve the patient information based on the provided username
        $patientQuery = "SELECT * FROM patients WHERE USER_NAME = '$patientUsername'";
        $patientResult = mysqli_query($conn, $patientQuery);

        if (!$patientResult) {
            die("Error: " . mysqli_error($conn));
        }

        // Check if the patient exists
        if (mysqli_num_rows($patientResult) > 0) {
            $patientData = mysqli_fetch_assoc($patientResult);
            $patientName = $patientData['NAME'];
            $patientAge = $patientData['AGE'];
            $patientAddress = $patientData['ADDRESS'];
            $patientEmail = $patientData['EMAIL_ADDRESS'];
            $patientPhone = $patientData['PHONE_NUMBER'];

            // Display the profile card with patient information
            echo "<div class='profile-card'>";
            echo "<div class='profile-info'>";
            echo "<div class='title'>Username:</div>";
            echo "<div class='value'>$patientUsername</div>";
            echo "</div>";
            echo "<div class='profile-info'>";
            echo "<div class='title'>Name:</div>";
            echo "<div class='value'>$patientName</div>";
            echo "</div>";
            echo "<div class='profile-info'>";
            echo "<div class='title'>Age:</div>";
            echo "<div class='value'>$patientAge</div>";
            echo "</div>";
            echo "<div class='profile-info'>";
            echo "<div class='title'>Address:</div>";
            echo "<div class='value'>$patientAddress</div>";
            echo "</div>";
            echo "<div class='profile-info'>";
            echo "<div class='title'>Email:</div>";
            echo "<div class='value'>$patientEmail</div>";
            echo "</div>";
            echo "<div class='profile-info'>";
            echo "<div class='title'>Phone:</div>";
            echo "<div class='value'>$patientPhone</div>";
            echo "</div>";
            echo "</div>";

            // Add the "Write Prescription" button
            echo "<form action='write_prescription.php' method='post'>";
            echo "<input type='hidden' name='patientUsername' value='$patientUsername'>";
            echo "<input type='submit' value='Write Prescription'>";
            echo "</form>";
        } else {
            echo "<p>Patient not found.</p>";
        }

        // Close the database connection
        mysqli_close($conn);
        ?>

        <script>
            function logout() {
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
    </div>
</body>
</html>
