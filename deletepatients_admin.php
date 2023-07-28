<!DOCTYPE html>
<html>
<head>
  <title>Delete   Patient   Details</title>
  <style>
  body {
            background-color: #40E0D0;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        h1 {
            text-align: center;
            color: #40E0D0;
        }
        
        label {
            display: block;
            margin-bottom: 10px;
            color: #40E0D0;
        }
        
     
      
        input[type="user_name"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #40E0D0;
            border-radius: 5px;
            box-sizing: border-box;
        }
        
     
        button[type="delete"]
         {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #40E0D0;
            border: none;
            color: #ffffff;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }
        
        
        button[type="delete"]:hover {
            background-color: #20B2AA;
        }
        </style>
</head>
<body>


  <h1>>Delete   Patient   Details</h1>
  <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
    <label for="user_name">Username</label>
    <input name="user_name">
   <button value="delete">Delete</button>
  

  
      <?php
  require("database.php");
  // Check if the form is submitted
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form dat
    $userId = $_POST['user_name'];
  
    // Prepare and execute the delete query
    $stmt = $conn->prepare("DELETE FROM patients WHERE USER_NAME=?");
    $stmt->bind_param("s", $userId);
    if ($stmt->execute()) {
      echo " User details deleted successfully\n";
      echo 'Go back to <a href="admin.php">admin home</a>';

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
