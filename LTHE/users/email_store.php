<?php 
require_once('../process/dbh.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if(isset($_POST['tag_no'])){
        $visitId = $_POST['visitID'];
        $poNumber = $_POST['poNumber'];
        $package = $_POST['package'];
        $location = $_POST['location'];
        $buttonResponse = $_POST['button'];

    
        // Retrieve the values from the activity table
        // Retrieve the activity-related values
        $activityValues = $_POST['activity'];
        $tagNoValues = $_POST['tag_no'];
        $startDateValues = $_POST['start_date'];
        $endDateValues = $_POST['end_date'];
        $actualsValues = $_POST['actuals'];
        $actualStartDateValues = $_POST['actual_start_date'];
        $actualEndDateValues = $_POST['actual_end_date'];
        $payValues = $_POST['pay'];
        $RemarksValues = $_POST['indi_remarks'];
        $Remark = $_POST['Remarks'];
    
        // Convert arrays to JSON
        $encodedActivity = json_encode($activityValues);
        $encodedTagNo = json_encode($tagNoValues);
        $encodedStartDate = json_encode($startDateValues);
        $encodedEndDate = json_encode($endDateValues);
        $encodedActuals = json_encode($actualsValues);
        $encodedActualStartDate = json_encode($actualStartDateValues);
        $encodedActualEndDate = json_encode($actualEndDateValues);
        $encodedPay = json_encode($payValues);
        $encodedRemarks = json_encode($RemarksValues);
        

            // Perform the desired actions based on the button response
    if ($buttonResponse === 'Approve') {

        $currentDate = date("Y-m-d");  // Format: YYYY-MM-DD
        $updateQuery = "UPDATE temp_approve SET
        PO_num = '$poNumber',
        Package = '$package',
        location = '$location',
        activity = '$encodedActivity',
        Tag_no = '$encodedTagNo',
        S_date = '$encodedStartDate',
        E_date = '$encodedEndDate',
        Actuals = '$encodedActuals',
        A_Sdate = '$encodedActualStartDate',
        A_Edate = '$encodedActualEndDate',
        Pay = '$encodedPay',
        Status = 1,
        Remarks = '$Remark',
        Approved_date = '$currentDate',
        indi_Remarks = '$encodedRemarks'
        WHERE v_id = '$visitId'";
    
        $result1 = mysqli_query($conn, $updateQuery);

        $sql = "UPDATE temp1
            SET Draft = 0
            WHERE v_id = '$visitId';";
        $result2 = mysqli_query($conn, $sql);

        if($result1){
            echo '<script>alert("Approved successful!");';
            echo 'window.location.href = "userlogin.php";</script>';
        }
    } elseif ($buttonResponse === 'Not Approve') {

        $updateQuery = "UPDATE temp_approve SET
        PO_num = '$poNumber',
        Package = '$package',
        location = '$location',
        activity = '$encodedActivity',
        Tag_no = '$encodedTagNo',
        S_date = '$encodedStartDate',
        E_date = '$encodedEndDate',
        Actuals = '$encodedActuals',
        A_Sdate = '$encodedActualStartDate',
        A_Edate = '$encodedActualEndDate',
        Pay = '$encodedPay',
        Status = 3,
        Remarks = '$Remark',
        indi_Remarks = '$encodedRemarks'
        WHERE v_id = '$visitId'";
    
        $result1 = mysqli_query($conn, $updateQuery);
        $sql = "UPDATE temp1
            SET Draft = 1
            WHERE v_id = '$visitId';";
        $result2 = mysqli_query($conn, $sql);

         // Retrieve the JSON data from the database
         $query = "SELECT Rejected_date FROM temp_approve WHERE v_id = $visitId"; 
         $result = mysqli_query($conn, $query);
         if ($result) {
             $row = mysqli_fetch_assoc($result);
             $forApprovalData = json_decode($row['Rejected_date'], true);

             if ($forApprovalData === null) {
                 $forApprovalData = [];
             }

             // Append the formatted current date to the array
             $forApprovalData[] = date("d-m-y");

             // Convert the updated array back to JSON
             $updatedForApproval = json_encode($forApprovalData);

             // Update the For_Approval column in the database
             $updateQuery = "UPDATE temp_approve SET Rejected_date = '$updatedForApproval' WHERE v_id = $visitId";
             $updateResult = mysqli_query($conn, $updateQuery);
             if ($updateResult) {
                echo '<script>alert("rejected successful!");';
            echo 'window.location.href = "userlogin.php";</script>';
             } else {
                echo "locha";
             }
         } 

        require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'lthe030974@gmail.com';                     //SMTP username
            $mail->Password   = 'shvjqcycgxhnrecw';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('from@example.com', "approver@gmail.com");
            $mail->addAddress('kp058665@gmail.com');     //Add a recipient

            // Fields in horizontal alignment
            $vertical = [
                'visit Id' => $visitId,
                'Purchase Order number' => $poNumber,
                'Package' => $package,
                'Location' => $location,
                'Created by' => $Created_by
            ];

            $horizontalHTML = '<table style="border-collapse: collapse; border: 1px solid black;">';
            $horizontalHTML .= '<tr>';
            foreach ($vertical as $label => $value) {
                $horizontalHTML .= '<th style="border: 1px solid black; padding: 5px;">' . $label . '</th>';
            }
            $horizontalHTML .= '</tr>';

            $horizontalHTML .= '<tr>';
            foreach ($vertical as $value) {
                $horizontalHTML .= '<td style="border: 1px solid black; padding: 5px;">' . $value . '</td>';
            }
            $horizontalHTML .= '</tr>';

            $horizontalHTML .= '</table>';

            // Construct the vertical fields array
            
            $verticalFields = [
                'activity' => $activity,
                'Tag_no' => $tagNo,
                'S_date' => $startDate,
                'E_date' => $endDate,
                'Actuals' => $actuals,
                'A_Sdate' => $actualStartDate,
                'A_Edate' => $actualEndDate,
                'Pay' => $pay
            ];
            
            $transposedTableHTML = '<table style="border-collapse: collapse; border: 1px solid black;">';
            
            // Add header row with field names
            $transposedTableHTML .= '<tr>';            
            // Iterate over the fields dynamically
            foreach ($verticalFields as $field => $values) {
                $transposedTableHTML .= '<th style="border: 1px solid black; padding: 5px;">' . $field . '</th>';
            }
            $transposedTableHTML .= '</tr>';
            
            // Determine the row count based on the number of values in the fields
            $rowCount = count(reset($verticalFields));
            for ($rowIndex = 0; $rowIndex < $rowCount; $rowIndex++) {
                $transposedTableHTML .= '<tr>';            
                // Iterate over the fields dynamically
                foreach ($verticalFields as $field => $values) {
                    $value = $values[$rowIndex];
                    $transposedTableHTML .= '<td style="border: 1px solid black; padding: 5px;">' . $value . '</td>';
                }
                $transposedTableHTML .= '</tr>';
            }
            
            $transposedTableHTML .= '</table>';
            

            // Construct the link URL with the visit_id value
            $linkUrl = 'http://localhost/lthe/users/update_actuals.php?visit_id=' . $visitId;

            // Create the HTML link with blue color
            $linkHTML = '<a href="' . $linkUrl . '" style="color: blue; text-decoration: underline;">Click Me</a>';

            // Update the email body with the link
            $emailBody = '<br><br> FOR EDIT: ' . $linkHTML;

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Rejection of vendor visit ID: ' . $visitId;
            $mail->Body = ' Main Fields: <br> ' . $horizontalHTML;
            $mail->Body .= ' <br> <br> Activity Fields: <br>' . $transposedTableHTML;
            $mail->Body .= $emailBody;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            $mail->send();
            echo 'sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    }   
}
?>
