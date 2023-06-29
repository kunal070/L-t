<?php
    session_start();
    require_once('../process/dbh.php'); // Assuming the database connection is established in dbh.php
    $id = $_SESSION["User_ID"];
    $role = $_SESSION["role"]; // Replace this with the actual role of the user
    $Email=$_GET['Email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <style>
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
    .po-input {
  border: 1px solid black;
  padding: 10px;
  font-size: 16px;
  color: #333;
  background-color: #f5f5f5;
  /* Add any other desired styles for the input elements */
}

#existingAccess td,
#newAccess td {
  border: 1px solid black;
  padding: 10px;
}

.access-button {
  background-color: #337ab7;
  color: #fff;
  border: none;
  padding: 5px 10px;
  font-size: 14px;
  cursor: pointer;
  /* Add any other desired styles for the button elements */
}

.access-button:hover {
  background-color: #23527c;
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
        <a href="Approval_view.php">
          <div class="navbar-logo">
            <img src="../process/images/view_details.jpeg" alt="Logo" width="30" height="30">
          </div>
          <span class="nav-label">View Details</span>
        </a>
      </li>
      <li>
        <a href="user_reports.php" >
          <div class="navbar-logo">
            <img src="../process/images/report.png" alt="Logo" width="30" height="30">
          </div>
          <span class="nav-label">Reports</span>
        </a>
      </li>
      <?php
          if ($role == "Admin") {
              echo '<li>
                  <a href="admin.php"  class="homered">
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
          <?php

                $query = "SELECT Name, Role FROM login WHERE email  ='$Email';";
                $result = mysqli_query($conn, $query);
                echo '<style>
                th {
                    font-size: 18px;
                    font-weight: bold;
                    padding: 90px;
                }
            </style>'; // CSS styling for table and table header cells
            
                while ($row = mysqli_fetch_assoc($result)) {
                    $Name = $row['Name'];
                    $Role = $row['Role'];
                    echo '<table style="margin: 0 auto; text-align: center;">';
                    echo '<tr>';
                    echo '<th><span style="font-size: 21px;">Name :  ' . $Name . '</span></div></th>'; // Increased font size for name
                    echo '<th><span style="font-size: 21px;">Email :  ' . $Email . '</span></div></th>'; // Increased font size for email
                    echo '<th><span style="font-size: 21px;">Role :  ' . $Role . '</span></div></th>'; // Increased font size for role
                    echo '</tr>';
                    echo '</table>';
                }

                $query = "SELECT PO_num FROM confidentiality WHERE email = '$Email';";
                $result1 = mysqli_query($conn, $query);
                
                // Retrieve PO numbers from confidentiality table
                $existingPONumbers = array(); // Array to store existing PO numbers
                while ($row = mysqli_fetch_assoc($result1)) {
                    $poNumbers = json_decode($row['PO_num'], true); // Decode the JSON string into an array
                    $existingPONumbers = array_merge($existingPONumbers, $poNumbers); // Merge existing PO numbers into the array
                }

                echo '<div style="display: flex; justify-content: center;">'; // Container for table                
                $query = "SELECT PO_num FROM purchase_order WHERE PO_num NOT IN ('" . implode("','", $existingPONumbers) . "');";
                $result = mysqli_query($conn, $query);
                
                echo '<div style="margin-right: 80px;">'; // Container for the first table
                echo "<div style='text-align: center; font-weight: bold;'>List of PO</div>";
                echo '<table id="newAccess" style="border-collapse: collapse; border: 1px solid black;">';
                echo '<tr>';
                echo '<th style="border: 1px solid black; padding: 10px;"><span style="font-size: 18px;">PO Numbers</span></th>'; // Column header for PO numbers
                echo '<th style="border: 1px solid black; padding: 10px;"><span style="font-size: 18px;">Add</span></th>'; // Column header for actions
                echo '</tr>';
                
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td style="border: 1px solid black; padding: 10px;"><input type="text" value="' . $row['PO_num'] . '" disabled></td>';
                    echo '<td style="border: 1px solid black; padding: 10px;"><button onclick="moveToExistingAccess(this)" data-po="' . $row['PO_num'] . '">+</button></td>';
                    echo '</tr>';
                }
                
                echo '</table>';
                echo '</div>'; // End of container for the second table
                
                
                echo '<div style="margin-right: 20px;">'; // Container for the first table
                echo "<div style='text-align: center; font-weight: bold;'>Existing Access</div>";
                echo '<table id="existingAccess" style="border-collapse: collapse; border: 1px solid black;">';
                echo '<tr>';
                echo '<th style="border: 1px solid black; padding: 10px;"><span style="font-size: 18px;">PO Numbers</span></th>'; // Column header for PO numbers
                echo '<th style="border: 1px solid black; padding: 10px;"><span style="font-size: 18px;">Delete</span></th>'; // Column header for actions
                echo '</tr>';
                
                foreach ($existingPONumbers as $index => $poNumber) {
                    echo '<tr id="row_existing_' . $index . '">';
                    echo '<td style="border: 1px solid black; padding: 10px;"><input type="text" name="existingPONumbers[]" value="' . $poNumber . '" disabled></td>';
                    echo '<td style="border: 1px solid black; padding: 10px;"><button onclick="moveToNewAccess(this)">-</button></td>';
                    echo '</tr>';
                }
                
                echo '</table>';
                
                echo '</div>'; // End of container for the first table
                
                echo '</div>'; // End of container for tables
                
                echo '<div style="display: flex; justify-content: center; margin-top: 20px;">'; // Container for the submit button
                echo '<form id="confiForm" action="handle_confi.php" method="POST">'; // Form tag for submitting data
                
                // Add the existingPONumbers values to the form as hidden inputs
                foreach ($existingPONumbers as $index => $poNumber) {
                    echo '<input type="hidden" name="existingPONumbers[]" value="' . $poNumber . '">';
                }

                $email = $Email; // Replace with your actual email value
                echo '<input type="hidden" name="email" value="' . $email . '">'; // Hidden input field for email
                
                echo '</form>';
                echo '</div>'; // End of container for the submit button
                
                echo '<div style="display: flex; justify-content: center; margin-top: 20px;">'; // Container for the submit button
                echo '<button onclick="submitForm()" style="background-color: green; color: white; padding: 10px 20px; border: none; border-radius: 4px; font-size: 16px; cursor: pointer;">Save changes</button>';
                echo '</div>'; // End of container for the submit button
                ?>
                
                <script>
              function submitForm() {
            // Update the form fields with the modified values
            updateFormFields();

            // Submit the form
            document.getElementById('confiForm').submit();
        }


        function updateFormFields() {
    var existingAccessTable = document.getElementById('existingAccess');
    var existingRows = existingAccessTable.getElementsByTagName('tr');

    // Remove the existing hidden input fields
    var existingHiddenInputs = document.querySelectorAll('#confiForm input[name="existingPONumbers[]"]');
    for (var i = 0; i < existingHiddenInputs.length; i++) {
        existingHiddenInputs[i].parentNode.removeChild(existingHiddenInputs[i]);
    }

    // Add the modified values as hidden input fields
    for (var i = 0; i < existingRows.length; i++) {
        var poInput = existingRows[i].querySelector('input[name="existingPONumbers[]"]');
        if (poInput) {
            var poNumber = poInput.value;
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'existingPONumbers[]';
            input.value = poNumber;
            document.getElementById('confiForm').appendChild(input);
        }
    }
}


                
                function moveToNewAccess(button) {
                    var row = button.parentNode.parentNode;
                    if (row) {
                        var poNumber = row.cells[0].getElementsByTagName('input')[0].value;
                        var index = button.getAttribute('data-index');
                
                        // Remove row from Existing Access table
                        row.parentNode.removeChild(row);
                        console.log('Moved from Existing Access to New Access: ' + poNumber);
                
                        // Create a new row in New Access table
                        var newAccessTable = document.getElementById('newAccess');
                        var newRow = newAccessTable.insertRow();
                        newRow.id = 'row_new_' + index;
                
                        var cell1 = newRow.insertCell(0);
                        var input = document.createElement('input');
                        input.type = 'text';
                        input.name = 'poNumbers[]';
                        input.value = poNumber;
                        input.disabled = true;
                        input.className = 'po-input';
                        cell1.appendChild(input);
                
                        var cell2 = newRow.insertCell(1);
                        var addButton = document.createElement('button');
                        addButton.innerText = '+';
                        addButton.onclick = function() {
                            moveToExistingAccess(this);
                        };
                        addButton.className = 'access-button';
                        addButton.setAttribute('data-po', poNumber); // Set the data-po attribute with the value of poNumber
                        cell2.appendChild(addButton);
                
                        // Fix the index attribute of the existing rows in the New Access table
                        fixRowIndexes(newAccessTable, 'row_new_');
                    } else {
                        console.error('Row not found.');
                    }
                }
                
                function moveToExistingAccess(button) {
                    var row = button.parentNode.parentNode;
                    if (row) {
                        var poNumber = button.getAttribute('data-po');
                        console.log('Moved from New Access to Existing Access: ' + poNumber);
                
                        // Remove row from New Access table
                        row.parentNode.removeChild(row);
                
                        // Create a new row in Existing Access table
                        var existingAccessTable = document.getElementById('existingAccess');
                        var newRow = existingAccessTable.insertRow();
                
                        var cell1 = newRow.insertCell(0);
                        var input = document.createElement('input');
                        input.type = 'text';
                        input.name = 'existingPONumbers[]';
                        input.value = poNumber;
                        input.disabled = true;
                        input.className = 'po-input';
                        cell1.appendChild(input);
                
                        var cell2 = newRow.insertCell(1);
                        var deleteButton = document.createElement('button');
                        deleteButton.innerText = '-';
                        deleteButton.onclick = function() {
                            moveToNewAccess(this);
                        };
                        deleteButton.setAttribute('data-index', existingAccessTable.rows.length - 1); // Add the data-index attribute
                        deleteButton.className = 'access-button';
                        cell2.appendChild(deleteButton);
                
                        // Fix the index attribute of the existing rows in the Existing Access table
                        fixRowIndexes(existingAccessTable, 'row_existing_');
                    } else {
                        console.error('Row not found.');
                    }
                }
                
                function fixRowIndexes(table, prefix) {
                    var rows = table.getElementsByTagName('tr');
                    for (var i = 0; i < rows.length; i++) {
                        var row = rows[i];
                        row.id = prefix + i;
                        var button = row.cells[1].getElementsByTagName('button')[0];
                        if (button) {
                            button.setAttribute('data-index', i);
                        }
                    }
                }
                
                        function deletePO(poNumber) {
                            var row = findRowByValue('existingAccess', poNumber);
                            row.parentNode.removeChild(row);
                        }

                        function findRowByValue(tableId, poNumber) {
                            var table = document.getElementById(tableId);
                            var rows = table.getElementsByTagName('tr');
                            for (var i = 0; i < rows.length; i++) {
                                var row = rows[i];
                                var input = row.cells[0].getElementsByTagName('input')[0];
                                if (input && input.value === poNumber) {
                                    return row;
                                }
                            }
                            return null;
                        }
</script>


                
  </div>
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