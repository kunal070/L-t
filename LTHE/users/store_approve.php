<?php
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;
session_start();
require_once('../process/dbh.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $vid = $_POST['v_id'];
        if (isset($_POST["actuals"]) && isset($_POST["actualsStart_date"]) && isset($_POST["actualsEnd_date"]) && isset($_POST["pay"])) {
            // Access the values submitted by the user
            $activity =  $_POST["activity"];
            $Tag_num =  $_POST["Tag_num"];
            $Start_date =  $_POST["Start_date"];
            $End_date =  $_POST["End_date"];
            $actuals = $_POST["actuals"];
            $actualsStart_date = $_POST["actualsStart_date"];
            $actualsEnd_date = $_POST["actualsEnd_date"];
            $pay = $_POST["pay"];
            $createdby = $_SESSION["User_ID"];
            $submitButton = $_POST["submitButton"];
            $Remarks = "NAN";

            // You can then perform further actions or store the values as needed
            // For example, you can echo the values back to the user
            // echo "Actuals: " . implode(", ", $actuals) . "<br>";
            // echo "Actual Start Date: " . implode(", ", $actualsStart_date) . "<br>";
            // echo "Actual End Date: " . implode(", ", $actualsEnd_date) . "<br>";
            // echo "Pay: " . implode(", ", $pay) . "<br>";

        }
            
        if (isset($vid)) {
                // Retrieve the values from the database
                $sql = "SELECT Purc_num, Package, loaction FROM temp1 WHERE v_id = '$vid'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $ponumber = $row['Purc_num'];
                        $package = $row['Package'];
                        $location = $row['loaction'];
                    }
                } else {
                    echo "No rows found";
                }

                //confidentiality

                // $poNumToDelete = $ponumber;
                // $sql = "UPDATE confidentiality
                // SET PO_num = JSON_REMOVE(PO_num, JSON_UNQUOTE(JSON_SEARCH(PO_num, 'one', " . $poNumToDelete . ")))
                // WHERE email  = '" .$createdby. "'
                // AND PO_num LIKE CONCAT('%', " . $poNumToDelete . ", '%')";

                // Execute the query
                $result = mysqli_query($conn, $sql);

                // Encode the arrays as JSON strings
                $encodedActuals = json_encode($actuals);
                $encodedActualStartDate = json_encode($actualsStart_date);
                $encodedActualEndDate = json_encode($actualsEnd_date);
                $encodedPay = json_encode($pay);
                $encodedactivity = json_encode($activity);
                $encodedTag_num = json_encode($Tag_num);
                $encodedStart_date = json_encode($Start_date);
                $encodedEnd_date = json_encode($End_date);
                $size = strlen($encodedEnd_date);
                
                if ($submitButton === 'Approve') {
                    $status = 1;
                    $currentDate = date("d-m-y");  // Format: YYYY-MM-DD

                      // Check if the v_id already exists in the temp_approve table
                      $checkQuery = "SELECT v_id FROM temp_approve WHERE v_id = '$vid'";
                      $checkResult = mysqli_query($conn, $checkQuery);
  
                      if ($checkResult && mysqli_num_rows($checkResult) > 0) {
                          // Update the existing record
                          $updateQuery = "UPDATE temp_approve SET
                              PO_num = '$ponumber',
                              Package = '$package',
                              location = '$location',
                              activity = '$encodedactivity',
                              Tag_no = '$encodedTag_num',
                              S_date = '$encodedStart_date',
                              E_date = '$encodedEnd_date',
                              Actuals = '$encodedActuals',
                              A_Sdate = '$encodedActualStartDate',
                              A_Edate = '$encodedActualEndDate',
                              Pay = '$encodedPay',
                              Status = '$status',
                              Created_by = '$createdby',
                              Remarks = '$Remarks',
                              Approved_date = '$currentDate'
                              WHERE v_id = '$vid'";
  
                          $result1 = mysqli_query($conn, $updateQuery);
  
                          if ($result1) {
                              // Record updated successfully
                              // You can add any additional logic or response here
                              echo "Approved";
                          } else {
                              // Error updating record
                              // You can add any additional error handling or response here
                              echo "Error updating record: " . mysqli_error($conn);
                          }
                      } else {
                          // Insert a new record
                          $insertQuery = "INSERT INTO temp_approve (v_id, PO_num, Package, location, activity, Tag_no, S_date, E_date, Actuals, A_Sdate, A_Edate, Pay, Status, Created_by,Remarks)
                              VALUES ('$vid', '$ponumber', '$package', '$location', '$encodedactivity', '$encodedTag_num', '$encodedStart_date', '$encodedEnd_date', '$encodedActuals', '$encodedActualStartDate', '$encodedActualEndDate', '$encodedPay', '$status', '$createdby','$Remarks')";
  
                          $result1 = mysqli_query($conn, $insertQuery);
  
                          if ($result1) {
                              // Record inserted successfully
                              // You can add any additional logic or response here
                              echo "Approved";
                          } else {
                              // Error inserting record
                              // You can add any additional error handling or response here
                              echo "Error inserting record: " . mysqli_error($conn);
                          }
                      }

                    $sql = "UPDATE temp1
                    SET Draft = 0
                    WHERE v_id = '$vid';";
            
                    $result2 = mysqli_query($conn, $sql);

                } 
                else if ($submitButton === 'For Approval') {
                    $status = 0;
                     // Check if the v_id already exists in the temp_approve table
                    $checkQuery = "SELECT v_id FROM temp_approve WHERE v_id = '$vid'";
                    $checkResult = mysqli_query($conn, $checkQuery);

                    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
                        // Update the existing record
                        $updateQuery = "UPDATE temp_approve SET
                            PO_num = '$ponumber',
                            Package = '$package',
                            location = '$location',
                            activity = '$encodedactivity',
                            Tag_no = '$encodedTag_num',
                            S_date = '$encodedStart_date',
                            E_date = '$encodedEnd_date',
                            Actuals = '$encodedActuals',
                            A_Sdate = '$encodedActualStartDate',
                            A_Edate = '$encodedActualEndDate',
                            Pay = '$encodedPay',
                            Status = '$status',
                            Created_by = '$createdby',
                            Remarks = '$Remarks'
                            WHERE v_id = '$vid'";

                        $result1 = mysqli_query($conn, $updateQuery);


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
                            $mail->setFrom('from@example.com', $createdby);
                            $mail->addAddress('kp058665@gmail.com');     //Add a recipient

                           
                            
                            // Fields in horizontal alignment
                            $vertical = [
                                'visit Id' => $vid,
                                'Purchase Order number' => $ponumber,
                                'Package' => $package,
                                'Location' => $location,
                                'Created by' => $createdby
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

                            $verticalFields = [
                                'activity' => $encodedactivity,
                                'Tag_no' => $encodedTag_num,
                                'S_date' => $encodedStart_date,
                                'E_date' => $encodedEnd_date,
                                'Actuals' => $encodedActuals,
                                'A_Sdate' => $encodedActualStartDate,
                                'A_Edate' => $encodedActualEndDate,
                                'Pay' => $encodedPay
                            ];


                            // Transpose the data
                            $transposedFields = [];
                            foreach ($verticalFields as $field => $values) {
                                $fieldValues = json_decode($values, true);
                                foreach ($fieldValues as $index => $value) {
                                    $transposedFields[$index][$field] = $value;
                                }
                            }

                            // Generate HTML table for transposed fields
                            $transposedTableHTML = '<table style="border-collapse: collapse; border: 1px solid black;">';
                            $transposedTableHTML .= '<tr>';
                            foreach ($verticalFields as $field => $values) {
                                $transposedTableHTML .= '<th style="border: 1px solid black; padding: 5px;">' . $field . '</th>';
                            }
                            $transposedTableHTML .= '</tr>';

                            foreach ($transposedFields as $row) {
                                $transposedTableHTML .= '<tr>';
                                foreach ($row as $value) {
                                    $transposedTableHTML .= '<td style="border: 1px solid black; padding: 5px;">' . $value . '</td>';
                                }
                                $transposedTableHTML .= '</tr>';
                            }

                            $transposedTableHTML .= '</table>';

                            $button1Label = 'Approve';
                            $button2Label = 'Not Approve';
                            $button1Value = 'Approve';
                            $button2Value = 'Not Approve';

                            $emailBody = '
                            <form action="http://localhost/lthe/users/response-handler.php" method="post">
                                <input type="hidden" name="visit_id" value="' . $vid . '">
                                <br>
                                <br>
                                <label for="remarks">Enter remarks (if any):</label>
                                <br>
                                <textarea name="remarks" id="remarks"></textarea>
                                <br>
                                <br>
                                <button type="submit" name="button" value="' . $button1Value . '" style="background-color: green; color: white;">' . $button1Label . '</button>
                                <button type="submit" name="button" value="' . $button2Value . '" style="background-color: red; color: white;">' . $button2Label . '</button>
                                <br>
                            </form>
                        ';
                                // Construct the link URL with the vid value
                                $linkUrl = 'http://localhost/lthe/users/email_edit.php?visit_id=' . $vid;

                                // Create the HTML link with blue color
                                $linkHTML = '<a href="' . $linkUrl . '" style="color: blue; text-decoration: underline;">Click Me</a>';

                                // Update the email body with the link
                                $emailBody .= '<br><br> OR FOR EDIT: ' . $linkHTML;



                            //Content
                            $mail->isHTML(true);                                  //Set email format to HTML
                            $mail->Subject = 'Approval of vendor visit ID: ' . $vid;
                            $mail->Body = ' Main Fields: <br> ' . $horizontalHTML;
                            $mail->Body .= ' <br> <br> Activity Fields: <br>' . $transposedTableHTML;
                            $mail->Body .= $emailBody;
                            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                            $mail->send();
                            echo 'sent';
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }
                        if ($result1) {
                            // Record updated successfully
                            // You can add any additional logic or response here
                            echo "send";
                        } else {
                            // Error updating record
                            // You can add any additional error handling or response here
                            echo "Error updating record: " . mysqli_error($conn);
                        }
                    }

                    
                    else {
                        // Insert a new record
                        $insertQuery = "INSERT INTO temp_approve (v_id, PO_num, Package, location, activity, Tag_no, S_date, E_date, Actuals, A_Sdate, A_Edate, Pay, Status, Created_by,Remarks)
                            VALUES ('$vid', '$ponumber', '$package', '$location', '$encodedactivity', '$encodedTag_num', '$encodedStart_date', '$encodedEnd_date', '$encodedActuals', '$encodedActualStartDate', '$encodedActualEndDate', '$encodedPay', '$status', '$createdby','$Remarks')";

                        $result1 = mysqli_query($conn, $insertQuery);

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
                            $mail->setFrom('from@example.com', $createdby);
                            $mail->addAddress('kp058665@gmail.com');     //Add a recipient

                           
                            
                            // Fields in horizontal alignment
                            $vertical = [
                                'visit Id' => $vid,
                                'Purchase Order number' => $ponumber,
                                'Package' => $package,
                                'Location' => $location,
                                'Created by' => $createdby
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

                            $verticalFields = [
                                'activity' => $encodedactivity,
                                'Tag_no' => $encodedTag_num,
                                'S_date' => $encodedStart_date,
                                'E_date' => $encodedEnd_date,
                                'Actuals' => $encodedActuals,
                                'A_Sdate' => $encodedActualStartDate,
                                'A_Edate' => $encodedActualEndDate,
                                'Pay' => $encodedPay
                            ];


                            // Transpose the data
                            $transposedFields = [];
                            foreach ($verticalFields as $field => $values) {
                                $fieldValues = json_decode($values, true);
                                foreach ($fieldValues as $index => $value) {
                                    $transposedFields[$index][$field] = $value;
                                }
                            }

                            // Generate HTML table for transposed fields
                            $transposedTableHTML = '<table style="border-collapse: collapse; border: 1px solid black;">';
                            $transposedTableHTML .= '<tr>';
                            foreach ($verticalFields as $field => $values) {
                                $transposedTableHTML .= '<th style="border: 1px solid black; padding: 5px;">' . $field . '</th>';
                            }
                            $transposedTableHTML .= '</tr>';

                            foreach ($transposedFields as $row) {
                                $transposedTableHTML .= '<tr>';
                                foreach ($row as $value) {
                                    $transposedTableHTML .= '<td style="border: 1px solid black; padding: 5px;">' . $value . '</td>';
                                }
                                $transposedTableHTML .= '</tr>';
                            }

                            $transposedTableHTML .= '</table>';

                            $button1Label = 'Approve';
                            $button2Label = 'Not Approve';
                            $button1Value = 'Approve';
                            $button2Value = 'Not Approve';

                            $emailBody = '
                            <form action="http://localhost/lthe/users/response-handler.php" method="post">
                                <input type="hidden" name="visit_id" value="' . $vid . '">
                                <br>
                                <br>
                                <label for="remarks">Enter remarks (if any):</label>
                                <br>
                                <textarea name="remarks" id="remarks"></textarea>
                                <br>
                                <br>
                                <button type="submit" name="button" value="' . $button1Value . '" style="background-color: green; color: white;">' . $button1Label . '</button>
                                <button type="submit" name="button" value="' . $button2Value . '" style="background-color: red; color: white;">' . $button2Label . '</button>
                                <br>
                            </form>
                        ';
                                // Construct the link URL with the vid value
                                $linkUrl = 'http://localhost/lthe/users/email_edit.php?visit_id=' . $vid;

                                // Create the HTML link with blue color
                                $linkHTML = '<a href="' . $linkUrl . '" style="color: blue; text-decoration: underline;">Click Me</a>';

                                // Update the email body with the link
                                $emailBody .= '<br><br> OR FOR EDIT: ' . $linkHTML;
                                //Content
                                $mail->isHTML(true);                                  //Set email format to HTML
                                $mail->Subject = 'Approval of vendor visit ID: ' . $vid;
                                $mail->Body = ' Main Fields: <br> ' . $horizontalHTML;
                                $mail->Body .= ' <br> <br> Activity Fields: <br>' . $transposedTableHTML;
                                $mail->Body .= $emailBody;
                                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                                $mail->send();
                                echo 'sent';
                            } catch (Exception $e) {
                                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                            }

                        if ($result1) {
                            // Record inserted successfully
                            // You can add any additional logic or response here
                            echo "send";
                        } else {
                            // Error inserting record
                            // You can add any additional error handling or response here
                            echo "Error inserting record: " . mysqli_error($conn);
                        }
                    }

                     $sql = "UPDATE temp1
                    SET Draft = 0
                    WHERE v_id = '$vid';";
                    $result2 = mysqli_query($conn, $sql);


                    // Retrieve the JSON data from the database
                    $query = "SELECT For_Approval FROM temp_approve WHERE v_id = $vid"; 
                    $result = mysqli_query($conn, $query);
                    if ($result) {
                        $row = mysqli_fetch_assoc($result);
                        $forApprovalData = json_decode($row['For_Approval'], true);

                        if ($forApprovalData === null) {
                            $forApprovalData = [];
                        }

                        // Append the formatted current date to the array
                        $forApprovalData[] = date("d-m-y");

                        // Convert the updated array back to JSON
                        $updatedForApproval = json_encode($forApprovalData);

                        // Update the For_Approval column in the database
                        $updateQuery = "UPDATE temp_approve SET For_Approval = '$updatedForApproval' WHERE v_id = $vid";
                        $updateResult = mysqli_query($conn, $updateQuery);
                        if ($updateResult) {
                        } else {
                        }
                    } 


                 }
                else if ($submitButton === 'Save as Draft') {
                    $status = 2;
                    // Insert the data into the temp_approve table
                    $sql = "INSERT INTO temp_approve(v_id, PO_num, Package, location, activity, Tag_no, S_date, E_date, Actuals, A_Sdate, A_Edate, Pay, Status, Created_by,Remarks)
                            VALUES ('$vid', '$ponumber', '$package', '$location', '$encodedactivity', '$encodedTag_num', '$encodedStart_date', '$encodedEnd_date', '$encodedActuals', '$encodedActualStartDate', '$encodedActualEndDate', '$encodedPay', '$status', '$createdby','$Remarks')";
    
                    $result1 = mysqli_query($conn, $sql);
                    
                    $sql = "UPDATE temp1
                    SET Draft = 1
                    WHERE v_id = '$vid';";
            
                    $result2 = mysqli_query($conn, $sql);
                    
                    if ($result1) {
                        echo "saved";
                    } else {
                        echo "Error updating database";
                    }

                }
            } else {
                echo "Select all fields";
            }
        }
?>