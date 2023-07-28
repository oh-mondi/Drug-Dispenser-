<?php
require_once("database.php");

// Check if the inventoryId parameter is provided
if (isset($_GET['inventoryId'])) {
    $inventoryId = $_GET['inventoryId'];

    // Delete the inventory record from the database
    $query = "DELETE FROM inventory WHERE INVENTORY_ID = '$inventoryId'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Inventory record deleted successfully.";
        echo "<script>alert(' Inventory record deleted successfully!');</script>";
        echo "<script>window.location.href = 'inventory.php';</script>";
        exit();
    } else {
        echo "Error deleting inventory record: " . mysqli_error($conn);
        echo "<br>";
            echo "<a href='inventory.php'>Go back to Inventory</a>";
    }
} else {
    echo "Invalid request. Please provide an inventoryId parameter.";
    echo "<br>";
            echo "<a href='inventory.php'>Go back to Inventory</a>";
}

// Close the database connection
mysqli_close($conn);
?>
