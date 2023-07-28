<!DOCTYPE html>
<html>
<head>
    <title>Write Prescription</title>
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
            <li style="margin-top: auto;"><a href="#" onclick="Logout()">Logout</a></li> </ul>
    </div>

    <div class="main-content">
        <h1>Write Prescription</h1>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="patientUsername">Patient Username:</label>
            <input type="text" name="patientUsername" id="patientUsername">
            <br>
            <label for="drugId">Drug ID:</label>
            <select name="drugId" id="drugId">
                <?php
                require_once("database.php");
                $combo = "";
                $sql = "SELECT DRUG_ID FROM drugs";

                if ($result = $conn->query($sql)) {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $drugId = $row['DRUG_ID'];
                            $combo .= "<option value=\"$drugId\">$drugId</option>";
                        }
                    } else {
                        echo "No drugs found.";
                    }
                    $result->free();
                }

                echo $combo;
                ?>
            </select>
            <br>
            <label for="dosage">Dosage:</label>
            <input type="text" name="dosage" id="dosage">
            <br>
            <label for="instruction">Instruction:</label>
            <textarea name="instruction" id="instruction" rows="4" cols="50"></textarea>
            <br>
            <input type="submit" value="Submit">
        </form>

        <?php
        require_once("database.php");

        // Check if the form has been submitted
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $patientUsername = $_POST["patientUsername"];

            session_start();
            $doctorUsername = $_SESSION["user_name"]; // Replace with your session variable or authentication mechanism

            $drugId = isset($_POST["drugId"]) ? $_POST["drugId"] : "";
            $prescriptionDate = date("Y-m-d");
            $dosage = isset($_POST["dosage"]) ? $_POST["dosage"] : "";
            $instruction = isset($_POST["instruction"]) ? $_POST["instruction"] : "";

    // Check if the patient username exists in the patients table
    $patientQuery = "SELECT * FROM patients WHERE USER_NAME = '$patientUsername'";
    $patientResult = mysqli_query($conn, $patientQuery);

    if (mysqli_num_rows($patientResult) === 1) {
        // Check if the drug ID exists in the drugs table
        $drugQuery = "SELECT * FROM drugs WHERE DRUG_ID = '$drugId'";
        $drugResult = mysqli_query($conn, $drugQuery);

        if (mysqli_num_rows($drugResult) === 1) {
            // Perform the prescription insertion query
            $insertQuery = "INSERT INTO prescription (PATIENT_USERNAME, DOCTOR_USERNAME, DRUG_ID, PRESCRIPTION_DATE, DOSAGE, INSTRUCTION) 
            VALUES ('$patientUsername', '$doctorUsername', '$drugId', '$prescriptionDate', '$dosage', '$instruction')";
            $insertResult = mysqli_query($conn, $insertQuery);

            if ($insertResult) {
                echo "<script>alert('prescription written!');</script>";
            echo "<script>window.location.href = 'doctors_patients.php';</script>";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "write the prescription";
            
        }
    } else {
        echo "Error: Invalid patient username.";
    }
}
?>
<?php
// Close the database connection
mysqli_close($conn);
?>
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
 