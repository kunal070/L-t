<?php
// Get the sorting column and $createdby from the query parameters
require_once('../process/dbh.php');

$column = $_GET['column'];
$createdby = $_GET['createdby'];

// Add your sorting logic here based on the $column variable
// Modify your original query to include the ORDER BY clause based on the selected column

// Example:
$query = "SELECT t.v_id, t.package, DATE_FORMAT(JSON_UNQUOTE(JSON_EXTRACT(t.S_date, '$[0]')), '%d-%m-%Y') AS S_date, t.PO_num, t.status
          FROM temp_approve t
          WHERE t.status IN (0, 1, 3) AND EXISTS (
            SELECT 1 FROM confidentiality c
            WHERE c.email = '$createdby' AND JSON_CONTAINS(c.PO_num, JSON_ARRAY(t.PO_num), '$')
            ) ORDER BY " . $column;

// Execute the query and fetch the sorted data
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
  $rows = array();
  
  // Fetch the sorted data
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }

  // Convert the data to JSON format
  $jsonResponse = json_encode($rows);

  // Set the response content type to JSON
  header('Content-Type: application/json');

  // Send the JSON response
  echo $jsonResponse;
} else {
  echo "Error: " . mysqli_error($conn);
}
?>
