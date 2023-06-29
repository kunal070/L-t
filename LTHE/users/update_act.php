<?php
// Assuming you have established a database connection
require_once('../process/dbh.php'); // Assuming the database connection is established in dbh.php

// Retrieve the selected activity from the client
$selectedActivity = $_GET['activity'];
$selectedVId = $_GET['v_id'];

// Fetch the row with the specified v_id
$query = "SELECT Description, Tag_no, start_date, final_date FROM temp1 WHERE v_id = '$selectedVId'";
$result = mysqli_query($conn, $query);

$data = array();

// Check if the row exists
if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);

  // Decode the Description column as JSON
  $description = json_decode($row['Description'], true);

  // Find the index of the selected activity in the JSON array
  $selectedActivityIndex = array_search($selectedActivity, $description);

  // Check if the selected activity is found
  if ($selectedActivityIndex !== false) {
    // Retrieve the corresponding data from other columns using the index
    $tagNumbers = json_decode($row['Tag_no'], true);
    $startDates = json_decode($row['start_date'], true);
    $endDates = json_decode($row['final_date'], true);

    $data['tagNumber'] = $tagNumbers[$selectedActivityIndex];
    $data['startDate'] = $startDates[$selectedActivityIndex];
    $data['endDate'] = $endDates[$selectedActivityIndex];
  }
}

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($data);
?>
