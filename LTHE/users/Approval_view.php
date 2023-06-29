<?php
require_once('../process/dbh.php');
session_start();
$createdby = $_SESSION["User_ID"];
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

  .logo {
    width: 20px;
    height: 15px;
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

    .orange {
        color: orange;
    }
    .green {
        color: green;
    }
    .red {
        color: red;
    }
    .black {
        color: black;
    }

    .light-grey {
        background-color: #f2f2f2; /* Light gray background color */
        color: #808080; /* Dark gray text color */
    }
      .notification {
        background-color: #555;
        color: white;
        text-decoration: none;
        padding: 15px 26px;
        position: relative;
        display: inline-block;
        border-radius: 2px;
      }

      .notification:hover {
        background: red;
      }

      .notification .badge {
        position: absolute;
        top: -10px;
        right: -10px;
        padding: 5px 10px;
        border-radius: 50%;
        background: red;
        color: white;
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
        <a href="userlogin.php" >
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

  <?php
 if ($role == "User") {
  $counter=0;
  echo '<div class="main-content">';
  echo '<div style="text-align: center; margin-top: 20px;">
  <p style="font-size: 18px; font-weight: bold;">View Details</p>
  <div style="display: flex; justify-content: flex-end;">
    <a href="#" class="notification" style="margin-right: 40px;">
      <span>Rejected</span>
      <span class="badge" id="badgeCounter">0</span>
    </a>
  </div>
</div>
';
  // Retrieve the current sort column and order from the URL parameters
  $sortColumn = isset($_GET['sortColumn']) ? $_GET['sortColumn'] : 'status';
  $sortOrder = isset($_GET['sortOrder']) ? $_GET['sortOrder'] : 'desc';

  // Determine the opposite sort order for the next click
  $nextSortOrder = ($sortOrder === 'asc') ? 'desc' : 'asc';

  $query = "SELECT t.v_id, t.package, DATE_FORMAT(JSON_UNQUOTE(JSON_EXTRACT(t.S_date, '$[0]')), '%d-%m-%Y') AS S_date, t.PO_num, t.status,t.Approved_date,t.For_Approval,t.Rejected_date
  FROM temp_approve t
  WHERE t.status IN (0, 1, 3) AND EXISTS (
    SELECT 1 FROM confidentiality c
    WHERE c.email = '$createdby' AND JSON_CONTAINS(c.PO_num, JSON_ARRAY(t.PO_num), '$')
  )
  ORDER BY " . ((!isset($_GET['sortColumn']) && !isset($_GET['sortOrder'])) ? "CASE t.status
    WHEN 3 THEN 0
    WHEN 0 THEN 1
    WHEN 1 THEN 2
    ELSE 3 END" : "$sortColumn $sortOrder");

  $result = mysqli_query($conn, $query);
  function getSortLogo($columnName, $currentSortColumn, $currentSortOrder) {
    $ascLogo = '&#x25B2;'; // Upward triangle symbol (▲)
    $descLogo = '&#x25BC;'; // Downward triangle symbol (▼)

    if ($currentSortColumn === $columnName) {
        if ($currentSortOrder === 'asc') {
            return $ascLogo;
        } else {
            return $descLogo;
        }
    }

    return '';
}

  if ($result) {
    echo '<table id="table-container">';
    echo '<tr>';
    echo '<th><a href="?sortColumn=v_id&sortOrder=' . $nextSortOrder . '">Visit ID ' . getSortLogo('v_id', $sortColumn, $sortOrder) . '</a></th>';
    echo '<th><a href="?sortColumn=PO_num&sortOrder=' . $nextSortOrder . '">PO number ' . getSortLogo('PO_num', $sortColumn, $sortOrder) . '</a></th>';
    echo '<th><a href="?sortColumn=package&sortOrder=' . $nextSortOrder . '">Package ' . getSortLogo('package', $sortColumn, $sortOrder) . '</a></th>';
    echo '<th><a href="?sortColumn=S_date&sortOrder=' . $nextSortOrder . '">Start Date ' . getSortLogo('S_date', $sortColumn, $sortOrder) . '</a></th>';
    echo '<th><a href="?sortColumn=status&sortOrder=' . $nextSortOrder . '">Status ' . getSortLogo('status', $sortColumn, $sortOrder) . '</a></th>';
    echo '<th><a href="?sortColumn=Approved_date&sortOrder=' . $nextSortOrder . '">Approve/Reject/pending date ' . getSortLogo('Approved_date', $sortColumn, $sortOrder) . '</a></th>';
    echo '<th>View Details</th>';
    echo '</tr>';

    while ($row = mysqli_fetch_assoc($result)) {
      $vId = $row['v_id'];
      $poNumber = $row['PO_num'];
      $package = $row['package'];
      $startDate = $row['S_date'];
      $status = $row['status'];
      $Approved_date = $row['Approved_date'];
      $formattedDate = date("d-m-Y", strtotime($Approved_date));  
      $For_Approval = isset($row['For_Approval']) ? json_decode($row['For_Approval'], true) : null;
      $lastValue = !empty($For_Approval) ? end($For_Approval) : null;
  
      $Rejected_date = isset($row['Rejected_date']) ? json_decode($row['Rejected_date'], true) : null;
      $lastValue1 = !empty($Rejected_date) ? end($Rejected_date) : null;
  
      $remarks = '';
      $logo = '';
      $colorC = ''; // Initialize $colorC variable

      if ($status == 0) {
        $remarks = 'Pending';
        $logo = 'pending_logo.jpeg';
        $Approved_date = $lastValue;
        $colorClass = 'orange';
    } elseif ($status == 1) {
        $remarks = 'Approved';
        $logo = 'correct_logo.png';
        $Approved_date = $formattedDate;
        $colorClass = 'green';
        $colorC = 'light-grey'; // Updated class name for lighter style
    } elseif ($status == 3) {
        $remarks = 'Rejected';
        $logo = 'rejected_logo.jpeg';
        $Approved_date = $lastValue1;
        $colorClass = 'red';
        $counter++;
    } else {
        $remarks = 'Unknown';
        $logo = 'default_logo.png';
        $Approved_date = '';
        $colorClass = 'black'; // Default color
    }
  
      echo '<tr class="' . $colorC . '">';
      echo '<td>' . $vId . '</td>';
      echo '<td>' . $poNumber . '</td>';
      echo '<td>' . $package . '</td>';
      echo '<td>' . $startDate . '</td>';
      echo '<td class="' . $colorClass . '">' . $remarks . ' <img class="logo" src="../process/images/' . $logo . '" alt="' . $remarks . ' Logo"></td>';
      echo '<td>' . $Approved_date . '</td>';
      
      if ($status == 3) {
        echo '<td><a href="update_actuals.php?visit_id=' . $vId . '"><img src="../process/images/eye.png" alt="View Details" width="20" height="20"></a></td>';
      } else {
        echo '<td><a href="view_only.php?visit_id=' . $vId . '"><img src="../process/images/eye.png" alt="View Details" width="20" height="20"></a></td>';
      }
      
      echo '</tr>';
    }
    echo '</table>';
  } else {
    echo "Error: " . mysqli_error($conn);
  }
  echo '<script>var badgeCounter = ' . $counter . ';</script>'; 
  echo '</div>';
}else {
  $counter = 0;
  function getSortLogo($columnName, $currentSortColumn, $currentSortOrder) {
    $ascLogo = '&#x25B2;'; // Upward triangle symbol (▲)
    $descLogo = '&#x25BC;'; // Downward triangle symbol (▼)
    
    if ($currentSortColumn === $columnName) {
      if ($currentSortOrder === 'asc') {
        return $ascLogo;
        } else {
            return $descLogo;
          }
        }
        
        return '';
      }
      echo '<div class="main-content">';

      echo '<div style="text-align: center; margin-top: 20px;">
      <p style="font-size: 18px; font-weight: bold;">View Details</p>
      <div style="display: flex; justify-content: flex-end;">
        <a href="#" class="notification" style="margin-right: 35px;">
          <span>Pending</span>
          <span class="badge" id="badgeCounter">0</span>
        </a>
      </div>
    </div>
    ';
      
      
      // Retrieve the current sort column and order from the URL parameters
      $sortColumn = isset($_GET['sortColumn']) ? $_GET['sortColumn'] : 'status';
      $sortOrder = isset($_GET['sortOrder']) ? $_GET['sortOrder'] : 'desc';
      
      // Determine the opposite sort order for the next click
      $nextSortOrder = ($sortOrder === 'asc') ? 'desc' : 'asc';
      
      echo '<div style="margin-bottom: 10px;">';
      echo '<label for="statusFilter">Filter by Status:</label>';
      echo '<select id="statusFilter" onchange="filterTableByStatus()">';
      echo '<option value="all">All</option>';
      echo '<option value="0">Pending</option>';
      echo '<option value="1">Approved</option>';
      echo '<option value="3">Rejected</option>';
      echo '</select>';
      echo '</div>';

      echo '<script>
      function filterTableByStatus() {
        var selectedStatus = document.getElementById("statusFilter").value;
        var tableRows = document.querySelectorAll("#table-container tr");
      
        for (var i = 1; i < tableRows.length; i++) {
          var statusCell = tableRows[i].querySelector("td:nth-child(5)");
      
          if (selectedStatus === "all" || statusCell.classList.contains(selectedStatus)) {
            tableRows[i].style.display = "";
          } else {
            tableRows[i].style.display = "none";
          }
        }
      }
      
</script>';

      $query = "SELECT t.v_id, t.package, DATE_FORMAT(JSON_UNQUOTE(JSON_EXTRACT(t.S_date, '$[0]')), '%d-%m-%Y') AS S_date, t.PO_num, t.status,t.Approved_date,t.For_Approval,t.Rejected_date
  FROM temp_approve t
  WHERE t.status IN (0, 1, 3) AND EXISTS (
    SELECT 1 FROM confidentiality c
    WHERE c.email = '$createdby' AND JSON_CONTAINS(c.PO_num, JSON_ARRAY(t.PO_num), '$')
  )
  ORDER BY " . ((!isset($_GET['sortColumn']) && !isset($_GET['sortOrder'])) ? "CASE t.status
        WHEN 0 THEN 0
        WHEN 3 THEN 1
        WHEN 1 THEN 2
        ELSE 3 END" : "$sortColumn $sortOrder");
        
        $result = mysqli_query($conn, $query);
        
        if ($result) {
          echo '<table id="table-container">';
          echo '<tr>';
          echo '<th><a href="?sortColumn=v_id&sortOrder=' . $nextSortOrder . '">Visit ID ' . getSortLogo('v_id', $sortColumn, $sortOrder) . '</a></th>';
          echo '<th><a href="?sortColumn=PO_num&sortOrder=' . $nextSortOrder . '">PO number ' . getSortLogo('PO_num', $sortColumn, $sortOrder) . '</a></th>';
          echo '<th><a href="?sortColumn=package&sortOrder=' . $nextSortOrder . '">Package ' . getSortLogo('package', $sortColumn, $sortOrder) . '</a></th>';
          echo '<th><a href="?sortColumn=S_date&sortOrder=' . $nextSortOrder . '">Start Date ' . getSortLogo('S_date', $sortColumn, $sortOrder) . '</a></th>';
          echo '<th><a href="?sortColumn=status&sortOrder=' . $nextSortOrder . '">Status ' . getSortLogo('status', $sortColumn, $sortOrder) . '</a></th>';
          echo '<th><a href="?sortColumn=For_Approval&sortOrder=' . $nextSortOrder . '">Approve/Reject/pending date ' . getSortLogo('Approved_date', $sortColumn, $sortOrder) . '</a></th>';
          echo '<th>View Details</th>';
          echo '</tr>';
          
          while ($row = mysqli_fetch_assoc($result)) {
            $vId = $row['v_id'];
            $poNumber = $row['PO_num'];
            $package = $row['package'];
            $startDate = $row['S_date'];
            $status = $row['status'];
            $Approved_date = $row['Approved_date'];
            $formattedDate = date("d-m-Y", strtotime($Approved_date));  
            $For_Approval = isset($row['For_Approval']) ? json_decode($row['For_Approval'], true) : null;
            $lastValue = !empty($For_Approval) ? end($For_Approval) : null;
            
            $Rejected_date = isset($row['Rejected_date']) ? json_decode($row['Rejected_date'], true) : null;
            $lastValue1 = !empty($Rejected_date) ? end($Rejected_date) : null;
            
            $remarks = '';
            $logo = '';
            $colorC = ''; // Initialize $colorC variable

            
            if ($status == 0) {
              $remarks = 'Pending';
              $logo = 'pending_logo.jpeg';
              $Approved_date = $lastValue;
              $colorClass = 'orange';
              $counter++;
              $statusClass = 'status-pending';

          } elseif ($status == 1) {
              $remarks = 'Approved';
              $logo = 'correct_logo.png';
              $Approved_date = $formattedDate;
              $colorClass = 'green';
              $colorC = 'light-grey'; // Updated class name for lighter style
              $statusClass = 'status-approved';

          } elseif ($status == 3) {
              $remarks = 'Rejected';
              $logo = 'rejected_logo.jpeg';
              $Approved_date = $lastValue1;
              $colorClass = 'red';
              $statusClass = 'status-rejected';

          } else {
              $remarks = 'Unknown';
              $logo = 'default_logo.png';
              $Approved_date = '';
              $colorClass = 'black'; // Default color
          }

      echo '<tr class="' . $colorC . '">';
      echo '<td>' . $vId . '</td>';
      echo '<td>' . $poNumber . '</td>';
      echo '<td>' . $package . '</td>';
      echo '<td>' . $startDate . '</td>';
      echo '<td class="' . $colorClass . ' ' . $statusClass . '" data-status="' . $statusClass . '">' . $remarks . ' <img class="logo" src="../process/images/' . $logo . '" alt="' . $remarks . ' Logo"></td>';
      echo '<td>' . $Approved_date . '</td>';
      
      if ($status == 0){
        echo '<td><a href="email_edit.php?visit_id=' . $vId . '"><img src="../process/images/eye.png" alt="View Details" width="20" height="20"></a></td>';
      } 
      else if ($status == 3) {
        echo '<td><a href="email_edit.php?visit_id=' . $vId . '&flag=1"><img src="../process/images/eye.png" alt="View Details" width="20" height="20"></a></td>';
    }
    else {
        echo '<td><a href="view_only.php?visit_id=' . $vId . '"><img src="../process/images/eye.png" alt="View Details" width="20" height="20"></a></td>';
      }

      echo '</tr>';
    }

    echo '</table>';
  } else {
    echo "Error: " . mysqli_error($conn);
  }
  echo '<script>var badgeCounter = ' . $counter . ';</script>';

  echo '</div>';

}
?>

<script>
  window.addEventListener('DOMContentLoaded', function() {
    // Update the badge count with the dynamically set counter value
    document.getElementById('badgeCounter').textContent = badgeCounter;
  });
</script>

<script>
  function sortTable(column) {
    var sortColumn = column;
    var currentSortColumn = '<?php echo $sortColumn; ?>';
    var currentSortOrder = '<?php echo $sortOrder; ?>';
    var sortOrder;

    // Check if the current column is already being sorted
    if (column === currentSortColumn && currentSortOrder === 'asc') {
      // If currently in ascending order, switch to descending order
      sortOrder = 'desc';
    } else {
      // Otherwise, switch to ascending order
      sortOrder = 'asc';
    }

    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'Approval_view.php?sortColumn=' + sortColumn + '&sortOrder=' + sortOrder, true);
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        // Update the table with the sorted data
        document.getElementById('table-container').innerHTML = xhr.responseText;
      }
    };
    xhr.send();
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