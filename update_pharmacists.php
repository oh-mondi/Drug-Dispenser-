
<!DOCTYPE html>
<html>
<head>
  <title>Pharmacists Details Update</title>
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
    
   
    
    input[type="USER_NAME"],
    input[type="NAME"],
    input[type="ADDRESS"], 
    input[type="PHONE"], 
    input[type="PASSWORD"] 
    {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #40E0D0;
        border-radius: 5px;
        box-sizing: border-box;
    }
    
   
    
    
    button[type="update"] {
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
    
  
    button[type="update"]:hover {
        background-color: #20B2AA;
    }
</style>
</head>
<body>

  
  <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
  <h2>Pharmacists Details Update</h2>
  <label for="USER_NAME"> User Name</label>
    <input type="text" name="USER_NAME" required><br> 
  
  <label for="NAME">Name</label>
    <input type="text" name="NAME" required><br>

    <label for="ADDRESS">Address</label>
    <input type="text" name="ADDRESS" required><br>

    <label for="PHONE">Phone Number</label>
    <input type="text" name="PHONE" required><br>

    <label for="PASSWORD">Password</label>
    <input type="password" name="PASSWORD" required><br>


    <input type="submit" name="submit" value="Update">
    <?php
  // Check if the form is submitted
 
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $username = $_POST['USER_NAME'];
    $name = $_POST['NAME'];
    $address = $_POST['ADDRESS'];
    $phone = $_POST['PHONE'];
    $password = $_POST['PASSWORD'];
  

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
     $stmt = $conn->prepare("UPDATE pharmacy SET NAME=?,ADDRESS=?,PHONE_NUMBER=?,PASSWORD=? WHERE USER_NAME=? ");
    $stmt->bind_param("sssss",$name,$address,$phone,$password,$username);
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

  </form>

</body>
</html>
