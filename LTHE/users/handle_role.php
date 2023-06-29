<?php
require_once('../process/dbh.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the submitted values
    $emails = $_POST['email'];
    $roles = $_POST['role'];

    // Process the retrieved values
    for ($i = 0; $i < count($emails); $i++) {
        $email = $emails[$i];
        $role = $roles[$i];

        // Perform necessary database operations with the email and role values
        // ...

        $query = "UPDATE confidentiality SET Role = '$role' WHERE email  = '$email';";
        mysqli_query($conn, $query);


        $query = "UPDATE login SET Role = '$role' WHERE Email = '$email';";
        $result= mysqli_query($conn, $query);

    }

    if($result){
        echo "done changes";
    } 
} else {
    // Handle the case when the form is not submitted
  
}
?>

