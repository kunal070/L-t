<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once('../process/dbh.php');

    // Retrieve the submitted values
    $existingPONumbers = $_POST['existingPONumbers'];
    $email = $_POST['email'];

    // Remove double quotes around each number
    $existingPONumbers = array_map('intval', $existingPONumbers);

    // Convert the array to JSON string
    $existingPONumbersJSON = json_encode($existingPONumbers);
    $query = "UPDATE confidentiality SET PO_num = '$existingPONumbersJSON' WHERE email = '$email';";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Show alert for successful update
        echo '<script>alert("Changes applied successfully.");</script>';
        
        // Redirect to login.php
        echo '<script>window.location.href = "admin.php";</script>';
    } else {
        // Show alert for unsuccessful update
        echo '<script>alert("Failed to apply changes.");</script>';
    }
} else {
    // Handle the case when the form is not submitted
    echo "Form not submitted.";
}
?>
