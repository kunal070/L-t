<?php
$filename = 'example.xlsx';
$filePath = 'D:/' . $filename;

// Check if the file exists
if (file_exists($filePath)) {
    // Set headers to force download the file
    header("Content-Type: application/octet-stream");
    header("Content-Transfer-Encoding: Binary");
    header("Content-disposition: attachment; filename=\"" . basename($filePath) . "\"");

    // Read the file and output it to the browser
    readfile($filePath);
    exit;
} else {
    echo "File not found.";
}
?>
