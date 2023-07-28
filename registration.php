<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <style>
     h1 {
            text-align: center;
            color: #40E0D0;
        }
        body {
            background-color: #472786;
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
       
        button[type="proceed"] {
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
        
       
        button[type="proceed"]:hover {
            background-color: #20B2AA;
        }
        </style>
</head>
<body>
  
    <form method="POST" name="signup_form">
    <h1>Register as:</h1>
        <div id="section1" name="section1">
            <select name="firstComboBox" id="firstComboBox">
                <option value="select">Select</option>
                <option value="patient">Patient</option>
                <option value="doctor">Doctor</option>
                <option value="pharmacist">Pharmacist</option>
                <option value="admin">Admin</option>
            </select>
        </div>
<br>
<br>
<br>

        <button type="proceed">Proceed</button>

        <div>
            <?php
            require_once("database.php");
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
                $selectedTable = $_POST["firstComboBox"];
            
                // Further validation or sanitization can be applied if necessary
             
                // Prepare the query based on the selected table
                switch ($selectedTable) {
                    case "patient":
                        $redirectURL = "register_patient.php"; // Redirect to the patient page
                        break; 
                    case "doctor":
                        $redirectURL = "register_doctor.php"; // Redirect to the doctor page
                        break;
                    case "pharmacist":
                        $redirectURL = "register_pharmacist.php"; // Redirect to the pharmacist page
                        break;
                    case "admin":
                        $redirectURL = "register_admin.php"; // Redirect to the admin page
                        break;
                    default:
                      
                        $redirectURL = ""; // Invalid table, no redirect
                        break;
                }

                // Redirect to the selected registration page
                if (!empty($redirectURL)) {
                    header("Location: " . $redirectURL);
                    exit;
                }
            }
         
            ?>
        </div>
    </form>
</body>
</html>
