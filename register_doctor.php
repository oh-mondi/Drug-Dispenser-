
<!DOCTYPE html>
<html>
<head>
    <title>Add doctor</title>
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
        
        h2 {
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
    input[type="SPECIALTY"],
    input[type="EXPERIENCE"],
    input[type="PASSWORD"]
    {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #40E0D0;
        border-radius: 5px;
        box-sizing: border-box;
    }
        
        button[type="submit"]
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
        
        button[type="submit"]:hover
        {
            background-color: #20B2AA;
        }
    </style>
</head>
<body>

<form method='POST' action='register_doctor.php'>

<h2>Doctor Sign Up Form</h2>
  
  <label for="USER_NAME"> User Name</label>
    <input type="text" name="USER_NAME" required><br> 
  
  <label for="NAME"> Name</label>
    <input type="text" name="NAME" required><br>
   
    <label for="SPECIALTY">Speciality:</label>
    <input type="text" name="SPECIALTY" required><br>

    <label for="EXPERIENCE">Years of Experience</label>
    <input type="number" name="EXPERIENCE" required></textarea><br>

    <label for="PASSWORD">Password</label>
    <input type="password" name="PASSWORD" required></textarea><br>

    

<button> Submit</button>
</form>
</body>
<?php
require("database.php");
// Handle the form submission and insert the new patient
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $user_name = $_POST['USER_NAME'];
        $first_name = $_POST['NAME'];
        $specialty = $_POST['SPECIALTY'];
        $experience=$_POST['EXPERIENCE'];
        $PASSWORD=$_POST['PASSWORD'];
       // Prepare and execute the update query
       $stmt = $conn->prepare("INSERT INTO doctors (USER_NAME, NAME, SPECIALTY, YRS_OF_EXPERIENCE, PASSWORD) VALUES (?, ?, ?, ?, ?)");
       if ($stmt !== false) {
           $stmt->bind_param("sssis", $user_name, $first_name, $specialty, $experience, $PASSWORD);
           // ...
       } else {
           echo "Error preparing statement: " . $conn->error;
       }
       
       $stmt->bind_param("sssis",$user_name,$first_name,$specialty,$experience, $PASSWORD);
       if ($stmt->execute()) {
         echo "Glad to have you on board doctor"."<br>".$first_name;
         echo "<br>";
               echo "<a href='loginform.html'>proceed to login</a>";
       } else {
         echo "Error Registering " . $stmt->error;
         echo "<br>";
              
       }
   

        // Close the statement
        $stmt->close();
    }

    

    ?>
</html>

