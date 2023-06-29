<?php
require_once('../process/dbh.php');

if (isset($_GET['PO_num'])) {
    $selectedpkg = mysqli_real_escape_string($conn, $_GET['PO_num']);

    // Query the database to retrieve the required data based on $selectedpkg
    $query = "SELECT Tag_num FROM `tag_mapping` WHERE PO_Number = '$selectedpkg' ";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $tag_numbers = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $tag_numbers[] = $row['Tag_num'];
        }

        $response = json_encode($tag_numbers);
        echo $response;
    }
}
?>
