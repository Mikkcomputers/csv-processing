<?php
include "connection.php";
    if (isset($_POST['btn'])) {
        
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if a file was uploaded without errors
    if (isset($_FILES["csvFile"]) && $_FILES["csvFile"]["error"] == UPLOAD_ERR_OK) {
        // Get details of the uploaded file
        $fileTmpPath = $_FILES["csvFile"]["tmp_name"];
        $fileName = $_FILES["csvFile"]["name"];

        // Validate file extension (optional)
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if ($fileExtension != "csv") {
            echo "Invalid file format. Please upload a CSV file.";
            exit();
        }

        // Move the uploaded file to a designated location
        $uploadDirectory = "uploads/";
        $uploadedFilePath = $uploadDirectory . $fileName;
        move_uploaded_file($fileTmpPath, $uploadedFilePath);

        echo "File uploaded successfully. Processing CSV data...";

        // Now you can process the contents of the CSV file using functions like fgetcsv
        // For example:
        $file = fopen($uploadedFilePath, 'r');
        while (($row = fgetcsv($file)) !== false) {
            // Process each row as needed
            $sql = "INSERT INTO result_table(`SN`,`NAMES`,`SUBJECT`,`FIRST_CA`, `SECOND_CA`,`EXAMS`,`TOTAL`)VALUES('".$row[0]."','".$row[1]."','".$row[2]."','".$row[3]."','".$row[4]."','".$row[5]."','".$row[6]."')";
            $res = $conn->query($sql);
            if (!$res == true) {
                echo"File fail to insert into dams.. "."<br>".$conn->error;
            }else{
                // echo"successfully adding into dams"."<br>";
            }
        }
        fclose($file);

    } else {
        echo "Error uploading file. Please try again.";
    }
} else {
    echo "Invalid request method.";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSV File Upload</title>
</head>
<body>
    <h1>CSV File Upload</h1>

    <form action="index.php" method="post" enctype="multipart/form-data">
        <label for="csvFile">Upload CSV file:</label>
        <input type="file" id="csvFile" name="csvFile" accept=".csv" required>
        <!-- <input type="submit" value="submit"> -->
        <button name="btn">Upload</button>
    </form>
</body>
</html>
