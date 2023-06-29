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

    table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 50px;
    margin-left: 20px;
    margin-right: 20px;
    border: 1px solid black; /* Add border style */

  }

  th, td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid black;
    border-right: 1px solid black; /* Add vertical lines */
  }

  th {
    background-color: #f2f2f2;
  }

  tr:nth-child(even) {
    background-color: #f9f9f9;
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
                  <a href="admin.php" class="homered">
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
$query = "SELECT Name, Email, Role FROM login WHERE Role = 'Approver' OR Role = 'User';";
$result = mysqli_query($conn, $query);

echo '<form id="role-form" action="handle_role.php" method="POST">';
echo '<table id="table-container">';
echo '<tr>';
echo '<th>Name</th>';
echo '<th>Email</th>';
echo '<th>Role</th>';
echo '<th>PO Access</th>';
echo '</tr>';

while ($row = mysqli_fetch_assoc($result)) {
    $Name = $row['Name'];
    $Email = $row['Email'];
    $Role = $row['Role'];

    echo '<tr>';
    echo '<td>' . $Name . '</td>';
    echo '<td>' . $Email . '</td>';
    echo '<td>';
    echo '<select name="role[]" onchange="checkChanges(this)">';
  
    // Add options for selection
    echo '<option value="User"';
    if ($Role == 'User') {
        echo ' selected';
    }
    echo '>User</option>';
  
    echo '<option value="Approver"';
    if ($Role == 'Approver') {
        echo ' selected';
    }
    echo '>Approver</option>';
  
    echo '<option value="Admin"';
    if ($Role == 'Admin') {
        echo ' selected';
    }
    echo '>Admin</option>';
  
    echo '</select>';
    echo '</td>';
  
    echo '<td><a href="PO_change.php?Email=' . $Email . '"><img src="../process/images/eye.png" alt="View Details" width="20" height="20"></a></td>';
    echo '<input type="hidden" name="email[]" value="' . $Email . '">'; // Add hidden input for email
    echo '<input type="hidden" name="original_role[]" value="' . $Role . '">'; // Add hidden input for original role
  
    echo '</tr>';
}
echo '</table>';

echo '<br>';
echo '<br>';
echo '<br>';
echo '<div style="text-align: center;">';
echo '<button type="submit" id="submit-btn" name="save_changes" disabled>Save Changes</button>';
echo '</div>';
echo '</form>';
?>

<script>
    function checkChanges(selectElement) {
        var submitBtn = document.getElementById('submit-btn');
        submitBtn.disabled = !selectElement.valueChanged;
    }

    // Track changes in select elements
    var selectElements = document.querySelectorAll('select[name="role[]"]');
    selectElements.forEach(function(selectElement) {
        selectElement.valueChanged = false;
        selectElement.addEventListener('change', function() {
            this.valueChanged = true;
            checkChanges(this);
        });
    });

    // Submit the form with only the changed values
    document.getElementById('role-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission
        console.log('Form submitted!'); // Added console.log statement


        // Get the changed select elements
        var changedSelectElements = Array.from(selectElements).filter(function(selectElement) {
            return selectElement.valueChanged;
        });

        // Create a FormData object to store the changed values
        var formData = new FormData();

        // Append the changed values to the FormData object
        changedSelectElements.forEach(function(selectElement) {
            var email = selectElement.closest('tr').querySelector('input[name="email[]"]').value;
            var originalRole = selectElement.closest('tr').querySelector('input[name="original_role[]"]').value;
            formData.append('email[]', email);
            formData.append('role[]', selectElement.value);
            formData.append('original_role[]', originalRole);
        });

        // Send the form data to the server using AJAX or fetch
        fetch('handle_role.php', {
            method: 'POST',
            body: formData
        })
        .then(function(response) {
          if (response.ok) {
        // Handle the success case
        response.text().then(function(responseText) {
            console.log('Response:', responseText);
            alert('Changed Successfully');
            window.location.href = 'admin.php'; // Redirect to admin.php
        });
    } else {
        // Handle the error case
        alert('Failed to save changes.');
    }
        })
        .catch(function(error) {
            // Handle the error case
            alert('An error occurred: ' + error.message);
        });
    });
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