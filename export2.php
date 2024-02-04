<?php
//database
include "./connection.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>display</title>
    <link rel="stylesheet" href="../../TOOLS/bootstrap5/css/bootstrap.min.css">
    <link rel="stylesheet" href="../DataTables/datatables.css">
    <script src="../jquery.js"></script>
    <script src="../DataTables/datatables.js"></script>
</head>
<body style="background-color: #f1f1f1;">
    <div class="container">
    <!-- <div class="card width:100%"> -->

        <h3 class="card-title">School Result</h3>
        <table id="myTable" class="display table  table-border table-light  table-responsive-ms cell-border" style="width:100%">
        <caption>List of student result</caption>
            <thead class="alert alert-primary">
                <tr>
                    <th>SN</th>
                    <th>NAMES</th>
                    <th>SUBJECT</th>
                    <th>FIRST CA</th>
                    <th>SECOND CA</th>
                    <th>EXAMS</th>
                    <th>TOTAL</th>
                </tr>
            </thead>
     
            <tbody>
                <?php
                    // Fetch data from the database (assuming you have a 'users' table)
                    $sql = "SELECT * FROM result_table";
                    $result = $conn->query($sql);

                    // Process the result and store it in an array
                    $result->num_rows>0;
                    $sn = 1;
                    while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <!-- <td><?=$sn++; ?></td> -->
                    <td><?=$row['SN']?></td>
                    <td><?=$row['NAMES']?></td>
                    <td><?=$row['SUBJECT']?></td>
                    <td><?=$row['FIRST_CA']?></td>
                    <td><?=$row['SECOND_CA']?></td>
                    <td><?=$row['EXAMS']?></td>
                    <td><?=$row['TOTAL']?></td>
                    
                </tr>
                <?php
                    }
                    // Close the database connection
                    $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    </div>
    <script>
        let Table = new DataTable('#myTable',{
            responsive: true

        });
    </script>
</body>
</html>
