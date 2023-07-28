<?php
require_once("database.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['drugId'])) {
    $drugId = $_GET['drugId'];

    // Delete the drug record
    $query = "DELETE FROM drugs WHERE DRUG_ID = '$drugId'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('drug deleted successfully!');</script>";
        echo "<script>window.location.href = 'drug_management.php';</script>";
        exit();
        
    } else {
        echo "<script>alert('error deleting drug !');</script>";
        echo "<script>window.location.href = 'drug_management.php';</script>";
        exit();
       
    }
}

// Close the database connection
mysqli_close($conn);
?>
