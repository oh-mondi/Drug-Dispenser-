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

        /* CSS for the profile card */
        .profile-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border: 2px solid black; /* Black */
        }

        .profile-picture {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .profile-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
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
            <li><a href="appointments.php">Appointments</a></li>
            <li><a href="patient_prescription.php">Prescriptions</a></li>
            <li><a href="user_management.php">User Management</a></li>
            <li style="margin-top: auto;"><a href="#" onclick="Logout()">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Welcome, Patient!</h1>

        <div class="top-right">
            <?php
                require_once("functions.php");
                require_once("database.php");
                // Check if the user is logged in and their username is set in the session
                session_start();
                if (isset($_SESSION["user_name"])) {
                    echo "Welcome, " . $_SESSION["user_name"] . "!";

                    // Display user details or form for updating details
                    // Add your code here for displaying user details or the update form
                    $username = $_SESSION["user_name"];
                    $user = selectDataFromDatabase("localhost", "root", "", "db_tijani_tatu_150397", "Patients", "user_name", $username);

                    echo '
                    <div class="profile-card">
                        <div class="profile-picture">
                            <img src="photos/profile.png" alt="Profile Picture">
                        </div>
                        <div class="profile-info">
                            <div class="title">Username:</div>
                            <div class="value">' . $user[0]['USER_NAME'] . '</div>
                        </div>
                        <div class="profile-info">
                            <div class="title">Name:</div>
                            <div class="value">' . $user[0]['NAME'] . '</div>
                        </div>
                        <div class="profile-info">
                            <div class="title">Age:</div>
                            <div class="value">' . $user[0]['AGE'] . '</div>
                        </div>
                        <div class="profile-info">
                            <div class="title">Address:</div>
                            <div class="value">' . $user[0]['ADDRESS'] . '</div>
                        </div>
                        <div class="profile-info">
                            <div class="title">Email:</div>
                            <div class="value">'. $user[0]['EMAIL_ADDRESS'] . '</div>
                        </div>
                        <div class="profile-info">
                            <div class="title">Phone:</div>
                            <div class="value">' . $user[0]['PHONE_NUMBER'] . '</div>
                        </div>
                    </div>';
                } else {
                    // Redirect to the login page if the user is not logged in
                    header("Location: loginform.html");
                    exit();
                }
            ?>
        </div>
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
