<?php
    session_start();
    require_once('../process/dbh.php'); // Assuming the database connection is established in dbh.php
    $id = $_SESSION["User_ID"];
    $role = $_SESSION["role"]; // Replace this with the actual role of the user

    if (!(isset($_SESSION['User_ID']) && isset($_SESSION['role']))) {
      echo '
      <script>
          window.location.href = "../login.html";
      </script>
      ';
  } 
?>
<?php 
$visitId = $_GET['visit_id'];
if(isset($_GET['flag'])){
  $flag = $_GET['flag'];
}
require_once('../process/dbh.php');
// Retrieve the fields associated with the v_id
$query = "SELECT * FROM temp_approve WHERE v_id = $visitId";
$result = mysqli_query($conn, $query);

if ($result) {
  // Fetch the row as an associative array
  $row = mysqli_fetch_assoc($result);
  // Access the values of the fields
  $poNumber = $row['PO_num'];
  $package = $row['Package'];
  $location = $row['location'];
  $activity = $row['activity'];
  $tagNo = $row['Tag_no'];
  $startDate = $row['S_date'];
  $endDate = $row['E_date'];
  $actuals = $row['Actuals'];
  $actualStartDate = $row['A_Sdate'];
  $actualEndDate = $row['A_Edate'];
  $pay = $row['Pay'];
  $Status = $row['Status'];
  $activity = json_decode($row['activity'], true);
  $tagNo = json_decode($row['Tag_no'], true);
  $startDate = json_decode($row['S_date'], true);
  $endDate = json_decode($row['E_date'], true);
  $actuals = json_decode($row['Actuals'], true);
  $actualStartDate = json_decode($row['A_Sdate'], true);
  $actualEndDate = json_decode($row['A_Edate'], true);
  $pay = json_decode($row['Pay'], true);
  $pending = json_decode($row['For_Approval'], true);
  if (!empty($pending)) {
    $lastValue = end($pending);
} 
  $Rejected_date = json_decode($row['Rejected_date'], true);
  if (!empty($Rejected_date)) {
    $lastValue1 = end($Rejected_date);
} 
} else {
  echo "Error: " . mysqli_error($connection);
}
?>

<?php
if ($Status == 1) {
  // Redirect the user to view_only.php with the visit_id parameter
  header("Location: view_only.php?visit_id=$visitId");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <style>
    #activity-table {
      border-collapse: collapse;
      width: 100%;
    }

    #activity-table th,
    #activity-table td {
      border: 1px solid black;
      padding: 8px;
    }

    #activity-table th {
      background-color: #f2f2f2;
    }

    #activity-table td textarea {
      width: 100%;
      box-sizing: border-box;
    }
    .navbar-global {
      background-color: indigo;
    }

    .navbar-global .navbar-brand {
      color: white;
    }

    .navbar-global .navbar-user>li>a {
      color: white;
    }

    .navbar-primary {
      background-color: #333;
      bottom: 0px;
      left: 0px;
      position: fixed;
      top: 51px;
      width: 200px;
      z-index: 8;
      overflow: hidden;
      -webkit-transition: all 0.1s ease-in-out;
      -moz-transition: all 0.1s ease-in-out;
      transition: all 0.1s ease-in-out;
    }

    .navbar-primary.collapsed {
      width: 60px;
    }

    .navbar-primary.collapsed .glyphicon {
      font-size: 22px;
    }

    .navbar-primary.collapsed .nav-label {
      display: none;
    }

    .btn-expand-collapse {
      position: absolute;
      display: block;
      left: 0px;
      bottom: 0;
      width: 100%;
      padding: 8px 0;
      border-top: solid 1px #666;
      color: grey;
      font-size: 20px;
      text-align: center;
    }

    .btn-expand-collapse:hover,
    .btn-expand-collapse:focus {
      background-color: #222;
      color: white;
    }

    .btn-expand-collapse:active {
      background-color: #111;
    }

    .navbar-primary-menu,
    .navbar-primary-menu li {
      margin: 0;
      padding: 0;
      list-style: none;
    }

    .navbar-primary-menu li a {
      display: flex;
      align-items: center;
      padding: 10px 18px;
      text-align: left;
      border-bottom: solid 1px #444;
      color: #ccc;
    }

    .navbar-primary-menu li a:hover {
      background-color: #000;
      text-decoration: none;
      color: white;
    }

    .navbar-primary-menu li a .navbar-logo {
      margin-right: 10px;
    }

    .navbar-primary-menu li a .navbar-logo img {
      display: block;
      width: 30px;
      height: 30px;
      margin-right: 5px;
    }

    .main-content {
      margin-top: 60px;
      margin-left: 200px;
      padding: 20px;
    }

    .collapsed + .main-content {
      margin-left: 60px;
    }

    .navbar-logo {
      display: none;
    }

    .navbar-primary.collapsed .navbar-logo {
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      height: 24px;
      color: white;
    }

    .navbar-primary.collapsed .navbar-logo img {
      display: block;
      width: 30px;
      height: 30px;
      margin: 5px;
    }

    .homered{
        background-color: red;
        padding: 30px 10px 22px 10px;
    }
    .center {
    display: flex;
    justify-content: center;
    align-items: right;
    height: 10vh;
  }

  .logo {
    width: 20px;
    height: 15px;
  }

    #activity-table td textarea {
  width: 100%;
  box-sizing: border-box;
}
  </style>
