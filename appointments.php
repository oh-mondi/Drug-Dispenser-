<!DOCTYPE html>
<html>
<head>
    <title>Patients Dashboard - Appointments</title>
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
            margin-top: 50px;
        }

        /* CSS for the form */
        form {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        label {
            margin-right: 10px;
        }

        select, input[type="submit"] {
            padding: 10px;
            border-radius: 5px;
            border: none;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #40E0D0; /* Turquoise Blue */
            color: white;
            cursor: pointer;
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
            <li><a href="#" onclick="Logout()">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Welcome, Patient!</h1>

        <div class="top-right">
            <?php
                // Check if the user is logged in and their username is set in the session
                session_start();
                if (isset($_SESSION["user_name"])) {
                    echo "Welcome, " . $_SESSION["user_name"] . "!";

                   
                } else {
                    // Redirect to the login page if the user is not logged in
                    header("Location: login.php");
                    exit();
                }
            ?>
        </div>

        <h2>Find a Doctor</h2>

        <form action="search_doctors.php" method="GET">
            <label for="specialty">Select Specialty:</label>
            
            <?php
                require_once("database.php");
                $combo = "<select name='specialty' id='speciality'>"; // Add the name attribute to the select element

                $sql = "SELECT DISTINCT SPECIALITY FROM doctors"; // Use DISTINCT to get unique specialties

                if ($result = $conn->query($sql)) {
                    if ($result->num_rows) {
                        while ($row = $result->fetch_object()) {
                            $combo .= "<option>" . $row->SPECIALITY . "</option>";
                        }
                        $result->free();
                    }
                }
                $combo .= "</select>";
                echo $combo;
            ?>

            <input type="submit" value="Search">
        </form>
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
</body>
</html>
