<?php
require_once('../process/dbh.php');

if (isset($_GET['po'])) {
    $po = mysqli_real_escape_string($conn, $_GET['po']);

    // Query the database to retrieve the required data based on $po
    $query = "SELECT Package, Location FROM `configuration` WHERE PO_Number = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $po);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $package = $row['Package'];
        $location = $row['Location'];

        // Create an array to hold the response
        $response = array(
            'Package' => $package,
            'Location' => $location
        );

        // Convert the response to JSON and echo it
        $jsonResponse = json_encode($response);
        echo $jsonResponse;
    }
}
?>
