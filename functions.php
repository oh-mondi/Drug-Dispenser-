<?php

function selectDataFromDatabase($servername, $username, $password, $database, $tableName, $columnName, $columnValue)
{
    require_once("database.php");

    // Create a new mysqli object
    $conn = new mysqli($servername, $username, $password, $database);

    // Check if there was an error connecting to the database
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to select data for the specific user
    $sql = "SELECT * FROM $tableName WHERE $columnName = '$columnValue'";

    // Execute the query
    $result = $conn->query($sql);

    // Check if there was an error executing the query
    if ($result === false) {
        die("Error: " . $conn->error);
    }

    // Check if any rows are returned
    if ($result->num_rows > 0) {
        // Create an array to hold the data
        $data = array();

        // Loop through each row
        while ($row = $result->fetch_assoc()) {
            // Add the row to the data array
            $data[] = $row;
        }

        // Close the connection
        $conn->close();

        // Return the retrieved data
        return $data;
    } else {
        // Close the connection
        $conn->close();

        // Return an empty array if no data found
        return array();
    }
}

function deleteDataFromDatabase($servername, $username, $password, $database, $tableName, $user_name)
{
   

require_once("login.php");
   
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
    // Prepare the SQL statement with a parameterized query
    $sql = "DELETE FROM $tableName WHERE USER_NAME = ?";
    $stmt = $conn->prepare($sql);

    // Bind the user ID as a parameter
    $stmt->bind_param("s", $user_name);

    // Execute the query
    $result = $stmt->execute();

    // Check if the deletion was successful
    if ($result === TRUE) {
        // Deletion successful
        $deleted = true;
    } else {
        // Deletion failed
        $deleted = false;
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();

    // Return true if the deletion was successful, or false otherwise
    return $deleted;
}

    
    
    function updateUserData($host, $username, $password, $database)
    {
        // Create a new MySQLi object and establish the database connection
        $conn = new mysqli($host, $username, $password, $database);
    
        // Check if the connection was successful
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        // Prepare the update statement
        $stmt = $conn->prepare("UPDATE Patients SET USER_NAME=?, EMAIL_ADDRESS=?, AGE=? WHERE USER_NAME=?");
    
        // Bind the parameters to the prepared statement
        $stmt->bind_param("ssis", $newUsername, $email, $age, $oldUsername);
    
        // Execute the prepared statement
        $stmt->execute();
    
        // Check if the update was successful
        $updateResult = ($stmt->affected_rows > 0);
    
        // Close the statement and database connection
        $stmt->close();
        $conn->close();
    
        // Return the result of the update operation
        return $updateResult;
    }
    ?>

    
    

