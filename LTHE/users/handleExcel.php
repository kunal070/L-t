<?php
require_once('../process/dbh.php');
session_start();
$role = $_SESSION["role"]; // Replace this with the actual role of the user

if (!(isset($_SESSION['User_ID']) && isset($_SESSION['role']))) {
  echo '
  <script>
      window.location.href = "../login.html";
  </script>
  ';
} 
?>


<?php
    include_once 'xlsx.php';
    require_once '../process/dbh.php';

    if (isset($_FILES['excel']['name'])) {
        if ($conn) {
            $excel = SimpleXLSX::parse($_FILES['excel']['tmp_name']);
            echo "<pre>";
            

            $firstRowSkipped = false;
            $poNumArray = array(); // Array to store the PO_Numbers


            foreach ($excel->rows() as $row) {
                if (!$firstRowSkipped) {
                    $firstRowSkipped = true;
                    continue;
                }

                $poNum = $row[1]; // Assuming "PO_Number" is in the second column (index 1)
                $poNumArray[] = $poNum; // Add the PO_Number to the array

                // Check if the current "PO_Number" already exists in the database
                $query = "SELECT COUNT(*) FROM configuration WHERE PO_Number = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('s', $poNum); // Bind the parameter
                $stmt->execute();
                $result = $stmt->get_result()->fetch_assoc();

                if ($stmt->error) {
                    // Handle the database error
                    // For example, you can log the error or display an error message to the user
                    echo "Database error: " . $stmt->error;
                    continue;  // Skip to the next row
                }

                $createdby = $_SESSION["User_ID"];

                if ($result['COUNT(*)'] > 0) {
                    // "PO_Number" already exists, update the existing row
                    // Modify the following code to match your table structure and column names
                    $query = "UPDATE configuration SET Package=?, Supplier=?, Location=?, Currency=?, Per_day_rate=?, Provision=?, Construction_day=?, Pre_Construction=?, DLP_days=?, Remarks=?, Created_by=? WHERE PO_Number=?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('ssssssssssss', $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11], $createdby, $poNum);
                    $stmt->execute();

                    if ($stmt->error) {
                        // Handle the database error
                        // For example, you can log the error or display an error message to the user
                        echo "Database error: " . $stmt->error;
                    }
                } else {
                    // Insert the row data into the database
                    // Modify the following code to match your table structure and column names
                    $query = "INSERT INTO configuration (PO_Number, Package, Supplier, Location, Currency, Per_day_rate, Provision, Construction_day, Pre_Construction, DLP_days, Remarks, Created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('ssssssssssss', $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11], $createdby);
                    $stmt->execute();

                    $query1 = "INSERT INTO purchase_order (PO_num) SELECT ? WHERE NOT EXISTS (SELECT * FROM purchase_order WHERE PO_num = ?)";
                    $stmt1 = $conn->prepare($query1);
                    $stmt1->bind_param('ss', $row[1], $row[1]);
                    $stmt1->execute();

                    $query2 = "INSERT INTO location_name (location) SELECT ? WHERE NOT EXISTS (SELECT * FROM location_name WHERE location = ?)";
                    $stmt2 = $conn->prepare($query2);
                    $stmt2->bind_param('ss', $row[4], $row[4]);
                    $stmt2->execute();

                    $query3 = "INSERT INTO package_name (Package) SELECT ? WHERE NOT EXISTS (SELECT * FROM package_name WHERE Package = ?)";
                    $stmt3 = $conn->prepare($query3);
                    $stmt3->bind_param('ss', $row[2], $row[2]);
                    $stmt3->execute();

                    if ($stmt->error) {
                        // Handle the database error
                        // For example, you can log the error or display an error message to the user
                        echo "Database error: " . $stmt->error;
                    }
                }
            }

            // Convert the PO_Number array to JSON
            $poNumJson = json_encode($poNumArray);

            // Retrieve the existing JSON value from the database
            $query = "SELECT PO_num FROM confidentiality WHERE email  = $createdby"; // Modify the query and table name according to your database structure
            $result = $conn->query($query);
            $existingJson = $result->fetch_assoc()['po_numbers'];

            if ($existingJson) {
                // Combine the existing JSON and new JSON
                $combinedJsonArray = array_merge(json_decode($existingJson, true), $poNumArray);
                $combinedJson = json_encode($combinedJsonArray);
            } else {
                // Use the new JSON if no existing JSON is found
                $combinedJson = $poNumJson;
            }

            // Update the database with the combined JSON value
            $updateQuery = "UPDATE confidentiality SET PO_num = ? WHERE email  = $createdby"; // Modify the query and table name according to your database structure
            $stmt5 = $conn->prepare($updateQuery);
            $stmt5->bind_param('s', $combinedJson);
            $stmt5->execute();

            // Show alert and redirect
            echo '<script>alert("Database successfully stored"); window.location.href = "configure.php";</script>';
            exit();
        }
    }
?>
