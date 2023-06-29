<?php 
$visitId = $_GET['visit_id'];
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
  $activity = json_decode($row['activity'], true);
  $tagNo = json_decode($row['Tag_no'], true);
  $startDate = json_decode($row['S_date'], true);
  $endDate = json_decode($row['E_date'], true);
  $actuals = json_decode($row['Actuals'], true);
  $actualStartDate = json_decode($row['A_Sdate'], true);
  $actualEndDate = json_decode($row['A_Edate'], true);
  $pay = json_decode($row['Pay'], true);
  $status = $row['Status']; 
  $Approved_date = $row['Approved_date'];
  $pending = json_decode($row['For_Approval'], true);
  if (!empty($pending)) {
    $lastValue = end($pending);
} 
  $formatted_date = date('d-m-Y', strtotime($Approved_date)); 
  $create = $row['Created_by']; 
} else {
  echo "Error: " . mysqli_error($connection);
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
        <a href="Approval_view.php"  class="homered">
          <div class="navbar-logo">
            <img src="../process/images/report.png" alt="Logo" width="30" height="30">
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
    echo '<td><input type="text" name="poNumber" id="poNumber" value="' . $poNumber . '" readonly style="font-size: 15px;"></td>';
    echo '<td style="width: 20px;"></td>'; // Empty <td> element for spacing
    echo '<td style="padding-right: 10px;"><label for="package"><span style="font-size: 18px; font-weight: bold;">Package:</span></label></td>';
    echo '<td><input type="text" name="package" id="package" value="' . $package . '" readonly style="font-size: 15px;"></td>';
    echo '<td style="width: 20px;"></td>'; // Empty <td> element for spacing
    echo '<td style="padding-right: 10px;"><label for="location"><span style="font-size: 18px; font-weight: bold;">Location:</span></label></td>';
    echo '<td><input type="text" name="location" id="location" value="' . $location . '" readonly style="font-size: 15px;"></td>';

    echo '</tr>';
    echo '</table>';
  
    echo '</div>';
    echo '<br>';
    echo '<br>';
    echo '<br>';

    echo '<table id="activity-table">';
    ?>

    <div class="center">
      <p><strong>Status:</strong>
      <?php
      if ($status == 0) {
        echo "Pending";
        echo '<img class="logo" src="../process/images/pending_logo.jpeg" alt="Pending Logo">';
        echo 'from  ' . $lastValue;
      } else {
        echo "Approved";
        echo '<img class="logo" src="../process/images/correct_logo.png" alt="Approved Logo">';
        echo 'on  ' . $formatted_date;
      }
      ?>
      </p>
    </div>
    <tr>
    <th>Activity</th>
    <th>Tag No</th>
    <th>Start Date</th>
    <th>End Date</th>
    <th>Actuals</th>
    <th>Actual Start Date</th>
    <th>Actual End Date</th>
    <th>Pay</th>
  </tr>
  <?php for ($i = 0; $i < count($activity); $i++) { ?>
    <tr>
      <td><?php echo $activity[$i]; ?></td>
      <td><?php echo $tagNo[$i]; ?></td>
      <td><?php echo $startDate[$i]; ?></td>
      <td><?php echo $endDate[$i]; ?></td>
      <td><?php echo $actuals[$i]; ?></td>
      <td><?php echo $actualStartDate[$i]; ?></td>
      <td><?php echo $actualEndDate[$i]; ?></td>
      <td><?php echo $pay[$i]; ?></td>
    </tr>
  <?php } 
    echo '</table>';
    echo '<br>';
    echo '<br>';
    echo '<br>';

    echo '<div style="text-align: center;">';
    echo '<button type="button" name="cancel" onclick="confirmRedirect(\'Approval_view.php\')" style="font-size: 16px; background-color: blue; color: white;">Back</button>';
    echo '</div>';
    ?>
    </form>
  </div>
  <script>
    function confirmRedirect(redirectUrl) {
        if (confirm("Are you sure you want to leave")) {
            window.location.href = redirectUrl;
        }
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


