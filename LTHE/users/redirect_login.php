<?php
// Start the session
session_start();
?>

<?php
require_once('../process/dbh.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['visit_id'])) {
        $visitId = $_POST['visit_id'];
  
        $email = $_POST['unames'];
        $password = $_POST['passwords'];

        // Prepare and bind the parameters to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM login WHERE Email = ? AND Password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $Role = $row["Role"];
            $id = $row["Email"];
            $name = $row["Name"];

            if ($Role == "User" || $Role == "Approver") {
                $_SESSION["role"] = $Role;
                $_SESSION["User_ID"] = $id;
                $_SESSION["User_Name"] = $name;

                // Redirect to the desired page with the visit_id
                header("Location: update_actuals.php?visit_id=" . urlencode($visitId));
                exit;
            } else if ($Role == "Admin") {
                echo "Welcome " . $name;
            }
        } else {
            echo "Invalid Email or Password.";
        }
    }
}
?>
