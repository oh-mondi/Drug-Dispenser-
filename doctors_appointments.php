<!DOCTYPE html>
<html>
<head>
    <title>Doctor Appointments</title>
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
        }

        th,
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #40E0D0; /* Turquoise Blue */
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>
   <?php
 require_once("database.php");
    // Start the session
    session_start();

    // Check if the doctor is logged in
    if (!isset($_SESSION["user_name"])) {
        header("Location: login.php"); // Redirect to the login page if not logged in
        exit();
    }

    $doctorUsername = $_SESSION["user_name"];

    // Retrieve the appointments for the specific doctor from the appointments table
    $appointmentsQuery = // Retrieve the appointments for the specific doctor from the appointments table
    $appointmentsQuery = "SELECT appointments.*, patients.* FROM appointments INNER JOIN patients ON appointments.PATIENT_USERNAME = patients.USER_NAME WHERE appointments.DOCTORS_USERNAME = '$doctorUsername'";
    
    $appointmentsResult = mysqli_query($conn, $appointmentsQuery);

    if (!$appointmentsResult) {
        die("Error: " . mysqli_error($conn));
    }
    ?>
    <div class="sidebar" id="sidebar">
        <button class="toggle-button" onclick="toggleSidebar()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z" fill="#fff"/> <!-- White -->
            </svg>
        </button>
        <ul>
        <li><a href="doctor.php">Home</a></li>
            <li><a href="doctors_appointments.php">Appointments</a></li>
            <li><a href="doctors_patients.php">Patients</a></li>
            <li style="margin-top: auto;"><a href="#" onclick="Logout()">
            Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Doctor Appointments</h1>

        <table>
            <tr>
                <th>Appointment ID</th>
                <th>Patient Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>More Information</th>
            </tr>
            <?php
            // Loop through the appointments and display the information in a table
            while ($row = mysqli_fetch_assoc($appointmentsResult)) {
                $appointmentId = $row['APPOINTMENT_ID'];
                $patientName = $row['PATIENT_USERNAME'];
                $date = $row['DATE'];
                $time = $row['TIME'];

                echo "<tr>";
                echo "<td>$appointmentId</td>";
                echo "<td>$patientName</td>";
                echo "<td>$date</td>";
                echo "<td>$time</td>";
                echo "<td><a href='patient_info.php?username=$patientName'>View Details</a></td>";
                echo "<td><button onclick='confirmAttendance($appointmentId, this)'>Confirm Attendance</button></td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>

    <script>
        function confirmAttendance(appointmentId, button) {
            button.style.backgroundColor = "green";
            button.style.color = "white";
            button.disabled = true; // Disable the button to prevent multiple clicks
        }

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

    <?php
    // Close the database connection
    mysqli_close($conn);
    ?>
</body>
</html>
