<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <!-- Title Page-->
    <title>Add Activity | User Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <style>


        #submitbutton {
        display: block;
        margin: 0 auto;
        border: none;
        background-color: green;
        color: white;
        padding: 10px;
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

    .navbar-primary-menu li a {
  text-decoration: none;
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

    #submit-button {
        display: block;
        margin: 0 auto;
        border: none;
        background-color: green;
        color: white;
        padding: 10px;
      }
    </style>
</head>

<body>
<nav class="navbar navbar-inverse navbar-global fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="#">LTHE</a>
      </div>
      <!--/.nav-collapse -->
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
        <a href="user_reports.php">
          <div class="navbar-logo">
            <img src="../process/images/report.png" alt="Logo" width="30" height="30">
          </div>
          <span class="nav-label">Reports</span>
        </a>
      </li>
    </ul>
  </nav>

  <div class="main-content"> 
  <form method="POST" id="myForm" onsubmit="submitForm(event)">
    <br>
    <h3 style="text-align:center; color:blue;" > Configuration of Baseline Provisions  </h3> 
    <br> 
    <br> 
        
        <table id="activity-table" style="width:100%">
            <tr>
                <th style="width: 2%">Sr. No.</th>
                <th>PO Number</th>
                <th>Package</th>
                <th>Supplier</th>
                <th> Location</th>
                <th>Currency</th>
                <th>Per Day Rate</th>
                <th>Provision</th>
                <th> Construction Days</th>
                <th>Pre-comm. Days</th>
                <th> DLP Days</th>
                <th> remarks</th>
                <th> Delete</th>
            </tr>
        </table>
        <button  id="addRowButton" type="button">+</button> 
        <br>
        <br>
        <br> 
            <button class="submit-button" id="submitbutton" name="submit" type="submit" value="Submit">Save</button>
  </form>
             <br>       
             <br>       
             <br>       
      
</div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <script> 
            // Get the button and table body references
            var serialNumber = 1; // Initialize the serial number
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
        var currencies = ['USD', 'EUR', 'GBP', 'JPY', 'CAD', 'INR']; // List of currencies including INR

        var i =0;
        var row = document.createElement('tr');

        var cell1 = document.createElement('td');
        cell1.textContent = serialNumber;
        row.appendChild(cell1);
        serialNumber++; // Increment the serial number


        var cell2 = document.createElement('td');
        var poNumberInput = document.createElement('input');
        poNumberInput.type = 'number';
        poNumberInput.name = 'po_number[]';
        cell2.appendChild(poNumberInput);
        row.appendChild(cell2);

        var cell3 = document.createElement('td');
        var packageTextarea = document.createElement('textarea');
        packageTextarea.name = 'package[]';
        packageTextarea.rows = 1;
        packageTextarea.style.width = '300px';
        packageTextarea.style.height = 'auto';
        packageTextarea.wrap = 'soft';
        packageTextarea.maxLength = 100;
        packageTextarea.placeholder = '';
        packageTextarea.style.resize = 'none';
        cell3.appendChild(packageTextarea);
        row.appendChild(cell3);

        var cell4 = document.createElement('td');
        var supplierTextarea = document.createElement('textarea');
        supplierTextarea.name = 'supplier[]';
        supplierTextarea.rows = 1;
        supplierTextarea.style.width = '300px';
        supplierTextarea.style.height = 'auto';
        supplierTextarea.wrap = 'soft';
        supplierTextarea.maxLength = 100;
        supplierTextarea.placeholder = '';
        supplierTextarea.style.resize = 'none';
        cell4.appendChild(supplierTextarea);
        row.appendChild(cell4);

        var cell5 = document.createElement('td');
        var locationInput = document.createElement('input');
        locationInput.type = 'text';
        locationInput.name = 'location[]';
        cell5.appendChild(locationInput);
        row.appendChild(cell5);

        var cell6 = document.createElement('td');
        var currencySelect = document.createElement('select');
        currencySelect.name = 'currency[]';
        currencies.forEach(function(currency) {
          var option = document.createElement('option');
          option.value = currency;
          option.textContent = currency;
          currencySelect.appendChild(option);
        });
        cell6.appendChild(currencySelect);
        row.appendChild(cell6);

        var cell7 = document.createElement('td');
        var perDayRateInput = document.createElement('input');
        perDayRateInput.type = 'number';
        perDayRateInput.name = 'per_day_rate[]';
        cell7.appendChild(perDayRateInput);
        row.appendChild(cell7);

        var cell8 = document.createElement('td');
        var provisionInput = document.createElement('input');
        provisionInput.type = 'number';
        provisionInput.name = 'provision[]';
        cell8.appendChild(provisionInput);
        row.appendChild(cell8);

        var cell9 = document.createElement('td');
        var constructionDaysInput = document.createElement('input');
        constructionDaysInput.type = 'number';
        constructionDaysInput.name = 'construction_days[]';
        cell9.appendChild(constructionDaysInput);
        row.appendChild(cell9);

        var cell10 = document.createElement('td');
        var precommDaysInput = document.createElement('input');
        precommDaysInput.type = 'number';
        precommDaysInput.name = 'precomm_days[]';
        cell10.appendChild(precommDaysInput);
        row.appendChild(cell10);

        var cell11 = document.createElement('td');
        var dlpDaysInput = document.createElement('input');
        dlpDaysInput.type = 'number';
        dlpDaysInput.name = 'dlp_days[]';
        cell11.appendChild(dlpDaysInput);
        row.appendChild(cell11);

        var cell12 = document.createElement('td');
        var remarksTextarea = document.createElement('textarea');
        remarksTextarea.name = 'remarks[]';
        remarksTextarea.rows = 1;
        remarksTextarea.style.width = '300px';
        remarksTextarea.style.height = 'auto';
        remarksTextarea.wrap = 'soft';
        remarksTextarea.maxLength = 100;
        remarksTextarea.placeholder = '';
        remarksTextarea.style.resize = 'none';
        cell12.appendChild(remarksTextarea);
        row.appendChild(cell12);

        var deleteCell = document.createElement('td');
        var deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.textContent = '-';
        deleteButton.addEventListener('click', function() {
          // Handle row deletion
          var row = this.closest('tr');
          row.parentNode.removeChild(row);
          serialNumber--; // Increment the serial number

        });
        deleteCell.appendChild(deleteButton);
        row.appendChild(deleteCell);

        document.getElementById('activity-table').appendChild(row);
      }
