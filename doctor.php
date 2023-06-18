<!DOCTYPE html>
<html>
<head>
    <title>Doctor Dashboard</title>
    <style>
       
        ul.navbar {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333;
        }

        ul.navbar li {
            float: left;
        }

        ul.navbar li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        ul.navbar li a:hover {
            background-color: #111;
        }
    </style>
</head>
<body>
    <ul class="navbar">
        <li><a href="#">Home</a></li>
        <li>
            <?php
            session_start();

            $username = $_SESSION['username'];
            echo "$username";
            ?>
        </li>
        <li style="float: right;"><a href="#">Logout</a></li>
    </ul>

    <h1>Welcome, Doctor!</h1>

   

</body>
</html>