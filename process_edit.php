<?php
require_once("database.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the edited drug data from the form
    $editDrugId = $_POST['editDrugId'];
    $editChemicalName = $_POST['editChemicalName'];
    $editMass = $_POST['editMass'];
    $editPrice = $_POST['editPrice'];

    // Update the drug record in the database
    $query = "UPDATE drugs SET CHEMICAL_NAME = '$editChemicalName',MASS ='  $editMass', PRICE = '$editPrice' WHERE DRUG_ID = '$editDrugId'";
    $result = mysqli_query($conn, $query);

    if ($result) {
     
        echo "<script>alert('Drug updated successfully!');</script>";
        echo "<script>window.location.href = 'drug_management.php';</script>";
        exit();
     } else {
        echo "Error updating drug: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>
echo "<script>alert('drug deleted successfully!');</script>";
        echo "<script>window.location.href = 'drug_management.php';</script>";
        exit()