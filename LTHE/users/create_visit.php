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

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<!-- Title Page-->
<title>Add Activity | User Panel</title>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="create_visit.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.default.min.css">




    <style>
        .custom-option {
        color: blue;
        }

        .container table {
            border-collapse: collapse;
            width: 100%;
            border-top: none;
        }

        .container th, .container td {
            padding: 8px;
            border: 1px solid #fff;
            border-top : none;
        }

        
        .container table th:first-child,
        .container table td:first-child {
            border-top: none;
        }

        
        .container table td:not(:first-child),
        .container table th:not(:first-child) {
            border-left: none;
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

        .temp {
            display: flex;
            justify-content: center;
            align-items: center;
        }
  
        .temp button {
            margin: 0 10px; /* Adjust the margin as needed */
        }
          
        .hello table {
            border-collapse: collapse;
            width: 100%;
        }

        .hello th, td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .hello tr:not(:last-child) {
            border-bottom: 1px solid #ddd;
        }

        .hello tr:first-child {
            border-top: 1px solid #ddd;
        }

        .hello tr:first-child th {
            border-top: none;
        }

        .hello tr:last-child {
            border-bottom: none;
        }

        .hello tr td:first-child {
            border-left: none;
        }

        .hello tr td:last-child {
            border-right: none;
        }

        .hey th, .hey td {
            padding: 8px;
            border: 1px solid #ddd;
            width: 100%;
            table-layout: fixed;
        }

        .reset-button {
            background-color: #ff0000;
            color: #fff;
            border: none;
            padding: 6px 10px;
            cursor: pointer;
        }

        .submit-button {
            background-color: #ff0000;
            color: #fff;
            border: none;
            padding: 6px 10px;
            cursor: pointer;
        }

        .delete-button {
            background-color: #ff0000;
            color: #fff;
            border: none;
            padding: 6px 10px;
            cursor: pointer;
        }

        select {
            width: 100%;
            padding: 7px;
            border-radius: 3px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            margin-top: 5px;
            margin-bottom: 5px;
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

    .navbar-primary-menu li a {
      text-decoration: none;
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



    .search-container {
      width: 280px;
    }
    </style>
    <script>

        function validateForm() {
            var activities = document.getElementsByName("Activity[]");
            var tags = document.getElementsByName("Tag_num[]");
            var startDates = document.getElementsByName("Start_date[]");
            var endDates = document.getElementsByName("End_date[]");

            for (var i = 0; i < activities.length; i++) {
                var activity = activities[i].value;
                var tag = tags[i].value;
                var startDate = startDates[i].value;
                var endDate = endDates[i].value;

                if (activity === "" || tag === "" || startDate === "" || endDate === "") {
                alert("Please fill in all fields");
                return false;
                }
            }
            return true;
        }
    </script>
    
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

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
        <a href="create_visit.php"  class="homered">
          <div class="navbar-logo" >
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
    <br>
    <br>  
    <div class="container">
    <br>
    <form action="visit_insert.php" method="POST" id="myForm" onsubmit="submitForm(event)">

        <table>
        <tr>
        <th>
        <?php
        $query = "SELECT PO_num FROM confidentiality WHERE email = '$id'";
        $result = mysqli_query($conn, $query);
        $options = ['Select a PO Number']; // Add the default option here
        while ($row = mysqli_fetch_assoc($result)) {
          $poNumbers = json_decode($row['PO_num']); // Decode the JSON array

          // Loop through the numbers and add them to the options array
          foreach ($poNumbers as $number) {
            $options[] = $number;
          }
        }
      ?>

<div class="search-container">
  <label for="PO_Number">PO Number</label>
  <select id="PO_Number" name="PO_Number" class="selectized" onchange="loadData(this.value)" required>
    <?php foreach ($options as $index => $option) { ?>
      <option value="<?php echo $option; ?>" <?php if ($index === 0) echo "disabled selected"; ?>><?php echo $option; ?></option>
    <?php } ?>
  </select>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js"></script>
<script>
  $(document).ready(function() {
    $('.selectized').selectize();
  });
</script>

          </th>
          <th>
          <?php
          $query = "SELECT Package FROM configuration WHERE JSON_UNQUOTE(JSON_SEARCH((SELECT PO_num FROM confidentiality WHERE email = '$id'), 'one', PO_Number)) IS NOT NULL";
          $result = mysqli_query($conn, $query);

          $options = '<option value=" "disabled selected>Select a Package</option>'; // Add the default option here
          while ($row = mysqli_fetch_assoc($result)) {
          $options .= '<option value="' . $row['Package'] . '">' . $row['Package'] . '</option>';
        }
        ?>

        <div style="width: 280px;">
          <label for="Package">Package</label>
          <select name="Package" id="Package" onchange="loadData1(this.value)" class="Package">
            <?php echo $options; ?>
          </select>
        </div>

        <script>
          $(document).ready(function() {
          $('#Package').selectize();
        });
        </script>
          </th>
          <th>
            <?php
              $query = "SELECT location FROM location_name";
              $result = mysqli_query($conn, $query);

              $options = '';
              while ($row = mysqli_fetch_assoc($result)) {
                $options .= '<option value="' . $row['location'] . '">' . $row['location'] . '</option>';
              }
            ?>


            <div style="width: 280px;">
            <label for="location">Location</label>
            <select name="location" id="location" disabled>
              <option value="" selected disabled>Select a Package/PO Number</option>
              <?php echo $options; ?>
            </select>
            </div>
          </th>
        </tr>
        </table>
    </div>
    <br>
    <br>
    <br>
    <br> 
    <h3 style="text-align:center; color:blue;" > Activity Planning </h3> 
    <br> 
    <br> 
        <div class="hey">
        <table id="activity-table">
            <tr>
              <th style="width: 25%">Activity Description</th>
              <th style="width: 20%">Tag Number</th>
              <th style="width: 15%">Start Date</th>
              <th style="width: 15%">Final Date</th>
              <th style="width: 10%">Delete</th>  
            </tr>  
        </table>
        </div>
        <button type="button" id="addRowButton">+</button>              
        <br>
        <br>
        <br> 
        <div class="temp">
        <button class="submit-button" id="submitbutton" name="submit2" type="submit" value="Submit">Save</button>
             <br>       
             <br>       
             <br>       
        </div>
    </form>

    <script>
var poNumberRequestCounter = 0;
var packageRequestCounter = 0;
var MAX_REQUESTS = 5;
var poNumberRequest;
var packageRequest;

function loadData(selectedpo) {
  if (poNumberRequestCounter >= MAX_REQUESTS) {
    console.log("Request limit reached. Aborting subsequent requests.");
    return;
  }

  var table = document.getElementById("activity-table");
  var rowCount = table.rows.length;

  // Remove rows starting from the last row
  for (var i = rowCount - 1; i > 0; i--) {
    table.deleteRow(i);
  }

  console.log("Selected po:", selectedpo);
  if (poNumberRequest) {
    poNumberRequest.abort(); // Abort the previous request if it exists
  }

  poNumberRequest = new XMLHttpRequest();

  poNumberRequest.onload = function() {
    if (this.status === 200) {
      try {
        var jsonResponse = JSON.parse(this.responseText); // Parse the JSON response
        var packageSelect = $('#Package')[0].selectize;
        var locationSelect = document.querySelector("select[name='location']");
        locationSelect.selectedIndex = -1;
        var locationOptions = locationSelect.options;
        for (var k = 0; k < locationOptions.length; k++) {
          if (locationOptions[k].value === jsonResponse.Location) {
            locationOptions[k].selected = true;
            break;
          }
        }
        console.log(jsonResponse.Package);
        console.log(jsonResponse.Location);

        // Set the selected option
        packageSelect.setValue(jsonResponse.Package, true);

        // Re-enable the onchange event for packageSelect
        packageSelect.off('change');
        packageSelect.on('change', function() {
          if (packageRequestCounter) {
            packageRequestCounter = 0;
          } else {
            loadData1(this.getValue());
          }
        });

        // Reset the package request counter
        packageRequestCounter = 0;

        // Increment the PO request counter
        poNumberRequestCounter++;
      } catch (error) {
        console.error("Error parsing JSON response:", error);
        // Handle the error scenario appropriately
      }
    }
  };

  poNumberRequest.open("GET", "create_pop.php?po=" + selectedpo, true);
  poNumberRequest.send();
}

function loadData1(selectedpkg) {
  if (packageRequestCounter >= MAX_REQUESTS) {
    console.log("Request limit reached. Aborting subsequent requests.");
    return;
  }

  var table = document.getElementById("activity-table");
  var rowCount = table.rows.length;

  // Remove rows starting from the last row
  for (var i = rowCount - 1; i > 0; i--) {
    table.deleteRow(i);
  }

  console.log("Selected pkg:", selectedpkg);
  if (packageRequest) {
    packageRequest.abort(); // Abort the previous request if it exists
  }
  packageRequest = new XMLHttpRequest();
  var pkg =selectedpkg;
  var encodedPkg = encodeURIComponent(pkg);

  packageRequest.onload = function() {
    if (this.status === 200) {
      try {
        var jsonResponse = JSON.parse(this.responseText); // Parse the JSON response
        var poNumberSelect = $('#PO_Number')[0].selectize;
        var locationSelect = document.querySelector("select[name='location']");
        locationSelect.selectedIndex = -1;
        var locationOptions = locationSelect.options;
        for (var k = 0; k < locationOptions.length; k++) {
          if (locationOptions[k].value === jsonResponse.Location) {
            locationOptions[k].selected = true;
            break;
          }
        }
        console.log(jsonResponse.PO_Number);
        console.log(jsonResponse.Location);

        // Set the selected option
        poNumberSelect.setValue(jsonResponse.PO_Number, true);

        // Re-enable the onchange event for poNumberSelect
        poNumberSelect.off('change');
        poNumberSelect.on('change', function() {
          if (poNumberRequestCounter) {
            poNumberRequestCounter = 0;
          } else {
            loadData(this.getValue());
          }
        });

        // Reset the PO request counter
        poNumberRequestCounter = 0;

        // Increment the package request counter
        packageRequestCounter++;
      } catch (error) {
        console.error("Error parsing JSON response:", error);
        // Handle the error scenario appropriately
      }
    }
  };

  packageRequest.open("GET", "create_pkg.php?pkg=" + encodedPkg, true);
  packageRequest.send();
}


            </script>

    <script >
        var selectedpkg;
          // Get the button and table body references
          var addRowButton = document.getElementById("addRowButton");
          var tableBody = document.getElementById("activity-table");

          addRowButton.addEventListener("click", function() {
            // Call the function to add a new row
            addRow();
          });

          function addRow() {
            var newRow = document.createElement("tr");

            // Create cells for the new row
            var cell1 = document.createElement("td");
            var cell2 = document.createElement("td");
            var cell3 = document.createElement("td");
            var cell4 = document.createElement("td");
            var cell5 = document.createElement("td"); // New cell for delete button

          
            // Create textarea for Activity Description
            var textarea = document.createElement("textarea");
            textarea.name = "Activity[]";
            textarea.rows = 1;


            cell1.appendChild(textarea);

            $(document).ready(function() {
  // Create input for Tag Number
  var container = document.createElement('div');
  container.style.width = '200px'; // Adjust the width as needed

  // Create the select element
  var selectElement = document.createElement('select');
  selectElement.id = 'mySelect';
  selectElement.name = 'Tag_num[]';
  selectElement.className = 'Tag_num';
  selectElement.required = true;

  // Add the 'selectize' class to enable Selectize plugin
  selectElement.classList.add('selectize');

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

      // Initialize Selectize on the select element
      $(selectElement).selectize();

    }
  };
  xhttp.open("GET", "tag_map.php?PO_num=" + selectedpkg, true);
  xhttp.send();

  // Append the container to the cell
  container.appendChild(selectElement);
  cell2.appendChild(container);
});



            // Create input for Start Date
            var startDateInput = document.createElement("input");
            startDateInput.type = "date";
            startDateInput.name = "Start_date[]";
            startDateInput.required = true;
            cell3.appendChild(startDateInput);

            // Create input for Final Date
            var endDateInput = document.createElement("input");
            endDateInput.type = "date";
            endDateInput.name = "End_date[]";
            endDateInput.required = true;
            cell4.appendChild(endDateInput);

            var deleteButton = document.createElement("button");
            deleteButton.type = "button";
            deleteButton.textContent = "-";
            deleteButton.addEventListener("click", function () {
              // Remove the corresponding row when delete button is clicked
              newRow.remove();
            });
            cell5.appendChild(deleteButton);

            // Append the cells to the new row
            newRow.appendChild(cell1);
            newRow.appendChild(cell2);
            newRow.appendChild(cell3);
            newRow.appendChild(cell4);
            newRow.appendChild(cell5); // Append the delete button cell

            // Append the new row to the table body
            tableBody.appendChild(newRow);
          }

       </script>
<script>
      function submitForm(event) {

        event.preventDefault(); // Prevent the default form submission

        
        // Get the form data
        var form = document.getElementById("myForm");
        var formData = new FormData(form);
        
        var poInput = document.getElementById("PO_Number");
        var poValue = poInput.value;
        formData.append("PO_Number", poValue);

        var pInput = document.getElementById("Package");
        var pValue = pInput.value;
        formData.append("Package", pValue);

        var loInput = document.getElementById("location");
        var loValue = loInput.value;
        formData.append("location", loValue);


        var textareaValues = document.querySelectorAll('textarea[name="Activity[]"]');
        textareaValues.forEach(function (textarea) {
          console.log('Textarea Value:', textarea.value); // Log the textarea value
          formData.append('Activity[]', textarea.value);
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

        console.log('FormData:', formData); // Log the FormData object

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'visit_insert.php', true);
        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4) {
            if (xhr.status === 200) {
              // Request successful
              console.log('Request successful');
              var response = xhr.responseText;
              console.log(response); 

              if (response === "Data inserted successfully") {
                // Display success message to the user
                alert("Data inserted successfully");
                  window.location.href = "update_actuals.php";

              } else {
                // Display error message to the user
                alert(" inserted data");
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

</div>
    
  <script>
    $(document).ready(function() {
      $('.btn-expand-collapse').click(function(e) {
        e.preventDefault();
        $('.navbar-primary').toggleClass('collapsed');
        $('.main-content').toggleClass('collapsed');
      });
    });
  </script>
</div>



</body>
</html>