</head>
<script>
  function confirmLogout() {
    if (confirm("Are you sure you want to logout?")) {
      window.location.href = "logout.php";
    }
  }
</script>

<script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.5.0/js/bootstrap.bundle.min.js"></script>

<body>
<nav class="navbar navbar-inverse navbar-global fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">LTHE</a>
    </div>
    <!--/.nav-collapse -->
    <ul class="nav navbar-nav navbar-right">
      <li>
      <a href="#" onclick="confirmLogout()" data-toggle="tooltip" data-placement="bottom" title="Logout">
          <img src="../process/images/logout.png" alt="Logout" width="30" height="30">
        </a>
      </li>
    </ul>
  </div>
</nav>
  <nav class="navbar-primary">
    <a href="#" class="btn-expand-collapse"><span class="glyphicon glyphicon-menu-left"></span></a>
    <ul class="navbar-primary-menu">
      <li>
        <a href="userlogin.php">
          <div class="navbar-logo">
            <img src="../process/images/Home.jpg" alt="Logo" width="30" height="30">
          </div>
          <span class="nav-label">Home</span>
        </a>
      </li>
      <li>
        <a href="configure.php">
          <div class="navbar-logo">
            <img src="../process/images/config.png" alt="Logo" width="30" height="30">
          </div>
          <span class="nav-label">Configure</span>
        </a>
      </li>
      <li>
        <a href="add_vendors.php">
          <div class="navbar-logo">
            <img src="../process/images/add_vendors.png" alt="Logo" width="30" height="30">
          </div>
          <span class="nav-label">Add Vendors</span>
        </a>
      </li>
      <li>
        <a href="create_visit.php">
          <div class="navbar-logo">
            <img src="../process/images/create_visit.jpg" alt="Logo" width="30" height="30">
          </div>
          <span class="nav-label">Create Visit</span>
        </a>
      </li>
      <li>
        <a href="update_actuals.php">
          <div class="navbar-logo">
            <img src="../process/images/update_actuals.png" alt="Logo" width="30" height="30">
          </div>
          <span class="nav-label">Update Actuals</span>
        </a>
      </li>
      <li>
        <a href="Approval_view.php" class="homered">
          <div class="navbar-logo">
            <img src="../process/images/view_details.jpeg" alt="Logo" width="30" height="30">
          </div>
          <span class="nav-label">View Details</span>
        </a>
      </li>
      <li>
        <a href="user_reports.php"  >
          <div class="navbar-logo">
            <img src="../process/images/report.png" alt="Logo" width="30" height="30">
          </div>
          <span class="nav-label">Reports</span>
        </a>
      </li>
      <?php
          if ($role == "Admin") {
              echo '<li>
                  <a href="admin.php">
                    <div class="navbar-logo">
                      <img src="../process/images/report.png" alt="Logo" width="30" height="30">
                    </div>
                    <span class="nav-label">Control Pane</span>
                  </a>
                </li>';
          }
          ?>
    </ul>
  </nav>
  <div class="main-content">
  <form method="post" action="email_store.php">
    <?php
    echo '<div style="display: flex; flex-direction: column; align-items: center; margin-top: 50px;">';
    echo '<table style="border-collapse: collapse;">';
    echo '<tr>';
    echo '<td style="padding-right: 10px;"><label for="visitID"><span style="font-size: 18px; font-weight: bold;">Visit ID:</span></label></td>';
    echo '<td><input type="text" name="visitID" id="visitID" value="' . $visitId . '" readonly style="font-size: 15px;"></td>';
    echo '<td style="width: 30px;"></td>'; // Adjusted width for spacing
    echo '<td style="padding-right: 10px;"><label for="poNumber"><span style="font-size: 18px; font-weight: bold;">PO Number:</span></label></td>';
    echo '<td><input type="text" name="poNumber" id="poNumber" value="' . $poNumber . '" style="font-size: 15px;"></td>';
    echo '<td style="width: 20px;"></td>'; // Empty <td> element for spacing
    echo '<td style="padding-right: 10px;"><label for="package"><span style="font-size: 18px; font-weight: bold;">Package:</span></label></td>';
    echo '<td><input type="text" name="package" id="package" value="' . $package . '" style="font-size: 15px;"></td>';
    echo '<td style="width: 20px;"></td>'; // Empty <td> element for spacing
    echo '<td style="padding-right: 10px;"><label for="location"><span style="font-size: 18px; font-weight: bold;">Location:</span></label></td>';
    echo '<td><input type="text" name="location" id="location" value="' . $location . '" style="font-size: 15px;"></td>';
    echo '</tr>';
    echo '</table>';
    echo '</div>';
    echo '<br>';
    echo '<br>';
    echo '<br>';

    echo '<div class="center">';
     echo ' <p><strong>Status:</strong>';
      
      if ($Status == 0) {
        echo "Pending";
        echo '<img class="logo" src="../process/images/pending_logo.jpeg" alt="Pending Logo">';
        echo 'from  ' . $lastValue;
      } else {
        echo "Rejected on";
        echo '<img class="logo" src="../process/images/rejected_logo.jpeg" alt="rejected Logo">';
        echo 'on  ' . $lastValue1;
      }
    echo' </p>'  ;
    echo'</div>' ;
    

    echo '<table id="activity-table">';
    echo '<tr>';

    $attributeNames = array('Activity', 'Tag No', 'Start Date', 'End Date', 'Actuals', 'Actual Start Date', 'Actual End Date', 'Pay','indi Remarks');
    $attributes = array($activity, $tagNo, $startDate, $endDate, $actuals, $actualStartDate, $actualEndDate, $pay);
    foreach ($attributeNames as $attribute) {
      echo '<th>' . $attribute . '</th>';
  }
  echo '<th>Delete</th>';

  echo '</tr>';
  
  // Determine the maximum count of elements among the arrays
  $maxCount = max(
      count($activity),
      count($tagNo),
      count($startDate),
      count($endDate),
      count($actuals),
      count($actualStartDate),
      count($actualEndDate),
      count($pay)  );

  $activityOptions = array();
  $query = "SELECT Description FROM temp1 WHERE v_id = $visitId";
  $result = mysqli_query($conn, $query);
  if ($result && mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
          $description = json_decode($row['Description'], true);
          foreach ($description as $option) {
              $activityOptions[] = $option;
          }
      }
  } else {
      echo "Error in query";
  }
      // Prepend "Other" option to the activityOptions array
  array_unshift($activityOptions, 'Other');

  for ($i = 0; $i < $maxCount; $i++) {
      echo '<tr>';
      for ($j = 0; $j < count($attributeNames); $j++) {
          if ($j === 0) {
              // Add "Activity" field as select option
              echo '<td><select name="' . strtolower(str_replace(' ', '_', $attributeNames[$j])) . '[]" style="font-size: 17px;">';
              foreach ($activityOptions as $option) {
                  $selected = ($attributes[$j][$i] ?? '') === $option ? 'selected' : '';
                  echo '<option value="' . htmlspecialchars($option) . '" ' . $selected . '>' . htmlspecialchars($option) . '</option>';
              }
              echo '</select></td>';
          } elseif ($j === 1) {
              // Add "tag_no" field as select option
              echo '<td><select name="' . strtolower(str_replace(' ', '_', $attributeNames[$j])) . '[]" style="font-size: 17px;">';
              $query = "SELECT Tag_num FROM `tag_mapping` WHERE PO_Number = '$poNumber' ";
              $result = mysqli_query($conn, $query);
      
              while ($row = mysqli_fetch_assoc($result)) {
                  $tagNum = $row['Tag_num'];
                  $selected = ($attributes[$j][$i] ?? '') === $tagNum ? 'selected' : '';
                  echo '<option value="' . htmlspecialchars($tagNum) . '" ' . $selected . '>' . htmlspecialchars($tagNum) . '</option>';
              }
              echo '</select></td>';
          } elseif ($j === 2 || $j === 3 || $j === 5 || $j === 6) {
              echo '<td><input type="date" name="' . strtolower(str_replace(' ', '_', $attributeNames[$j])) . '[]" value="' . ($attributes[$j][$i] ?? '') . '" style="font-size: 17px;"></td>';
          } elseif ($j === 7) {
              echo '<td><select name="' . strtolower(str_replace(' ', '_', $attributeNames[$j])) . '[]" style="font-size: 17px;">';
              echo '<option value="non-payable" ' . (($attributes[$j][$i] ?? '') === 'non-payable' ? 'selected' : '') . '>Non-Payable</option>';
              echo '<option value="payable" ' . (($attributes[$j][$i] ?? '') === 'payable' ? 'selected' : '') . '>Payable</option>';
              echo '</select></td>';
          }
          else {
            echo '<td><textarea name="' . strtolower(str_replace(' ', '_', $attributeNames[$j])) . '[]" rows="1" style="font-size: 17px;">' . ($attributes[$j][$i] ?? '') . '</textarea></td>';
        }        
      }
      echo '<td><button class="delete-row" data-row="' . $i . '">-</button></td>';
      echo '</tr>';
  }
  echo '</table>';
  echo ' <button id="addRowButton" type="button">+</button>';
  echo'<br>';
  echo'<br>';
  echo'<br>';
 

  echo '<div style="margin-left: 20px;">';
  echo '<label for="remarksBox"><strong>Overall Remarks:</strong></label>';
  echo '<br>';
  echo '<textarea id="remarksBox" name="Remarks" rows="3" cols="23" style="font-size: 17px;"></textarea>';
  echo '</div>';




  $button1Label = 'Approve';
  $button2Label = 'Reject';
  $button1Value = 'Approve';
  $button2Value = 'Not Approve';
    echo '<br>';

    echo '<div style="text-align: center; margin-top: 20px;">';
    echo '<button type="submit" name="button" value="' . $button1Value . '" style="background-color: green; color: white; margin-right: 10px; display: inline-block; width: 150px; height: 40px;">' . $button1Label . '</button>';
    if(!isset($_GET['flag'])){
      echo '<button type="submit" name="button" value="' . $button2Value . '" style="background-color: red; color: white; margin-right: 10px; display: inline-block; width: 150px; height: 40px;">' . $button2Label . '</button>';
    }
    echo '<button type="button" name="cancel" onclick="confirmRedirect(\'Approval_view.php\')" style="font-size: 16px; background-color: red; color: white; display: inline-block; width: 150px; height: 40px;">Cancel</button>';
    echo '</div>';

    ?>
    </form>
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
        var deleteButtons = document.querySelectorAll(".delete-row");
        deleteButtons.forEach(function (button) {
            button.addEventListener("click", function (event) {
                var rowIndex = event.target.getAttribute("data-row");
                var tableRow = event.target.parentNode.parentNode;

                // Prompt user for confirmation before deleting the row
                var confirmed = confirm("Are you sure you want to delete this row?");
                if (confirmed) {
                    tableRow.remove();

                    // TODO: Delete the corresponding row from the database using AJAX or form submission.
                    // You need to send the rowIndex or any identifier to identify the row to be deleted from the database.
                }
            });
        });
    });
