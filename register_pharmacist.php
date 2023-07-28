<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
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
        
       
        
       
    
    input[type="username"],
    input[type="name"],
    input[type="address"],
    input[type="phone"],
    input[type="password"]
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
    <form method="POST" action="">
        <h2> Pharmacist Sign Up Form</h2>
        <label for="user_name">User Name:</label>
        <input type="text" id="user_name" name="user_name" required><br>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required><br>

        <label for="phone">Phone Number:</label>
        <input type="number" id="phone" name="phone" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Submit">
    </form>
</body>




<?php

   
        require("database.php");
    // Handle the form submission and insert the new patient
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $user_name = $_POST['user_name'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];

        // Prepare and bind the statement
        $stmt = $conn->prepare("INSERT INTO pharmacy (USER_NAME, NAME,ADDRESS,PHONE_NUMBER, PASSWORD) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $user_name, $name, $address, $phone, $password);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Glad to have you on board Pharmacist"."<br".$name;
            echo "<br>";
            echo "<a href='loginform.html'>proceed to login</a>";
        } else {
            echo "Error: Unable to insert data.";

        }

        // Close the statement
        $stmt->close();
    }

    

    ?>
    </html>