</script>

<script>
      function submitForm(event) {

        event.preventDefault(); // Prevent the default form submission

        
        // Get the form data
        var form = document.getElementById("myForm");
        var formData = new FormData(form);
      
        // Retrieving input field values
        var poNumberValues = document.querySelectorAll('input[name="po_number[]"]');
        poNumberValues.forEach(function(input) {
          console.log('po_number Value:', input.value); // Log the input value
          formData.append('po_number[]', input.value);
        });

        var locationValues = document.querySelectorAll('input[name="location[]"]');
        locationValues.forEach(function(input) {
          console.log('location Value:', input.value); // Log the input value
          formData.append('location[]', input.value);
        });

        var perDayRateValues = document.querySelectorAll('input[name="per_day_rate[]"]');
        perDayRateValues.forEach(function(input) {
          console.log('per_day_rate Value:', input.value); // Log the input value
          formData.append('per_day_rate[]', input.value);
        });

        var provisionValues = document.querySelectorAll('input[name="provision[]"]');
        provisionValues.forEach(function(input) {
          console.log('provision Value:', input.value); // Log the input value
          formData.append('provision[]', input.value);
        });

        var constructionDaysValues = document.querySelectorAll('input[name="construction_days[]"]');
        constructionDaysValues.forEach(function(input) {
          console.log('construction_days Value:', input.value); // Log the input value
          formData.append('construction_days[]', input.value);
        });

        var precommDaysValues = document.querySelectorAll('input[name="precomm_days[]"]');
        precommDaysValues.forEach(function(input) {
          console.log('precomm_days Value:', input.value); // Log the input value
          formData.append('precomm_days[]', input.value);
        });

        var dlpDaysValues = document.querySelectorAll('input[name="dlp_days[]"]');
        dlpDaysValues.forEach(function(input) {
          console.log('dlp_days Value:', input.value); // Log the input value
          formData.append('dlp_days[]', input.value);
        });


        // Retrieving textarea values
        var packageValues = document.querySelectorAll('textarea[name="package[]"]');
        packageValues.forEach(function(textarea) {
          console.log('package Values:', textarea.value); // Log the textarea value
          formData.append('package[]', textarea.value);
        });

        var supplierValues = document.querySelectorAll('textarea[name="supplier[]"]');
        supplierValues.forEach(function(textarea) {
          console.log('supplier Values:', textarea.value); // Log the textarea value
          formData.append('supplier[]', textarea.value);
        });

        var remarksValues = document.querySelectorAll('textarea[name="remarks[]"]');
        remarksValues.forEach(function(textarea) {
          console.log('remarks Values:', textarea.value); // Log the textarea value
          formData.append('remarks[]', textarea.value);
        });

        var currencyValues = document.querySelectorAll('select[name="currency[]"]');
        currencyValues.forEach(function(select) {
          var selectedOption = select.options[select.selectedIndex];
          console.log('currency Value:', selectedOption.value); // Log the selected option value
          formData.append('currency[]', selectedOption.value);
        });



        console.log('FormData:', formData); // Log the FormData object

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'manual_insert.php', true);
        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4) {
            if (xhr.status === 200) {
              // Request successful
              console.log('Request successful');
              var response = xhr.responseText;
              // Process the response as needed
              console.log(response); // Log the response from store_approve.php
              if (response === "Data inserted successfully") {
                // Display success message to the user
                alert("Data inserted successfully");
                  window.location.href = "excel_manual.php";

              } else {
                // Display error message to the user
                alert(" inserted data");
                window.location.href = "excel_manual.php";

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