</script>
  <script>
    function confirmRedirect(redirectUrl) {
        if (confirm("Are you sure you want to leave? ")) {
            window.location.href = redirectUrl;
        }
    }
</script>
<?php
$query = "SELECT Description FROM temp1 WHERE v_id = '$visitId'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $description = $row['Description'];
  
  // Decode the JSON data
  $activityArray = json_decode($description, true);
}
?>
?>

<script>
       // Get the button and table body references
      var addRowButton = document.getElementById("addRowButton");
      var tableBody = document.getElementById("activity-table");

      // Attach an event listener to the button
      addRowButton.addEventListener("click", function() {
        // Call the function to add a new row
        addRow();
      });

      // Function to add a new row to the table
      function addRow() {
        // Create a new row
        var newRow = document.createElement("tr");

        // Create cells for the new row
        var cell1 = document.createElement("td");
        var cell2 = document.createElement("td");
        var cell3 = document.createElement("td");
        var cell4 = document.createElement("td");
        var cell5 = document.createElement("td");
        var cell6 = document.createElement("td");
        var cell7 = document.createElement("td");
        var cell8 = document.createElement("td");
        var cell9 = document.createElement("td");
        var cell10 = document.createElement("td"); // New cell for delete button

       // Get the activity array from PHP
        var activityArray = <?php echo json_encode($activityArray); ?>;
        activityArray.unshift("Other");

        // Create the select element
        var activitySelect = document.createElement("select");
        activitySelect.name = "activity[]";
        activitySelect.required = true;

        // Create options based on the activity array
        activityArray.forEach(function(activity) {
          var optionElement = document.createElement("option");
          optionElement.value = activity;
          optionElement.textContent = activity;

          activitySelect.appendChild(optionElement);
        });

        // Create input for Tag Number
        var container = document.createElement('div');
        container.style.width = '150px'; // Adjust the width as needed

        // Create the select element for tag number
        var selectElement = document.createElement('select');
        selectElement.id = 'mySelect';
        selectElement.name = 'tag_no[]';
        selectElement.required = true;

        var select = document.getElementById("poNumber");
        selectedpkg = select.value;

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState === 4 && this.status === 200) {
            var response = JSON.parse(this.responseText);
            for (var i = 0; i < response.length; i++) {
              var option = document.createElement("option");
              option.value = response[i];
              option.text = response[i];
              selectElement.appendChild(option);
            }
          }
        };
        xhttp.open("GET", "tag_map.php?PO_num=" + selectedpkg, true);
        xhttp.send();


        // Append the select element to the container
        container.appendChild(selectElement);


        // Create input for Start Date
        var startDateInput = document.createElement("input");
        startDateInput.type = "date";
        startDateInput.name = "start_date[]";
        startDateInput.required = true;

        // Create input for Final Date
        var endDateInput = document.createElement("input");
        endDateInput.type = "date";
        endDateInput.name = "end_date[]";
        endDateInput.required = true;

        var textarea = document.createElement("textarea");
        textarea.name = "actuals[]";
        textarea.rows = 1;


        // Create input for Actuals Start Date
        var actualsStartDateInput = document.createElement("input");
        actualsStartDateInput.type = "date";
        actualsStartDateInput.name = "actual_start_date[]";
        actualsStartDateInput.required = true;

        // Create input for Actuals End Date
        var actualsEndDateInput = document.createElement("input");
        actualsEndDateInput.type = "date";
        actualsEndDateInput.name = "actual_end_date[]";
        actualsEndDateInput.required = true;

        // Create select for Pay
        var select = document.createElement("select");
        select.name = "pay[]";
        select.required = true;
        var option1 = document.createElement("option");
        option1.value = "payable";
        option1.textContent = "Payable";
        var option2 = document.createElement("option");
        option2.value = "non-payable";
        option2.textContent = "Non-Payable";
        select.appendChild(option1);
        select.appendChild(option2);

        var Remarks = document.createElement("textarea");
        Remarks.name = "indi_Remarks[]";
        Remarks.rows = 1;

        var deleteButton = document.createElement("button");
        deleteButton.type = "button";
        deleteButton.textContent = "-";
        deleteButton.addEventListener("click", function () {
          // Remove the corresponding row when delete button is clicked
          newRow.remove();
        });

        // Append the cells to the new row
        cell1.appendChild(activitySelect);
        cell2.appendChild(container);
        cell3.appendChild(startDateInput);
        cell4.appendChild(endDateInput);
        cell5.appendChild(textarea);
        cell6.appendChild(actualsStartDateInput);
        cell7.appendChild(actualsEndDateInput);
        cell8.appendChild(select);
        cell9.appendChild(Remarks);
        cell10.appendChild(deleteButton);

        // Append the new row to the table body
        newRow.appendChild(cell1);
        newRow.appendChild(cell2);
        newRow.appendChild(cell3);
        newRow.appendChild(cell4);
        newRow.appendChild(cell5);
        newRow.appendChild(cell6);
        newRow.appendChild(cell7);
        newRow.appendChild(cell8);
        newRow.appendChild(cell9);
        newRow.appendChild(cell10);

        // Append the new row to the table body
        tableBody.appendChild(newRow);

          // Event listener for activitySelect
          activitySelect.addEventListener("change", function () {
          var selectedActivity = activitySelect.value;
          var selectedVId =  <?php echo $visitId; ?>;

          // Make an AJAX request to fetch the data from the server

          console.log(selectedActivity);
          console.log(selectedVId);
          var xhr = new XMLHttpRequest();
          xhr.open("GET", "update_act.php?activity=" + selectedActivity + "&v_id=" + selectedVId, true);
          xhr.onreadystatechange = function () {
          if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            console.log(xhr.responseText); // Log the response received from the server
            try {
              var response = JSON.parse(xhr.responseText);
              var tagNumber = response.tagNumber;
              var startDate = response.startDate;
              var endDate = response.endDate;
              var selectedActivityIndex = response.selectedActivityIndex; // Add this line


              // Set the values for the corresponding elements
              selectElement.value = tagNumber;
              startDateInput.value = startDate;
              endDateInput.value = endDate;
            } catch (error) {
              console.error("Error parsing JSON:", error);
            }
          }
        };
          xhr.send();
        });
            }
    </script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.btn-expand-collapse').click(function(e) {
        e.preventDefault();
        $('.navbar-primary').toggleClass('collapsed');
        $('.main-content').toggleClass('collapsed');
      });
    });
  </script>
</body>
</html>
