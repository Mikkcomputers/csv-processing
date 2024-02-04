<?php
function export(){
    include "./connection.php";
// Fetch data from the database
$sql = "SELECT * FROM result_table";
$result = $conn->query($sql);

// Check if there are rows in the result
if ($result->num_rows > 0) {
    // Define the CSV file name
    $csvFileName = 'exported_data.csv';

    // Set headers to force download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $csvFileName . '"');
    
    // Open the output stream
    $output = fopen('php://output', 'w');

    // Output column headers
    $headers = array('Column1', 'Column2', 'Column3'); // Replace with your actual column names
    fputcsv($output, $headers);

    // Output data from the database
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }

    // Close the output stream
    fclose($output);
} else {
    echo "No data to export.";
}

// Close the database connection
$conn->close();
}


