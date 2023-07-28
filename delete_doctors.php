<!DOCTYPE html>
<html>
<head>
  <title>Delete Doctor Details</title>
</head>
<body>


  <h1>DELETE USER?</h1>
  <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
    <label for="user_id">Username</label>
    <input type="text" name="user_id" required><br>
    <input type="submit" name="submit" value="Delete">
      <?php
  require("database.php");
  // Check if the form is submitted
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form dat
    $userId = $_POST['user_id'];
    
    // Prepare and execute the delete query
    $stmt = $conn->prepare("DELETE FROM doctors WHERE USER_NAME=?" );
    $stmt->bind_param("s", $userId);
    if ($stmt->execute()) {
      echo " User details deleted successfully";
      
    } else {
      echo "Error deleting user details: " . $stmt->error;
    
    }

    $stmt->close();
    $conn->close();
  }
  ?>
  </form>
</body>
</html>
