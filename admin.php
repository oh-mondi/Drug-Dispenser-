<?php
require("database.php");
?>
<!DOCTYPE html>
<html>
    
<head>
    <title>Admin Home Page</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #1abc9c; /* Turquoise color */
            padding-top: 20px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar li {
            margin-bottom: 10px;
        }

        .sidebar a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
        }

        .sidebar a:hover {
            background-color: #148f77; /* Darker turquoise color on hover */
        }

        /* Content Styles */
        .content {
            margin-left: 250px; /* Sidebar width */
            padding: 20px;
        }

        .welcome-message {
            font-weight: bold;
            margin-bottom: 20px;
        }

        .tabs-container {
            margin-top: 10px;
        }

        .tab {
            display: block;
            padding: 10px;
            background-color: #f1f1f1;
            border: 1px solid #ccc;
            cursor: pointer;
            margin-bottom: 5px;
        }

        .tab:hover {
            background-color: #e1e1e1;
        }

        .tab-content {
            display: none;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            margin-bottom: 20px;
        }
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
    
    <script>
        function openTab(tabName) {
            var i, tabContent;
            tabContent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabContent.length; i++) {
                tabContent[i].style.display = "none";
            }
            document.getElementById(tabName).style.display = "block";
        }
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
</head>
<body>
   
    <!-- Sidebar -->
    
    <div class="sidebar" id="sidebar">
        <button class="toggle-button" onclick="toggleSidebar()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/>
            </svg>
        </button>
        <ul>
            <li><a href="#" onclick="openTab('viewPatients')">Patients</a></li>
            <li><a href="#" onclick="openTab('viewDoctors')">Doctors</a></li>
            <li><a href="#" onclick="openTab('viewPharmacies')">Pharmacies</a></li>
            <li><a href="#" onclick="openTab('viewPharmaceuticalCompanies')">Pharmaceutical Companies</a></li>
            <li><a href="#" onclick="Logout()">Logout</a></li>
        </ul>
    </div>
    <div class="content">
    <div class="welcome-message">
        Welcome admin,  <?php

session_start();

// Check if the user is logged in as admin
if (isset($_SESSION["user_name"]) && $_SESSION["user_name"] && $_SESSION["user_name"] != "admin") {
    // Retrieve the admin's information from the session
    $adminUserName = $_SESSION["user_name"];
    // You can retrieve additional information from the database if needed
}

echo $adminUserName; ?>!
    </div> 
    <div class="tabs-container">
    <div id="viewPatients" class="tab-content">
    <?php
    

    // Fetch patients from the database
    $sql = "SELECT * FROM patients";
    $result = $conn->query($sql);

    // Check if any patients were found
    if ($result && $result->num_rows > 0) {
        // Output the patient data as a table
        echo "<table>
                <tr>
                    <th>User Name</th>
                    <th>First Name</th>
                 
                    <th>Age</th>
                    <th>Address</th>
                    <th>Email Address</th>
                    <th>Phone Number</th>
                    <th>Action</th>
                </tr>";

        // Output each patient row as a table row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["USER_NAME"] . "</td>";
            echo "<td>" . $row["NAME"] . "</td>";
            echo "<td>" . $row["AGE"] . "</td>";
            echo "<td>" . $row["ADDRESS"] . "</td>";
            echo "<td>" . $row["EMAIL_ADDRESS"] . "</td>";
            echo "<td>" . $row["PHONE_NUMBER"] . "</td>";
            echo '<td><button class="btn btn-primary"><a href="update_patient.html?updateid=1" class="text-light">Update</a></button></td>';
            echo '<td><button class="btn btn-danger"><a href="deletepatients_admin.php?deleteid=1"  class="text-light">Delete</a></button></td>';
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No patients found.";
    }

    
    echo '<td><button class="btn btn-danger"><a href="addpatient_admin.php" class="text-light">Add Patient</a></button></td>';

    ?>
</div>


    
    <div id="viewDoctors" class="tab-content">
    <?php
    

    // Fetch patients from the database
    $sql = "SELECT * FROM doctors";
    $result = $conn->query($sql);

    // Check if any patients were found
    if ($result && $result->num_rows > 0) {
        // Output the patient data as a table
        echo "<table>
                <tr>
                    <th>User Name</th>
                    <th>Name</th>
                    <th>Speciality</th>
                    <th>Years of experience</th>
                
                </tr>";

        // Output each patient row as a table row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["USER_NAME"] . "</td>";
            echo "<td>" . $row["NAME"] . "</td>";
            echo "<td>" . $row["SPECIALITY"] . "</td>";
            echo "<td>" . $row["YRS_OF_EXPERIENCE"] . "</td>";
            echo '<td><button class="btn btn-primary"><a href="update_doctors.html?updateid=1" class="text-light">Update</a></button></td>';
            echo '<td><button class="btn btn-danger"><a href="deletedoctors_admin.php?deleteid=1"  class="text-light">Delete</a></button></td>';
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No doctors found.";
    }

    
    echo '<td><button class="btn btn-danger"><a href="adddoctor_admin.php" class="text-light">Add Doctor</a></button></td>';

    ?>
    </div>
    
    <div id="viewPharmacies" class="tab-content">
    <?php
    

    // Fetch patients from the database
    $sql = "SELECT * FROM pharmacy";
    $result = $conn->query($sql);

    // Check if any patients were found
    if ($result && $result->num_rows > 0) {
        // Output the patient data as a table
        echo "<table>
                <tr>
                    <th>User Name</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>Password</th>
                
                </tr>";

        // Output each patient row as a table row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["USER_NAME"] . "</td>";
            echo "<td>" . $row["NAME"] . "</td>";
            echo "<td>" . $row["ADDRESS"] . "</td>";
            echo "<td>" . $row["PHONE_NUMBER"] . "</td>";
            echo "<td>" . $row["PASSWORD"] . "</td>";
            echo '<td><button class="btn btn-primary"><a href="update_pharmacists.php?updateid=1" class="text-light">Update</a></button></td>';
            echo '<td><button class="btn btn-danger"><a href="deletepharmacist_admin.php?deleteid=1"  class="text-light">Delete</a></button></td>';
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No pharmacies found.";
    }

    
    echo '<td><button class="btn btn-danger"><a href="addpharmacist_admin.php" class="text-light">Add Pharmacist</a></button></td>';

    ?>
    </div>
    
    <div id="viewPharmaceuticalCompanies" class="tab-content">
    <?php
    
    // Fetch patients from the database
    $sql = "SELECT * FROM pharmaceutical_companies";
    $result = $conn->query($sql);

    // Check if any patients were found
    if ($result && $result->num_rows > 0) {
        // Output the patient data as a table
        echo "<table>
                <tr>
                    <th>Company id</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Contact Number</th>
                    
                
                </tr>";

        // Output each patient row as a table row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["COMPANY_ID"] . "</td>";
            echo "<td>" . $row["NAME"] . "</td>";
            echo "<td>" . $row["ADDRESS"] . "</td>";
            echo "<td>" . $row["CONTACT_NUMBER"] . "</td>";
            echo '<td><button class="btn btn-primary"><a href="update_pharmaceutical.php?updateid=1" class="text-light">Update</a></button></td>';
            echo '<td><button class="btn btn-danger"><a href="delete_pharmaceutical.php?deleteid=1"  class="text-light">Delete</a></button></td>';
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No pharmaceautical companies found.";
    }

    
    echo '<td><button class="btn btn-danger"><a href="add_pharmaceutical.php" class="text-light">Add Pharmaceutical Company</a></button></td>';

    ?>
    </div>
    </div>
</div>
</body>
</html>