<?php
require_once("database.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize the input
    $inventoryId = $_POST["editInventoryId"];
    $chemicalName = mysqli_real_escape_string($conn, $_POST["editChemicalName"]);
    $price = $_POST["editPrice"];
    $quantity = $_POST["editQuantity"];
    $purchaseDate = $_POST["editPurchaseDate"];
    $invoice = mysqli_real_escape_string($conn, $_POST["editInvoice"]);

    // Update the inventory record in the database
    $query = "UPDATE inventory SET 
                CHEMICAL_NAME = '$chemicalName', 
                PRICE = '$price', 
                QUANTITY = '$quantity', 
                PURCHASE_DATE = '$purchaseDate', 
                INVOICE = '$invoice' 
              WHERE INVENTORY_ID = '$inventoryId'";
    
    $result = mysqli_query($conn, $query);

    if ($result) {
      
        echo "<script>alert(' Inventory record updated successfully!');</script>";
        echo "<script>window.location.href = 'inventory.php';</script>";
        exit();
    } else {
        echo "Error updating inventory record: " . mysqli_error($conn);
        echo "<br>";
        echo "<a href='inventory.php'>Go back to Inventory</a>";
    }
}

// Close the database connection
mysqli_close($conn);
?>
