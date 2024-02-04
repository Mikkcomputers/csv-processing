<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSV Import</title>
</head>
<body>

<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "result_processing";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ...

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if a file was uploaded without errors
    if (isset($_FILES["btn_upload"])) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Allow only CSV files
        if ($fileType != "csv") {
            echo "Sorry, only CSV files are allowed.";
            $uploadOk = 0;
        }

        // Move the uploaded file to the target directory
        if ($uploadOk) {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
                // Get the absolute path
                $absolutePath = realpath($targetFile);
                print_r($absolutePath);
                // Use LOAD DATA INFILE to import the CSV file into the database
                // $sql = "LOAD DATA INFILE '$absolutePath' INTO TABLE result_table FIELDS TERMINATED BY ',' IGNORE 1 LINES";
                
                // if ($conn->query($sql) === TRUE) {
                //     echo "CSV file imported successfully.";
                // } else {
                //     echo "Error: " . $sql . "<br>" . $conn->error;
                // }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
}

// ...

?>

<!-- Form for file upload -->
<form action="" method="post" enctype="multipart/form-data">
    <label for="fileToUpload">Choose CSV file:</label>
    <input type="file" name="fileToUpload" id="fileToUpload" accept=".csv">
    <button name="btn_upload">Upload</button>
</form>

</body>
</html>
