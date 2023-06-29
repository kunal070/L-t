<?php
require_once('../process/dbh.php');

if (isset($_GET['pkg'])) {
    $pkg =  $_GET['pkg'];

    // Query the database to retrieve the required data based on $po
    $query = "SELECT PO_Number, Location FROM `configuration` WHERE Package = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $pkg);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $PO_Number = $row['PO_Number'];
        $location = $row['Location'];

        // Create an array to hold the response
        $response = array(
            'PO_Number' => $PO_Number,
            'Location' => $location
        );

        // Convert the response to JSON and echo it
        $jsonResponse = json_encode($response);
        echo $jsonResponse;
    }
}
?>
