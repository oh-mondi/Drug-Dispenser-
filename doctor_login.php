<?php
require("database.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the submitted ID and password

    $credentials_id = $_POST["credentials_id"];
    $credentials_password = $_POST["credentials_password"];
    // Further validation or sanitization can be applied if necessary

    // Prepare the query
    $stmt = $conn->prepare("SELECT doctor_lastname FROM doctors_login WHERE Doctor_id = ? AND doctor_password = ?");
    $stmt->bind_param("is", $credentials_id, $credentials_password);

    // Execute the query
    $stmt->execute();

    // Bind the result
    $stmt->bind_result($name);

    // Check if a matching record is found
    if ($stmt->fetch()) {
        // Successful login, grant access
        echo "Welcome Doctor " . $name;
    } else {
        // Invalid credentials, deny access
        echo "Invalid credentials. Please try again.";
    }

    // Close the statement
    $stmt->close();
}

$conn->close();
?>


