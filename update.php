<!DOCTYPE html>
<html>
<head>
  <title>User Details Update</title>
</head>
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
        
        .radio-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        
        input[type="text"],
        input[type="number"],
        input[type="email"],
        input[type="tel"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #40E0D0;
            border-radius: 5px;
            box-sizing: border-box;
        }
        
        input[type="radio"] {
            margin-right: 5px;
        }
        
        button[type="submit"],
        button[type="reset"] {
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
        
        button[type="submit"]:hover,
        button[type="reset"]:hover {
            background-color: #20B2AA;
        }
    </style>
<body>
<form method="post" action="./update.php">
                
<div class="radio-group">
            <label for="title">Title:</label>
            <label for="mr">Mr.</label>
            <input type="radio" id="mr" name="title" value="Mr." required>
        
            <label for="mrs">Mrs.</label>
            <input type="radio" id="mrs" name="title" value="Mrs." required>
        
            <label for="ms">Ms.</label>
            <input type="radio" id="ms" name="title" value="Ms." required>
        </div>

        <div>
            <label for="user_name">User Name:</label>
            <input type="text" id="user_name" name="user_name" placeholder="User Name" required>
        </div>

        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Name" required>
        </div>

        <div>
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" placeholder="Age" required>
        </div>

        <div>
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" placeholder="Address" required>
        </div>

        <div>
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" placeholder="Email Address" required>
        </div>

        <div>
            <label for="phone_number">Phone Number:</label>
            <input type="tel" id="phone_number" name="phone_number" placeholder="Phone Number" required>
        </div>

        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Password"  maxlength="12" required>
        </div>

        <div>
            <button type="reset">Reset</button>
        </div>
        
        <div>
            <button type="submit">Submit</button>
        </div>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the updated user details from the form submission
    $user_name = $_POST["user_name"];
    $NAME = $_POST["name"];
  
    $age = $_POST["age"];
    $address = $_POST["address"];
    $email_address = $_POST["email"];
    $phone_number = $_POST["phone_number"];
    $password = $_POST['password'];

    // Connect to the database
    require_once("./database.php");

   

    // Prepare and execute the update query
    $stmt = $conn->prepare("UPDATE patients SET NAME=?, AGE=?, ADDRESS=?, EMAIL_ADDRESS=?, PHONE_NUMBER=?, PASSWORD=? WHERE USER_NAME=? ");
    $stmt->bind_param("sisssss", $NAME, $age, $address, $email_address, $phone_number, $password, $user_name);

    if ($stmt->execute()) {
       
        echo "<script>alert('User details updated successfully!');</script>";
        echo "<script>window.location.href = 'user_management.php';</script>";
        exit;
    } else {
       
        echo "Error updating user details: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
