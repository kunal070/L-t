<?php
// update_actuals.php

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the posted data
    $activityArray = $_POST['activityArray'];
    $tagArray = $_POST['tagArray'];
    $sDateArray = $_POST['sDateArray'];
    $eDateArray = $_POST['eDateArray'];

    // Print the received data for debugging
    echo 'Received activityArray: ' . $activityArray . '<br>';
    echo 'Received tagArray: ' . $tagArray . '<br>';
    echo 'Received sDateArray: ' . $sDateArray . '<br>';
    echo 'Received eDateArray: ' . $eDateArray . '<br>';
}
?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Function to send the updated arrays to update_actuals.php
    function sendArrays() {
        var activityArray = <?php echo isset($_POST['activityArray']) ? json_encode($_POST['activityArray']) : '[]'; ?>;
        var tagArray = <?php echo isset($_POST['tagArray']) ? json_encode($_POST['tagArray']) : '[]'; ?>;
        var sDateArray = <?php echo isset($_POST['sDateArray']) ? json_encode($_POST['sDateArray']) : '[]'; ?>;
        var eDateArray = <?php echo isset($_POST['eDateArray']) ? json_encode($_POST['eDateArray']) : '[]'; ?>;
        
        // Send the POST request using AJAX
        $.ajax({
            type: "POST",
            url: "update_actuals.php",
            data: {
                activityArray: activityArray,
                tagArray: tagArray,
                sDateArray: sDateArray,
                eDateArray: eDateArray
            },
            success: function(response) {
                // Handle the response from update_actuals.php if needed
                console.log(response);
            }
        });
    }

    // Example code to demonstrate updating the arrays and calling sendArrays()
    // ...

    // Update the arrays and call sendArrays() when they are changed
    // ...

    // Call sendArrays() initially to send the initial arrays to update_actuals.php
    sendArrays();
</script>
