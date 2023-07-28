
<?php
  // Check if the form is submitted
 
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $username = $_POST['USER_NAME'];
    $first_name = $_POST['NAME'];
    $speciality = $_POST['SPECIALITY'];
    $experience=$_POST['EXPERIENCE'];
   
  

    // Connect to the database
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $database = "drugtool";

    $conn = new mysqli($servername, $db_username, $db_password, $database);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the update query
     $stmt = $conn->prepare("UPDATE doctors SET NAME=?,SPECIALITY=?,YRS_OF_EXPERIENCE =?  WHERE USER_NAME=? ");
    $stmt->bind_param("ssis",$first_name,$speciality,$experience,$username);
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

  }
  ?>

 
