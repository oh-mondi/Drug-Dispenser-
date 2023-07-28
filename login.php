<?php
require_once("database.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve the submitted ID and password
    $user_name = $_POST["user_name"];
    $password = $_POST["password"];
    $selectedTable = $_POST["firstComboBox"];

    // Further validation or sanitization can be applied if necessary
 
    // Prepare the query based on the selected table
    switch ($selectedTable) {
        case "patient":
            $tableName = "Patients";
            $redirectURL = "patient.php"; // Redirect to the patient page
            break; 
        case "doctor":
            $tableName = "Doctors";
            $redirectURL = "doctor.php"; // Redirect to the doctor page
            break;
        case "pharmacy":
            $tableName = "Pharmacy";
            $redirectURL = "pharmacy.php"; // Redirect to the pharmacy page
            break;
        case "admin":
            $tableName = "Admin";
            $redirectURL = "admin.php"; // Redirect to the admin page
            break;
        default:
            $tableName = "";
            $redirectURL = ""; // Invalid table, no redirect
            break;
    }

    // Prepare the query
    if (!empty($tableName)) {
        // Prepare the query
        $stmt = $conn->prepare("SELECT USER_NAME FROM $tableName WHERE user_name = ? AND password = ?");
        $stmt->bind_param("ss", $user_name, $password);
    
        // Execute the query
        $stmt->execute();

        // Bind the result
        $stmt->bind_result($user_name);

        // Check if a matching record is found
        if ($stmt->fetch()) {
            // Successful login, grant access

            // Start a session to store the user's information
            session_start();

            // Store the user's name in the session
            $_SESSION["user_name"] = $user_name;
          
            // Redirect to the appropriate page based on user type
            echo "<script> alert('Welcome " . $tableName . " " . $user_name . ".'); </script>";
            header("Location: $redirectURL");
            //exit(); // Terminate the script after redirect
        } else {
            // Invalid credentials, deny access
            echo "<br>" . "Invalid credentials. Please try again.";
        }
    } else {
        // No table selected, display an error message
        echo "<br>" . "Please select a valid option.";
    }
} else {
    // Fields not submitted, display an error message
    echo "<br>" . "Please fill in all the required fields.";
}
?>
