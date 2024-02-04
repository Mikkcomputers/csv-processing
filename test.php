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

        $file = fopen($fileTmpPath, 'r');
        while (($row = fgetcsv($file)) !== false) {
            // Process each row as needed
            $sql = "INSERT INTO result_table(`SN`,`NAMES`,`SUBJECT`,`FIRST_CA`, `SECOND_CA`,`EXAMS`,`TOTAL`)VALUES('".$row[0]."','".$row[1]."','".$row[2]."','".$row[3]."','".$row[4]."','".$row[5]."','".$row[6]."')";
            $res = $conn->query($sql);
            // print_r($row)."<br>";
        }
        if (!$res == true) {
            echo"File fail to insert into dams.. "."<br>".$conn->error;
        }else{
            echo"
                <script>
                    alert('successfully adding into DBMS')
                </script>
            ";
        }
        fclose($file);
        exit();

    } else {
        echo "Error uploading file. Please try again.";
    }
} else {
    // echo "Invalid request method.";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSV File Upload</title>
    <link rel="stylesheet" href="../DataTables/datatables.css">
    <script src="../jquery.js"></script>
    <link rel="stylesheet" href="../DataTables/datatables.js">
    <link rel="stylesheet" href="../../TOOLS/bootstrap5/css/bootstrap.min.css">
</head>
<body>

    <form action="test.php" method="post" enctype="multipart/form-data">
        <input type="file" id="csvFile" name="csvFile" accept=".csv" required>
        <!-- <input type="submit" value="submit"> -->
        <button name="btn">Upload</button>

    </form>

    <table>
        <thead>
            <tr>
                <th>SN</th>
                <th>NAME</th>
                <th>SUBJECT</th>
                <th>FIRST_CA</th>
                <th>SECOND_CA</th>
                <th>EXAMS</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sn = 1;
                $query = "SELECT * FROM result_table";
                $result = $conn->query($query);
                $result->num_rows;
                while ($data = $result->fetch_assoc()>0) {
                
            ?>
            <tr>
                <td><?=$sn++?></td>
                <!-- <td><?=$data[0]; ?></td> -->
                <td><?=$data[1]; ?></td>
                <td><?=$data[2]; ?></td>
                <td><?=$data[3]; ?></td>
                <td><?=$data[4]; ?></td>
                <td><?=$data[5]; ?></td>
                
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
