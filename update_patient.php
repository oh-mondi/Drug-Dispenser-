<?php
require("database.php");
// Handle the form submission and insert the new patient
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $username = $_POST['user_name'];
        $name = $_POST['name'];
        $age = $_POST['age'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $phone = $_POST['phone_number'];
     

    // Connect to the database
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $database = "db_tijani_tatu_150397";

    $conn = new mysqli($servername, $db_username, $db_password, $database);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the update query
     $stmt = $conn->prepare("UPDATE patients SET NAME=?,AGE=?,ADDRESS =?, EMAIL_ADDRESS=?, PHONE_NUMBER=? WHERE USER_NAME=? ");
    $stmt->bind_param("sissss",$name,$age,$address,$email,$phone,$username);
    if ($stmt->execute()) {
      echo "User details updated successfully.";
      echo "<br>";
            echo "<a href='admin.php'>Go back to admin home page</a>";
    } else {
      echo "Error updating user details: " . $stmt->error;
      echo "<br>";
            echo "<a href='admin.php'>Go back to admin home page</a>";
    }

    $stmt->close();
    $conn->close();
  }

    

    

    ?>