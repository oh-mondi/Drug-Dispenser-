<?php
require_once("database.php");

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $editMode = isset($_POST["editMode"]) ? $_POST["editMode"] : "";
    $inventoryId = isset($_POST["inventoryId"]) ? $_POST["inventoryId"] : "";
    $drugId = isset($_POST["drugId"]) ? $_POST["drugId"] : "";
    $companyId = isset($_POST["companyId"]) ? $_POST["companyId"] : "";
    $chemicalName = isset($_POST["chemicalName"]) ? $_POST["chemicalName"] : "";
    $price = isset($_POST["price"]) ? $_POST["price"] : "";
    $quantity = isset($_POST["quantity"]) ? $_POST["quantity"] : "";
    $purchaseDate = isset($_POST["purchaseDate"]) ? $_POST["purchaseDate"] : "";
    $invoice = isset($_POST["invoice"]) ? $_POST["invoice"] : "";

    // Perform validation if needed

    if ($editMode === "edit") {
        // Update existing inventory record
        $updateQuery = "UPDATE inventory SET
            DRUG_ID = '$drugId',
            COMPANY_ID = '$companyId',
            CHEMICAL_NAME = '$chemicalName',
            PRICE = '$price',
            QUANTITY = '$quantity',
            PURCHASE_DATE = '$purchaseDate',
            INVOICE = '$invoice'
            WHERE INVENTORY_ID = '$inventoryId'";

        $result = mysqli_query($conn, $updateQuery);

        if ($result) {
            echo "Inventory record updated successfully.";
            echo "<br>";
            echo "<a href='inventory.php'>Go back to Inventory</a>";
        } else {
            echo "Error updating inventory record: " . mysqli_error($conn);
            echo "<br>";
            echo "<a href='inventory.php'>Go back to Inventory</a>";
        }
    } else {
        // Insert new inventory record
        $insertQuery = "INSERT INTO inventory (DRUG_ID, COMPANY_ID, CHEMICAL_NAME, PRICE, QUANTITY, PURCHASE_DATE, INVOICE) VALUES 
            ('$drugId', '$companyId', '$chemicalName', '$price', '$quantity', '$purchaseDate', '$invoice')";

        $result = mysqli_query($conn, $insertQuery);

        if ($result) {
           
        echo "<script>alert('New Inventory record added successfully!');</script>";
        echo "<script>window.location.href = 'inventory.php';</script>";
        exit();
        } else {
            echo "Error adding new inventory record: " . mysqli_error($conn);
            echo "<br>";
            echo "<a href='inventory.php'>Go back to Inventory</a>";
        }
    }
} else {
    echo "Invalid request.";
    echo "<br>";
    echo "<a href='inventory.php'>Go back to Inventory</a>";
}

// Close the database connection
mysqli_close($conn);
?>
