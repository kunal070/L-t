<?php
session_start();
require_once('../process/dbh.php'); // Assuming the database connection is established in dbh.php
$id = $_SESSION["User_ID"];
$role = $_SESSION["role"]; // Replace this with the actual role of the user
?>
<?php
if (isset($_GET['visit_id'])) {
  $visitId = $_GET['visit_id'];

    if(isset($_SESSION['User_ID']) && isset($_SESSION['role']))
    {
      echo '
      <script>
        window.addEventListener("DOMContentLoaded", function() {
          var visitIdSelect = document.getElementById("v_id_select");
          visitIdSelect.value = "' . $visitId . '";
          loadData("' . $visitId . '");
        });
      </script>
      ';
    }
    else {
      echo '
      window.location.href = "user_reports.php?visit_id=' . $visitId . '";
      <!-- Modal -->
      <div class="modal fade" id="myModal" role="dialog">
         <div class="modal-dialog">
            <!-- Modal content -->
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Modal Header</h4>
               </div>
               <div class="modal-body">
                  <form id="credentials" action="redirect_login.php" method="post">
                     <input type="hidden" name="visit_id" value="' . $visitId . '">
                     <input type="text" placeholder="Insert Email" class="form-control" id="user" name="unames">
                     <input type="text" placeholder="Insert Password" class="form-control" id="pass" name="passwords">
                     <button type="submit" class="btn btn-success">Login</button>
                  </form>
               </div>
            </div>
         </div>
      </div>
  
      <script>
         window.addEventListener("DOMContentLoaded", function() {
            var modal = document.getElementById("myModal");
            $(modal).modal("show");
         });
      </script>
      ';
    } 
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>


<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Include Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Your remaining HTML and JavaScript code -->


  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="update_actuals.css">
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
   
    .but button {
    display: block;
    border: none;
    padding: 10px;
    margin: 0 5px;
  }

  .cancel-button {
    background-color: red;
    color: white;
    /* Add other styles as needed */
  }
  .approve-button{
    background-color: green;
    color: white;
    /* Add other styles as needed */
  }

  .middle-right {
            top: 50%;
            right: 300px;
            transform: translateY(-50%);
            font-weight: bold;
            color: black;
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
        <a href="update_actuals.php"  class="homered">
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
        <a href="user_reports.php">
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
  <div class="container">
    <br>
    <form method="POST" action="store_approve.php" id="myForm" onsubmit="submitForm(event)">
        <table>
        <tr>
                <th> 
                <?php
                require_once('../process/dbh.php');

                $query = "SELECT PO_num FROM confidentiality WHERE email = '$id'";
                $result = mysqli_query($conn, $query);
                
                $options = '';
                $retrievedValues = array(); // Array to store the retrieved values
                $uniqueValues = array(); // Array to store unique values
                
                while ($row = mysqli_fetch_assoc($result)) {
                    $jsonString = $row['PO_num'];
                    $arrayData = json_decode($jsonString, true);
                
                    if ($arrayData) {
                        foreach ($arrayData as $value) {
                            $retrievedValues[] = $value; // Store the retrieved value in the array
                
                            // Retrieve the other value from another table
                            $query = "SELECT v_id FROM temp1 WHERE Purc_num = '$value'";
                            $otherResult = mysqli_query($conn, $query);
                
                            if ($otherResult && mysqli_num_rows($otherResult) > 0) {
                                $otherValue = mysqli_fetch_assoc($otherResult)['v_id'];
                
                                if (!in_array($otherValue, $uniqueValues)) {
                                    $uniqueValues[] = $otherValue;
                                    $options .= '<option value="' . $otherValue . '">' . $otherValue . '</option>';
                                }
                            }
                        }
                    }
                }
                
                  ?>

                  <label for="lang">Visit ID</label>
                  <select name="v_id_select" id="v_id_select" onchange="loadData(this.value)" >
                  <option value="" selected disabled>Select a Visit Id</option>

                  <?php echo $options; ?>
                </select>
                </th>
                <th>    
                  <?php
                  require_once ('../process/dbh.php');
                  $id = $_SESSION["User_ID"];


                  $query = "SELECT DISTINCT CAST(t.Purc_num AS UNSIGNED) AS Purc_num "
                  . "FROM confidentiality AS c "
                  . "INNER JOIN temp1 AS t ON JSON_CONTAINS(c.PO_num, CAST(t.Purc_num AS CHAR), '$') "
                  . "WHERE c.email = '" . $id . "'";
          
                  $result = mysqli_query($conn, $query);
                  $options = '';
                  
                  while ($row = mysqli_fetch_assoc($result)) {
                      $value = $row['Purc_num'];
                      $options .= '<option value="' . $value . '">' . $value . '</option>';
                  }
                  
                  ?>
                  
                  <label for="lang">PO Number</label>
                  <select name="po_number" id="PO_Number" onchange="loadData1(this.value)">
                  <option value="" selected disabled>Select a PO Number</option>
                      <?php echo $options; ?>
                  </select>
                </th>
                <th>
                <?php
                $id = $_SESSION["User_ID"];
                $query = "SELECT PO_num FROM confidentiality WHERE email='$id' ";
                $result = mysqli_query($conn, $query);
                $options = '';
                $retrievedValues = array(); // Array to store the retrieved values
                $uniqueValues = array(); // Array to store unique values

                while ($row = mysqli_fetch_assoc($result)) {
                    $jsonString = $row['PO_num'];
                    $arrayData = json_decode($jsonString, true);

                    if ($arrayData) {
                        foreach ($arrayData as $value) {
                            $retrievedValues[] = $value; // Store the retrieved value in the array

                            // Retrieve the other value from another table
                            $query = "SELECT Package FROM temp1 WHERE Purc_num = '$value'";
                            $otherResult = mysqli_query($conn, $query);

                            if ($otherResult && mysqli_num_rows($otherResult) > 0) {
                                $otherValue = mysqli_fetch_assoc($otherResult)['Package'];

                                if (!in_array($otherValue, $uniqueValues)) {
                                    $uniqueValues[] = $otherValue;
                                    $options .= '<option value="' . $otherValue . '">' . $otherValue . '</option>';
                                }
                            }
                        }
                    }
                }
                ?>

                <label for="lang">Package</label>
                <select name="package" disabled>
                <option value="" selected disabled>Select a PO Number/Visit id</option>
                  <?php echo $options; ?>
                </select>
            </th>

            <th>
                <?php
                $id = $_SESSION["User_ID"];
                $query = "SELECT PO_num FROM confidentiality WHERE email='$id' ";
                $result = mysqli_query($conn, $query);
                $options = '';
                $retrievedValues = array(); // Array to store the retrieved values
                $uniqueValues = array(); // Array to store unique values

                while ($row = mysqli_fetch_assoc($result)) {
                    $jsonString = $row['PO_num'];
                    $arrayData = json_decode($jsonString, true);

                    if ($arrayData) {
                        foreach ($arrayData as $value) {
                            $retrievedValues[] = $value; // Store the retrieved value in the array

                            // Retrieve the other value from another table
                            $query = "SELECT loaction FROM temp1 WHERE Purc_num = '$value'";
                            $otherResult = mysqli_query($conn, $query);

                            if ($otherResult && mysqli_num_rows($otherResult) > 0) {
                                $otherValue = mysqli_fetch_assoc($otherResult)['loaction'];

                                if (!in_array($otherValue, $uniqueValues)) {
                                    $uniqueValues[] = $otherValue;
                                    $options .= '<option value="' . $otherValue . '">' . $otherValue . '</option>';
                                }
                            }
                        }
                    }
                }
                ?>

                <label for="lang">Location</label>
                <select name="location" disabled>
                <option value="" selected disabled>Select a PO Number/Visit id</option>
                  <?php echo $options; ?>
                </select>
            </th>

            </tr>
        </table>
    </div>
   <br>
   <br>
   <br>

    <div class="center">
      <p><strong> Status:  </strong>
      </p>

      <p class="hi"> </p>
    </div>

  
    <h3 style="text-align:center; color:blue;" > Activity Planning </h3> 
    <br> 
    <br> 
    <div class="conatiner">
    <table id="activity-table">
  <thead>
      <tr>
        <th>Activity</th>
        <th>Tag</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Actuals</th>
        <th>Actual Start Date</th>
        <th>Actual End Date</th>
        <th>Pay</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>

  </div>
 
  <button id="addRowButton" type="button">+</button>
  <br>
  <br>
  <br>
  <div class="but" style="display: flex; justify-content: center;">

  <!-- for approve  -->
  <?php
   if ($role === "Approver") {
    echo ' <button id="approveButton" name="submit2" class="approve-button" type="submit" value="Approve" style="margin: 0 5px;">Approve</button>';
}
  if ($role === "User") {
      echo '<button id="forApprovalButton"class="approve-button" name="submit2" type="submit" value="For Approval" style="margin: 0 5px;">For Approval</button>';
  }
  ?>
  
  <!-- for save as draft  -->
  <button id="saveDraftButton" name="submit2" class="approve-button" type="submit" value="Save as Draft" style="margin: 0 5px;">Save as Draft</button>
  <!-- for cancel/ -->
  <button id="cancel" name="cancel" type="button" class="cancel-button" value="Submit" style="margin: 0 5px;" onclick="deleteTableRows()">cancel</button>
  </div>
</div>

<script>
  function deleteTableRows() {
    // Ask for confirmation
    var confirmDelete = confirm("Are you sure you want to delete all rows your fill data will be lost?");

    if (confirmDelete) {
      var table = document.getElementById("activity-table");
      var rowCount = table.rows.length;
                    
      // Remove rows starting from the last row
       for (var i = rowCount - 1; i > 0; i--) {
          table.deleteRow(i);
       }

      // Display an alert to the user
    }
    alert("All rows deleted.");
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
    </form>

    <script>
      function submitForm(event) {

        event.preventDefault(); // Prevent the default form submission

        
        // Get the form data
        var form = document.getElementById("myForm");
        var formData = new FormData(form);

        var submitButtonValue = event.submitter.value;
        formData.append("submitButton", submitButtonValue);
        console.log('submitButton :',submitButtonValue); // Log the tag number value


        
        var vIdInput = document.getElementById("v_id_select");
        var vIdValue = vIdInput.value;
        formData.append("v_id", vIdValue);

        var activityValues = document.querySelectorAll('select[name="activity[]"] option:checked');
        activityValues.forEach(function (option) {
          console.log('activity Values:', option.value); // Log the tag number value
          formData.append('activity[]', option.value);
        });


        var tagNumberValues = document.querySelectorAll('select[name="Tag_num[]"] option:checked');
        tagNumberValues.forEach(function (option) {
          console.log('Tag Number Value:', option.value); // Log the tag number value
          formData.append('Tag_num[]', option.value);
        });

        var startDateValues = document.querySelectorAll('input[name="Start_date[]"]');
        startDateValues.forEach(function (input) {
          console.log('Start Date Value:', input.value); // Log the start date value
          formData.append('Start_date[]', input.value);
        });

        var endDateValues = document.querySelectorAll('input[name="End_date[]"]');
        endDateValues.forEach(function (input) {
          console.log('End Date Value:', input.value); // Log the end date value
          formData.append('End_date[]', input.value);
        });


        var textareaValues = document.querySelectorAll('textarea[name="actuals[]"]');
        textareaValues.forEach(function (textarea) {
          console.log('Textarea Value:', textarea.value); // Log the textarea value
          formData.append('actuals[]', textarea.value);
        });

        var startDateInputValues = document.querySelectorAll('input[name="actualsStart_date[]"]');
        startDateInputValues.forEach(function (startDateInput) {
          console.log('Start Date:', startDateInput.value); // Log the start date value
          formData.append('actualsStart_date[]', startDateInput.value);
        });

        var endDateInputValues = document.querySelectorAll('input[name="actualsEnd_date[]"]');
        endDateInputValues.forEach(function (endDateInput) {
          console.log('End Date:', endDateInput.value); // Log the end date value
          formData.append('actualsEnd_date[]', endDateInput.value);
        });

        var selectValues = document.querySelectorAll('select[name="pay[]"]');
        selectValues.forEach(function (select) {
          console.log('Select Value:', select.value); // Log the select value
          formData.append('pay[]', select.value);
        });



        console.log('FormData:', formData); // Log the FormData object

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'store_approve.php', true);
        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4) {
            if (xhr.status === 200) {
              // Request successful
              console.log('Request successful');
              var response = xhr.responseText;
              // Process the response as needed
              console.log(response); // Log the response from store_approve.php
              if (response === "sentsend") {
                // Display success message to the user
                alert("Sended To Approver");
                  window.location.href = "update_actuals.php";

              }
              
              else if(response === "Approved") {
                // Display error message to the user
                alert("Your Data is Approved ");
                window.location.href = "update_actuals.php";

              }

              else if(response === "saved") {
                // Display error message to the user
                alert("Your Data is Saved");
                window.location.href = "update_actuals.php";

              }
            } else {
              // Request failed
              console.log('Request failed');
            }
          }
        };

        xhr.onerror = function () {
          console.log('Request error');
        };

        // Send FormData as the request body
        xhr.send(formData);
      }
   </script>
                  <select id="activity" style="display: none;"></select>
                  <script>
                  function loadData1(selectedpkg) {
                    var table = document.getElementById("activity-table");
                    var rowCount = table.rows.length;
                    
                    // Remove rows starting from the last row
                    for (var i = rowCount - 1; i > 0; i--) {
                      table.deleteRow(i);
                    }

                    var hiElement = document.querySelector(".hi");
                          hiElement.textContent = "";

                    console.log("Selected po_num:", selectedpkg);
                    var xhttp = new XMLHttpRequest();
                    var response; // Declare the response variable

                    xhttp.onreadystatechange = function() {
                      if (this.readyState === 4 && this.status === 200) {
                        response = JSON.parse(this.responseText); // Assign value to the response variable

                        // Update the form fields with the retrieved data
                        var vidSelect = document.querySelector("select[name='v_id_select']");
                        var packageSelect = document.querySelector("select[name='package']");
                        var locationSelect = document.querySelector("select[name='location']");
                        var activityField = document.getElementById("activity-field"); // Assuming there is an element with id "activity-field"


                        // Reset the selected options
                        vidSelect.selectedIndex = -1;
                        packageSelect.selectedIndex = -1;
                        locationSelect.selectedIndex = -1;

                        // Set the selected options
                        var vidOptions = vidSelect.options;
                        var packageOptions = packageSelect.options;
                        var locationOptions = locationSelect.options;

                        for (var i = 0; i < vidOptions.length; i++) {
                            if (vidOptions[i].value === response.v_id) {
                              vidOptions[i].selected = true;
                              break;
                            }
                          }

                        for (var j = 0; j < packageOptions.length; j++) {
                          if (packageOptions[j].value === response.package) {
                            packageOptions[j].selected = true;
                            break;
                          }
                        }

                        for (var k = 0; k < locationOptions.length; k++) {
                          if (locationOptions[k].value === response.location) {
                            locationOptions[k].selected = true;
                            break;
                          }
                        }

                        if((response.Draft) === 0){
                          activityArray = JSON.parse(response.activity);
                          activityArray.unshift("Other"); // Add "Other" as the first element
                          }

                          // save draft wala
                          if((response.Draft) === 1){

                          activityArray = JSON.parse(response.asli_activities);
                          activityArray.unshift("Other");
                          var c = activityArray.length;
                          var activity=JSON.parse(response.activity);
                          var TagArray = JSON.parse(response.tag);
                          var S_dateArray = JSON.parse(response.s_date);
                          var E_dateArray = JSON.parse(response.e_date);
                          var Actuals = JSON.parse(response.Actuals);
                          var A_Sdate = JSON.parse(response.A_Sdate);
                          var A_Edate = JSON.parse(response.A_Edate);
                          var Pay = JSON.parse(response.Pay);
                          var Status = JSON.parse(response.Status);
                        var Rejected_date = JSON.parse(response.Rejected_date);
                        var lastElement = null;
                        if (Rejected_date && Rejected_date.length > 0) {
                          lastElement = Rejected_date[Rejected_date.length - 1];
                        }


                        if (Status == 3) {
                          var hiElement = document.querySelector(".hi");
                          hiElement.textContent = "  Rejected on  " + lastElement;
                        }

                        if (Status == 2) {
                          var hiElement = document.querySelector(".hi");
                          hiElement.textContent = "Save as Draft";
                        }

                          // Populate the table with the array data
                          var dataTable = document.getElementById("activity-table");
                          var tbody = dataTable.querySelector("tbody");

                          // Clear existing table rows
                          tbody.innerHTML = "";

                          // Iterate over the arrays and create table rows
                          for (var i = 0; i < activity.length; i++) {
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
                          var cell9 = document.createElement("td"); // New cell for delete button

                          // Create select for activity
                            var activitySelect = document.createElement("select");
                            activitySelect.name = "activity[]";
                            activitySelect.required = true;
                            activity.forEach(function(activity) {
                            var optionElement = document.createElement("option");
                            optionElement.value = activity;
                            optionElement.textContent = activity;
                            activitySelect.appendChild(optionElement);
                          });
                          activitySelect.value= activity[i];
                          
                            

                          // Create input for Tag Number
                          var container = document.createElement('div');
                          container.style.width = '150px'; // Adjust the width as needed

                          // Create the select element for tag number
                          var selectElement = document.createElement('select');
                          selectElement.id = 'mySelect';
                          selectElement.name = 'Tag_num[]';
                          selectElement.required = true;


                          // Retrieve options from the database and append them to the select element
                          <?php
                          $query = "SELECT tag_num FROM tag_no";
                          $result = mysqli_query($conn, $query);

                          while ($row = mysqli_fetch_assoc($result)) {
                            $tagNum = $row['tag_num'];
                            echo 'var optionElement = new Option("' . $tagNum . '", "' . $tagNum . '");';
                            echo 'selectElement.appendChild(optionElement);';
                          }
                          ?>
                          selectElement.value = TagArray[i];

                          // Append the select element to the container
                          container.appendChild(selectElement);


                          // Create input for Start Date
                          var startDateInput = document.createElement("input");
                          startDateInput.type = "date";
                          startDateInput.name = "Start_date[]";
                          startDateInput.required = true;
                          startDateInput.value = S_dateArray[i];


                          // Create input for Final Date
                          var endDateInput = document.createElement("input");
                          endDateInput.type = "date";
                          endDateInput.name = "End_date[]";
                          endDateInput.required = true;
                          endDateInput.value = E_dateArray[i];


                          // Create textarea for Actuals
                          var actualsTextarea = document.createElement("textarea");
                          actualsTextarea.value = Actuals[i];
                          actualsTextarea.name = "actuals[]";
                          actualsTextarea.rows = 1;

                          // Create input for Actuals Start Date
                          var actualsStartDateInput = document.createElement("input");
                          actualsStartDateInput.type = "date";
                          actualsStartDateInput.name = "actualsStart_date[]";
                          actualsStartDateInput.value = A_Sdate[i];
                          actualsStartDateInput.required = true;

                          // Create input for Actuals End Date
                          var actualsEndDateInput = document.createElement("input");
                          actualsEndDateInput.type = "date";
                          actualsEndDateInput.name = "actualsEnd_date[]";
                          actualsEndDateInput.value = A_Edate[i];
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
                          select.value = Pay[i];


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
                          cell5.appendChild(actualsTextarea);
                          cell6.appendChild(actualsStartDateInput);
                          cell7.appendChild(actualsEndDateInput);
                          cell8.appendChild(select);
                          cell9.appendChild(deleteButton);

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

                          // Append the new row to the table body
                          tableBody.appendChild(newRow);
                          }

                          }
                      }
                    };
                    xhttp.open("GET", "retrieve_data1.php?PO_num=" + selectedpkg, true);
                    xhttp.send();
                  }
                </script>


                <select id="activity" style="display: none;"></select>
                <script>
                  var activityArray = []; // Empty array to store the activity options

                  function loadData(selectedVId) {
                    var table = document.getElementById("activity-table");
                    var rowCount = table.rows.length;

                    // Remove rows starting from the last row
                    for (var i = rowCount - 1; i > 0; i--) {
                      table.deleteRow(i);
                    }

                    var hiElement = document.querySelector(".hi");
                          hiElement.textContent = "";

                    console.log("Selected v_id:", selectedVId);
                    var xhttp = new XMLHttpRequest();
                    var response; // Declare the response variable

                    xhttp.onreadystatechange = function() {
                      if (this.readyState === 4 && this.status === 200) {
                        try {
                        response = JSON.parse(this.responseText); // Assign value to the response variable

                        // Update the form fields with the retrieved data
                        var poNumberSelect = document.querySelector("select[name='po_number']");
                        var packageSelect = document.querySelector("select[name='package']");
                        var locationSelect = document.querySelector("select[name='location']");

                        // Reset the selected options
                        poNumberSelect.selectedIndex = -1;
                        packageSelect.selectedIndex = -1;
                        locationSelect.selectedIndex = -1;

                        // Set the selected options
                        var poNumberOptions = poNumberSelect.options;
                        var packageOptions = packageSelect.options;
                        var locationOptions = locationSelect.options;

                        for (var i = 0; i < poNumberOptions.length; i++) {
                          if (poNumberOptions[i].value === response.po_number) {
                            poNumberOptions[i].selected = true;
                            break;
                          }
                        }

                        for (var j = 0; j < packageOptions.length; j++) {
                          if (packageOptions[j].value === response.package) {
                            packageOptions[j].selected = true;
                            break;
                          }
                        }

                        for (var k = 0; k < locationOptions.length; k++) {
                          if (locationOptions[k].value === response.location) {
                            locationOptions[k].selected = true;
                            break;
                          }
                        }


                        if((response.Draft) === 0){

                          activityArray = JSON.parse(response.activity);
                          activityArray.unshift("Other"); // Add "Other" as the first element
                        }

                        // save draft wala
                        if((response.Draft) === 1){

                        activityArray = JSON.parse(response.asli_activities);
                        activityArray.unshift("Other");
                        var c = activityArray.length;
                        var activity=JSON.parse(response.activity);
                        var TagArray = JSON.parse(response.tag);
                        var S_dateArray = JSON.parse(response.s_date);
                        var E_dateArray = JSON.parse(response.e_date);
                        var Actuals = JSON.parse(response.Actuals);
                        var A_Sdate = JSON.parse(response.A_Sdate);
                        var A_Edate = JSON.parse(response.A_Edate);
                        var Pay = JSON.parse(response.Pay);
                        var Status = JSON.parse(response.Status);
                        var Rejected_date = JSON.parse(response.Rejected_date);
                        var lastElement = null;
                        if (Rejected_date && Rejected_date.length > 0) {
                          lastElement = Rejected_date[Rejected_date.length - 1];
                        }


                        if (Status == 3) {
                          var hiElement = document.querySelector(".hi");
                          hiElement.textContent = "  Rejected on  " + lastElement;
                        }

                        if (Status == 2) {
                          var hiElement = document.querySelector(".hi");
                          hiElement.textContent = "Save as Draft";
                        }

                        // Populate the table with the array data
                        var dataTable = document.getElementById("activity-table");
                        var tbody = dataTable.querySelector("tbody");

                        // Clear existing table rows
                        tbody.innerHTML = "";

                        // Iterate over the arrays and create table rows
                        for (var i = 0; i < activity.length; i++) {
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
                          var cell9 = document.createElement("td"); // New cell for delete button

                          // Create select for activity
                            var activitySelect = document.createElement("select");
                            activitySelect.name = "activity[]";
                            activitySelect.required = true;
                            activity.forEach(function(activity) {
                            var optionElement = document.createElement("option");
                            optionElement.value = activity;
                            optionElement.textContent = activity;
                            activitySelect.appendChild(optionElement);
                          });
                          activitySelect.value= activity[i];
                           
                            

                          // Create input for Tag Number
                          var container = document.createElement('div');
                          container.style.width = '150px'; // Adjust the width as needed

                          // Create the select element for tag number
                          var selectElement = document.createElement('select');
                          selectElement.id = 'mySelect';
                          selectElement.name = 'Tag_num[]';
                          selectElement.required = true;


                          // Retrieve options from the database and append them to the select element
                          <?php
                          $query = "SELECT tag_num FROM tag_no";
                          $result = mysqli_query($conn, $query);

                          while ($row = mysqli_fetch_assoc($result)) {
                            $tagNum = $row['tag_num'];
                            echo 'var optionElement = new Option("' . $tagNum . '", "' . $tagNum . '");';
                            echo 'selectElement.appendChild(optionElement);';
                          }
                          ?>
                          selectElement.value = TagArray[i];

                          // Append the select element to the container
                          container.appendChild(selectElement);


                          // Create input for Start Date
                          var startDateInput = document.createElement("input");
                          startDateInput.type = "date";
                          startDateInput.name = "Start_date[]";
                          startDateInput.required = true;
                          startDateInput.value = S_dateArray[i];


                          // Create input for Final Date
                          var endDateInput = document.createElement("input");
                          endDateInput.type = "date";
                          endDateInput.name = "End_date[]";
                          endDateInput.required = true;
                          endDateInput.value = E_dateArray[i];


                          // Create textarea for Actuals
                          var actualsTextarea = document.createElement("textarea");
                          actualsTextarea.value = Actuals[i];
                          actualsTextarea.name = "actuals[]";
                          actualsTextarea.rows = 1;
                       

                          // Create input for Actuals Start Date
                          var actualsStartDateInput = document.createElement("input");
                          actualsStartDateInput.type = "date";
                          actualsStartDateInput.name = "actualsStart_date[]";
                          actualsStartDateInput.value = A_Sdate[i];
                          actualsStartDateInput.required = true;

                          // Create input for Actuals End Date
                          var actualsEndDateInput = document.createElement("input");
                          actualsEndDateInput.type = "date";
                          actualsEndDateInput.name = "actualsEnd_date[]";
                          actualsEndDateInput.value = A_Edate[i];
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
                          select.value = Pay[i];


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
                          cell5.appendChild(actualsTextarea);
                          cell6.appendChild(actualsStartDateInput);
                          cell7.appendChild(actualsEndDateInput);
                          cell8.appendChild(select);
                          cell9.appendChild(deleteButton);

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

                          // Append the new row to the table body
                          tableBody.appendChild(newRow);
                        }
                       
                      }

                    }catch (error) {
                    console.error("Error parsing JSON response:", error);
                    // Handle the error scenario appropriately
                  }
                  } 
                  };

                    xhttp.open("GET", "retrieve_data.php?v_id=" + selectedVId, true);
                    xhttp.send();
                  }
                </script>

    
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
        var cell9 = document.createElement("td"); // New cell for delete button

        // Create select for activity
        var activitySelect = document.createElement("select");
        activitySelect.name = "activity[]";
        activitySelect.required = true;
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
        selectElement.name = 'Tag_num[]';
        selectElement.required = true;

        // Retrieve options from the database and append them to the select element
        var select = document.getElementById("PO_Number");
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
        startDateInput.name = "Start_date[]";
        startDateInput.required = true;

        // Create input for Final Date
        var endDateInput = document.createElement("input");
        endDateInput.type = "date";
        endDateInput.name = "End_date[]";
        endDateInput.required = true;

        // Create textarea for Actuals
        var actualsTextarea = document.createElement("textarea");
        actualsTextarea.name = "actuals[]";
        actualsTextarea.rows = 1;

        // Create input for Actuals Start Date
        var actualsStartDateInput = document.createElement("input");
        actualsStartDateInput.type = "date";
        actualsStartDateInput.name = "actualsStart_date[]";
        actualsStartDateInput.required = true;

        // Create input for Actuals End Date
        var actualsEndDateInput = document.createElement("input");
        actualsEndDateInput.type = "date";
        actualsEndDateInput.name = "actualsEnd_date[]";
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
        cell5.appendChild(actualsTextarea);
        cell6.appendChild(actualsStartDateInput);
        cell7.appendChild(actualsEndDateInput);
        cell8.appendChild(select);
        cell9.appendChild(deleteButton);

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

        // Append the new row to the table body
        tableBody.appendChild(newRow);

          // Event listener for activitySelect
          activitySelect.addEventListener("change", function () {
          var selectedActivity = activitySelect.value;
          var selectedVId = document.getElementById("v_id_select").value; // Get the selected value of the "v_id_select" select element

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

</body>
</html>