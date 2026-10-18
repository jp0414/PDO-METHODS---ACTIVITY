<?php
// Include the database configuration file to establish the $pdo connection instance
require_once '../core/dbConfig.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Germany Grocery Directory</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 30px;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .summary-table {
            width: 50%;
        }

        .debug-box {
            background-color: #f4f4f4;
            padding: 10px;
            border-left: 5px solid #007BFF;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <!-- ========================================================== -->
    <h2>5. Database Fetch All Debug Preview</h2>
    <div class="debug-box">
        <?php
        // Prepare a SQL statement to get rows within your initial constraints
        $debugStmtAll = $pdo->prepare("SELECT * FROM germany_grocery_items WHERE grocery_item_id BETWEEN 1 AND 50 AND unit_price BETWEEN 1.00 AND 5.00");
        if ($debugStmtAll->execute()) {
            // Open the HTML <pre> tag to preserve the multidimensional array formatting structure
            echo "<pre>";
            // fetchAll() retrieves EVERY matching record from the query at once into a single giant array
            $allGroceryItems = $debugStmtAll->fetchAll();
            // Output the full structural dump using print_r()
            print_r($allGroceryItems);
            // Close the preformatting container tag
            echo "</pre>";
        }
        ?>
    </div>

    <!-- ========================================================== -->
    <h2>6. Database Single Row Fetch Debug Preview</h2>
    <div class="debug-box">
        <?php
        // Prepare a statement to select records from the table
        $debugStmtSingle = $pdo->prepare("SELECT * FROM germany_grocery_items WHERE grocery_item_id BETWEEN 1 AND 50 AND unit_price BETWEEN 1.00 AND 5.00");
        if ($debugStmtSingle->execute()) {
            // Open the HTML <pre> tag to format the array print beautifully on the screen
            echo "<pre>";
            // fetch() grabs only ONE row at a time. Calling it once extracts just the first row in the query.
            $singleGroceryItem = $debugStmtSingle->fetch();
            // Output the data structure of this single specific record via print_r()
            print_r($singleGroceryItem);
            // Close the preformatting container tag
            echo "</pre>";
        }
        ?>
    </div>

    <!-- ========================================================== -->
    <h2>7. Show Code Demonstrating Insertion of Record to Your Database</h2>
    <div class="debug-box">
        <?php
        // Define the query to insert a new record into the table using named placeholders
        // I explicitly supply grocery_item_id since it is not an auto-incrementing field
        $insertQuery = "INSERT INTO germany_grocery_items (grocery_item_id, grocery_item_name, brand_name, category, unit_price) 
                    VALUES (:item_id, :item_name, :brand, :category, :price)";

        // Prepare the SQL statement for safe execution
        $insertStmt = $pdo->prepare($insertQuery);

        // Provide the actual values to be bound to the statement placeholders
        $newRecordData = [
            ':item_id' => 101,
            ':item_name' => 'Chocolate Croissant',
            ':brand' => 'Bakery Fresh',
            ':category' => 'Bakery',
            ':price' => 2.49
        ];

        // Execute the prepared statement with the data array
        if ($insertStmt->execute($newRecordData)) {
            // Open the HTML <pre> tag to format the debug text beautifully on the screen
            echo "<pre>";

            // Output a clean message stating that the insert operation succeeded
            echo "Insertion successful! A new record has been added to the database.";

            // Close the preformatting container tag
            echo "</pre>";
        }
        ?>
    </div>

    <!-- ========================================================== -->
    <h2>8. Show Code Demonstrating Deletion of Record to Your Database</h2>
    <div class="debug-box">
        <?php
        // Define the query to delete a specific record from the table based on its unique ID
        $deleteQuery = "DELETE FROM germany_grocery_items WHERE grocery_item_id = :item_id";

        // Prepare the SQL statement for safe execution
        $deleteStmt = $pdo->prepare($deleteQuery);

        // Provide the actual ID value to be bound to the statement placeholder
        $deleteRecordData = [
            ':item_id' => 101
        ];

        // Execute the prepared statement with the data array
        if ($deleteStmt->execute($deleteRecordData)) {
            // Open the HTML <pre> tag to format the debug text beautifully on the screen
            echo "<pre>";

            // Output a clean message stating that the delete operation succeeded
            echo "Deletion successful! Record with ID 101 has been removed from the database.";

            // Close the preformatting container tag
            echo "</pre>";
        }
        ?>
    </div>

    <!-- ========================================================== -->
    <h2>9. Show Code Demonstrating Updating of Record from Your Database</h2>
    <div class="debug-box">
        <?php
        // Define the query to update specific column fields of a record based on its unique ID
        $updateQuery = "UPDATE germany_grocery_items 
                    SET grocery_item_name = :item_name, unit_price = :price 
                    WHERE grocery_item_id = :item_id";

        // Prepare the SQL statement for safe execution
        $updateStmt = $pdo->prepare($updateQuery);

        // Provide the new values and the matching record ID to be bound to the placeholders
        $updateRecordData = [
            ':item_name' => 'Premium Potato Flakes', // Changing the name slightly
            ':price' => 2.49,                     // Updating the unit price from 1.99 to 2.49
            ':item_id' => 100                       // Targeting the record with ID 100
        ];

        // Execute the prepared statement with the data array
        if ($updateStmt->execute($updateRecordData)) {
            // Open the HTML <pre> tag to format the debug text beautifully on the screen
            echo "<pre>";

            // Output a clean message stating that the update operation succeeded
            echo "Update successful! Record with ID 100 has been modified in the database.";

            // Close the preformatting container tag
            echo "</pre>";
        }
        ?>
    </div>

    <!-- ========================================================== -->
    <h2>10. Show Code Demonstrating an SQL Query's Result Set Rendered on an HTML Table</h2>
    <div class="table-container">
        <?php
        // Prepare a statement to select all grocery items from the table
        $tableStmt = $pdo->prepare("SELECT grocery_item_id, grocery_item_name, brand_name, category, unit_price FROM germany_grocery_items");

        // Execute the prepared query
        if ($tableStmt->execute()) {
            // Fetch all of the matching records at once into an associative array
            $groceryRows = $tableStmt->fetchAll(PDO::FETCH_ASSOC);

            // Check if there is data returned from the database to display
            if (!empty($groceryRows)) {
                // Begin the HTML table structure
                echo "<table border='1' cellpadding='10' cellspacing='0' style='width:100%; border-collapse: collapse;'>";

                // Output the table header row containing the column titles
                echo "<thead>
                    <tr>
                        <th>ID</th>
                        <th>Item Name</th>
                        <th>Brand</th>
                        <th>Category</th>
                        <th>Unit Price</th>
                    </tr>
                  </thead>";

                // Begin the table body container
                echo "<tbody>";

                // Loop through each individual database row array to populate the cells
                foreach ($groceryRows as $row) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['grocery_item_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['grocery_item_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['brand_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['category']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['unit_price']) . "</td>";
                    echo "</tr>";
                }

                // Close the body and main table container elements
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>No records found in the table.</p>";
            }
        }
        ?>
    </div>
</body>

</html>