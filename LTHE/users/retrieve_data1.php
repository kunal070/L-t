<?php
require_once('../process/dbh.php');

if (isset($_GET['PO_num'])) {
    $selectedpkg = mysqli_real_escape_string($conn, $_GET['PO_num']);
    $asli_activities = [];

    // Query the database to retrieve the required data based on $v_id
    $query = "SELECT v_id , Package, loaction,Description,Tag_no,start_date,final_date,Draft FROM temp1 WHERE Purc_num = '$selectedpkg' ";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $asli_activities = $data['Description'];
        $d = $data['Draft'];
        if ($d === '0') {
            $response = array(
                'v_id' => $data['v_id'],
                'package' => $data['Package'],
                'location' => $data['loaction'],
                'activity' => $data['Description'],
                'tag' => $data['Tag_no'],
                's_date' => $data['start_date'],
                'e_date' => $data['final_date'],
                'Draft' => 0
                // Add other properties as needed
            );
            echo json_encode($response);
        } else if ($d === '1') {
            $query = "SELECT v_id, Package, location, activity, Tag_no, S_date, E_date, Actuals, A_Sdate, A_Edate, Pay,Status,Rejected_date FROM temp_approve WHERE PO_num = '$selectedpkg'";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $data = mysqli_fetch_assoc($result);

                $response = array(
                    'asli_activities' => $asli_activities,
                    'v_id' => $data['v_id'],
                    'package' => $data['Package'],
                    'location' => $data['location'],
                    'activity' => $data['activity'],
                    'tag' => $data['Tag_no'],
                    's_date' => $data['S_date'],
                    'e_date' => $data['E_date'],
                    'Actuals' => $data['Actuals'],
                    'A_Sdate' => $data['A_Sdate'],
                    'A_Edate' => $data['A_Edate'],
                    'Pay' => $data['Pay'],
                    'Status' => $data['Status'],
                    'Rejected_date' => $data['Rejected_date'],
                    'Draft' => 1
                    // Add other properties as needed
                );
                echo json_encode($response);
            }
        }
    } else {
        // Handle the case when no data is found for the provided v_id
        $response = array(
            'error' => 'No data found for the provided v_id'
        );
        echo json_encode($response);
    }
} else {
    // Handle the case when v_id is not set
    $response = array(
        'error' => 'Invalid request'
    );
    echo json_encode($response);
}
?>

