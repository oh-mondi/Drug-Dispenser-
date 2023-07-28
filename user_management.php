<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
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
        }

        .sidebar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .sidebar li {
            margin-bottom: 10px;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px;
        }

        .sidebar a:hover {
            background-color: #008080; /* Dark Turquoise Blue */
        }

        /* CSS for the content area */
        .content {
            margin-left: 200px;
            padding: 20px;
            background-color: white;
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

        /* CSS for the edit and delete buttons */
        .edit-button,
        .delete-button {
            display: inline-block;
            padding: 5px 10px;
            background-color: #008080; /* Dark Turquoise Blue */
            color: white;
            text-decoration: none;
            border-radius: 3px;
            transition: background-color 0.3s ease;
        }

        .edit-button:hover,
        .delete-button:hover {
            background-color: #006666; /* Darker Turquoise Blue */
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <ul>
            <li><a href="patient.php">Home</a></li>
            <li><a href="#">Appointments</a></li>
            <li><a href="#">Medical Records</a></li>
            <li><a href="#">Prescriptions</a></li>
            <li><a href="user_management.php">User Management</a></li>
            <li style="margin-top: auto;"><a href="#" onclick="Logout()">Logout</a></li>
       </ul>
    </div>

    <div class="content">
        <h1>User Management</h1>

        <?php
        require_once("functions.php");
        require_once("database.php");

        // Check if the user is logged in and their username is set in the session
        session_start();
        if (isset($_SESSION["user_name"])) {
            echo "Welcome, " . $_SESSION["user_name"] . "!";

            if (isset($_GET['edit'])) {
                // Display the update form
                echo '
                <h2>Edit User Details</h2>
                <form method="post" action="update_user.php">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="">

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="">

                    <label for="age">Age:</label>
                    <input type="number" id="age" name="age" value="">

                    <input type="submit" value="Update">
                </form>';
            } else {
                // Display user details
                // Add your code here for displaying user details
                // Get the logged-in user's details from the database
                $username = $_SESSION["user_name"];
                $user = selectDataFromDatabase("localhost", "root", "", "drugtool", "Patients", "user_name", $username);

                if (!empty($user)) {
                    echo '<table>';
                    echo '<tr><th>User Name</th><th>Name</th><th>Age</th><th>Address</th><th>Email Address</th><th>Phone Number</th><th>Password</th><th>Action</th></tr>';

                    echo '<tr>';
                    echo '<td>' . $user[0]['USER_NAME'] . '</td>';
                    echo '<td>' . $user[0]['NAME'] . '</td>';
                    echo '<td>' . $user[0]['AGE'] . '</td>';
                    echo '<td>' . $user[0]['ADDRESS'] . '</td>';
                    echo '<td>' . $user[0]['EMAIL_ADDRESS'] . '</td>';
                    echo '<td>' . $user[0]['PHONE_NUMBER'] . '</td>';
                    echo '<td>' . $user[0]['PASSWORD'] . '</td>';
                    echo '<td><button class="btn btn-primary"><a href="update.php?updateid=1" class="text-light">Update</a></button></td>';
            echo '<td><button class="btn btn-danger"><a href="delete.php?deleteid=1"  class="text-light">Delete</a></button></td>';
            echo '</tr>';

                    echo '</table>';
                } else {
                    echo 'No user found.';
                }
            }

            // Handle delete request
            if (isset($_GET['delete'])) {
                // Delete the user record from the database
                // Add your code here to delete the user record

                echo '<p>User deleted successfully.</p>';
            }
        } else {
            // Redirect to the login page if the user is not logged in
            header("Location: login.php");
            exit();
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
    </script>
</body>
</html>
