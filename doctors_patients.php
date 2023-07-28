<!DOCTYPE html>
<html>
<head>
    <title>Doctor Dashboard - Patients</title>
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
        .search-container {
            margin-bottom: 20px;
        }

        .search-container input[type=text] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 10px;
        }

        /* CSS for the table */
        table {
            width: 100%;
            border-collapse: collapse;
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
                <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z" fill="#fff"/> <!-- White -->
            </svg>
        </button>
        <ul>
        <li><a href="doctor.php">Home</a></li>
            <li><a href="doctors_appointments.php">Appointments</a></li>
            <li><a href="doctors_patients.php">Patients</a></li>
            <li style="float: right;"><a href="#" onclick="logout()">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Patients</h1>
        <div class="search-container">
            <form method="post">
                <input type="text" name="search" placeholder="Search for patients...">
                <input type="submit" value="Search">
            </form>
        </div>

        <?php
        require_once("database.php");

        session_start();

        // Check if the username is set in the session
        if (isset($_SESSION["user_name"])) {
            $doctorUsername = $_SESSION["user_name"];

            // Retrieve patients for the specific doctor from the database
            $query = "SELECT p.USER_NAME, p.NAME, p.AGE, p.EMAIL_ADDRESS, p.PHONE_NUMBER 
                      FROM patients p
                      INNER JOIN appointments a ON p.USER_NAME = a.PATIENT_USERNAME
                      WHERE a.DOCTORS_USERNAME = '$doctorUsername'";
          // Check if a search query is submitted
          if (isset($_POST["search"]) && !empty($_POST["search"])) {
            $search = $_POST["search"];
            // Modify the query to include the search condition
            $query .= " AND (p.USER_NAME LIKE '%$search%' OR p.NAME LIKE '%$search%')";
        }  
           $result = mysqli_query($conn, $query);

            // Check if there are any patients
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr><th>Username</th><th>Name</th><th>Age</th><th>Email Address</th><th>Phone Number</th><th>Action</th></tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["USER_NAME"] . "</td>";
                    echo "<td>" . $row["NAME"] . "</td>";
                    echo "<td>" . $row["AGE"] . "</td>";
                    echo "<td>" . $row["EMAIL_ADDRESS"] . "</td>";
                    echo "<td>" . $row["PHONE_NUMBER"] . "</td>";
                    echo "<td><a href='write_prescription.php?patientUsername=" . $row["USER_NAME"] . "'>Write Prescription</a></td>";
                    echo "<td><a href='view_prescribed_history.php?patientUsername=" . $row["USER_NAME"] . "'>View Prescribed History</a></td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No patients found.";
            }
        } else {
            echo "Session not found. Please login again.";
        }

        // Close the database connection
        mysqli_close($conn);
        ?>
    </div>

    <script>
        function logout() {
            // Display confirmation alert
            if (confirm("Are you sure you want to logout?")) {
                // Destroy the session
                window.location.href = "logout.php";
            }
        }

        function toggleSidebar() {
            var sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("collapsed");
        }
    </script>
</body>
</html>
