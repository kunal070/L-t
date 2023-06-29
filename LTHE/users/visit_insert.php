<?php
session_start();
require_once ('../process/dbh.php');
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['PO_Number']) && isset($_POST['Package']) && isset($_POST['location'])) { 

        $ponumber = $_POST['PO_Number'];
        $package = $_POST['Package'];
        $location = $_POST['location'];
        $activities = $_POST['Activity'];
        $tags = $_POST['Tag_num'];
        $startDates = $_POST['Start_date'];
        $endDates = $_POST['End_date'];
        $createdby = $_SESSION["User_ID"];
        $role = $_SESSION["role"];
        $c = count($activities);

        // Sanitize the input if necessary
        $ponumber = mysqli_real_escape_string($conn, $ponumber);
        // ...

        // Update the database with the new value
        $new_value = $ponumber;
        $updateQuery = "UPDATE confidentiality SET PO_num = JSON_ARRAY_APPEND(PO_num, '$', ?) WHERE email = ?"; // Replace 'column_name' with the correct column name

        // Prepare the statement
        $stmt = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($stmt, "is", $new_value, $createdby); // Assuming $new_value is an integer

        // Execute the prepared statement
        $result = mysqli_stmt_execute($stmt);


        if ($c > 0) {
          $activityArray = [];
          $tagArray = [];
          $startDateArray = [];
          $endDateArray = [];
      
          for ($i = 0; $i < $c; $i++) {
              ${"activity" . $i} = $activities[$i];
              ${"tag" . $i} = $tags[$i];
              ${"startDate" . $i} = $startDates[$i];
              ${"endDate" . $i} = $endDates[$i];
      
              $startTime = strtotime(${"startDate" . $i});
              $endTime = strtotime(${"endDate" . $i});
      
              if ($startTime <= $endTime) {
                  $activityArray[] = ${"activity" . $i};
                  $tagArray[] = ${"tag" . $i};
                  $startDateArray[] = ${"startDate" . $i};
                  $endDateArray[] = ${"endDate" . $i};
              } else {
                  echo ("date Problem");
                  exit;
              }
          }
      
          $activityJSON = json_encode($activityArray);
          $tagJSON = json_encode($tagArray);
          $startDateJSON = json_encode($startDateArray);
          $endDateJSON = json_encode($endDateArray);
          $draft=0;
      
          $sql = "INSERT INTO temp1(Purc_num, Package, loaction, Description, Tag_no, start_date, final_date, Created_by, Role,Draft)
                  VALUES ('$ponumber', '$package', '$location', '$activityJSON', '$tagJSON', '$startDateJSON', '$endDateJSON', '$createdby', '$role','$draft')";
          $result = mysqli_query($conn, $sql);
      }

      if ($result) {
        echo "Data inserted successfully";
    } else {
        echo "Error updating database";
    }
    } else {
        echo "Select all fields";
    }
  }

?>
