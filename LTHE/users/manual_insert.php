<?php
session_start();
if (isset($_POST['po_number'])) {
  require_once('../process/dbh.php'); // Assuming the database connection is established in dbh.php

  $existingPoNumbers = array();
  $existingQuery = "SELECT PO_Number FROM configuration";
  $existingResult = $conn->query($existingQuery);
  if ($existingResult->num_rows > 0) {
    while ($row = $existingResult->fetch_assoc()) {
      $existingPoNumbers[] = $row['PO_Number'];
    }
  }
  $existingResult->close();

  try {
    $poNumbers = $_POST['po_number'];
    $packages = $_POST['package'];
    $suppliers = $_POST['supplier'];
    $locations = $_POST['location'];
    $currencies = $_POST['currency'];
    $perDayRates = $_POST['per_day_rate'];
    $provisions = $_POST['provision'];
    $constructionDays = $_POST['construction_days'];
    $precommDays = $_POST['precomm_days'];
    $dlpDays = $_POST['dlp_days'];
    $remarks = $_POST['remarks'];
    $createdby = $_SESSION["User_ID"];


    // Prepare the update statement
    $updateStmt = $conn->prepare("UPDATE configuration SET Package = ?, Supplier = ?, Location = ?, Currency = ?, Per_Day_Rate = ?, Provision = ?, Construction_day = ?, Pre_Construction = ?, Dlp_Days = ?, Remarks = ?, Created_by = ? WHERE PO_Number = ?");

    // Prepare the insert statement
    $insertStmt = $conn->prepare("INSERT INTO configuration (PO_Number, Package, Supplier, Location, Currency, Per_Day_Rate, Provision, Construction_day, Pre_Construction, Dlp_Days, Remarks, Created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    foreach ($poNumbers as $i => $poNumber) {
      // Bind parameters for update statement
      $updateStmt->bind_param(
        "ssssssssssss",
        $packages[$i],
        $suppliers[$i],
        $locations[$i],
        $currencies[$i],
        $perDayRates[$i],
        $provisions[$i],
        $constructionDays[$i],
        $precommDays[$i],
        $dlpDays[$i],
        $remarks[$i], 
        $createdby,
        $poNumber
      );

      // Bind parameters for insert statement
      $insertStmt->bind_param(
        "ssssssssssss",
        $poNumber,
        $packages[$i],
        $suppliers[$i],
        $locations[$i],
        $currencies[$i],
        $perDayRates[$i],
        $provisions[$i],
        $constructionDays[$i],
        $precommDays[$i],
        $dlpDays[$i],
        $remarks[$i], 
        $createdby
      );

      if (in_array($poNumber, $existingPoNumbers)) {
        // Update the existing record
        if (!$updateStmt->execute()) {
          echo "Error updating data: " . $updateStmt->error;
        }
      } else {
        // Insert a new record
        if (!$insertStmt->execute()) {
          echo "Error inserting data: " . $insertStmt->error;
        }
        $existingPoNumbers[] = $poNumber;
      }
    }

    echo "Data inserted successfully";
  } catch (mysqli_sql_exception $e) {
    // Handle database connection errors
    echo "Connection failed: " . $e->getMessage();
  }
}
?>
