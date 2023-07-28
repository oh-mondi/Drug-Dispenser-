<!DOCTYPE html>
<head>
    <title> Admin Registration</title>
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
        
     
        
        input[type="username"],
        input[type="first"],
        input[type="last"],
        input[type="age"],
        input[type="email"], 
        input[type="phone"],
        input[type="address"],
        input[type="pass"]
        {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #40E0D0;
            border-radius: 5px;
            box-sizing: border-box;
        }
        
       
        
       
        button[type="submit"] {
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
    <form method="POST">
        <h1> Admin Registration</h1>
        <div>
        <label for="username">Username:
        <input name="username" >
</div>
<div>   
            <label for="first">First Name:
            <input name="first" >
            </div>
            <div>   
            <label for="last"> Last Name:
            <input name="last">
            </div>
            <div>   
            <label for="age">Age:
            <input name="age">
            </div>
            <div> 
            <label for="address" >Address:
            <input name="address" >
            </div>
            <div> 
            <label for="email">Email:
            <input name="email" > 
            </div>
            <div> 
            <label for="phone"> Phone Number:
            <input name="phone">
            </div>
            <div>
            <label for="pass">Password:
            <input name="pass" >
            </div>
            <button name="submit">Submit:</button>
            <?php
require_once("database.php");

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $user_name = $_POST["username"];
    $NAME = $_POST["first"];
    $last = $_POST["last"];
    $age = $_POST["age"];
    $address = $_POST["address"];
    $email_address = $_POST["email"];
    $phone_number = $_POST["phone"];
    $password = $_POST['pass'];

    // Prepare the SQL statement
    $sql = "INSERT INTO admin (USER_NAME, FIRST_NAME, LAST_NAME,AGE, ADDRESS, EMAIL_ADDRESS, PHONE_NUMBER, PASSWORD) 
            VALUES (?, ?, ?, ?, ?, ?, ?,?)";

    // Prepare and bind the parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssissss', $user_name, $NAME,$last, $age, $address, $email_address, $phone_number, $password);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>alert('Thank you for registering!');</script>";
        echo "<script>window.location.href = 'loginform.html';</script>";
        exit;
    } else {
        echo "Error inserting data: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
</form>
</body>
</html>