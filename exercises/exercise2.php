<?php

// Database connection parameters
$servername = "127.0.0.1:3306";
$username = "mysql"; 
$password = "lihtne123"; // Change this to your database password
$dbname = "hospital";    


try {
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    echo "Connected successfully\n";



    // Display patient information with insurance details
    $sql = "SELECT p.pn, p.last, p.first, i.iname, DATE_FORMAT(i.from_date, '%m-%d-%y') AS from_date, DATE_FORMAT(i.to_date, '%m-%d-%y') AS to_date
            FROM patient p
            JOIN insurance i ON p._id = i.patient_id
            ORDER BY i.from_date, p.last";
    
    
    $result = $conn->query($sql);
    
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo $row["pn"] . ", " . $row["last"] . ", " . $row["first"] . ", " . $row["iname"] . ", " . $row["from_date"] . ", " . $row["to_date"] . "\n";
        }
    } else {
        echo "0 results";
    }
    
    
    // Statistics about letter occurrences in names
    $sql = "SELECT CONCAT(UPPER(LEFT(p.first, 1)), ' ', COUNT(1), ' ', ROUND((COUNT(1) / t.total * 100), 2), '%') AS stats
            FROM patient p
            JOIN (
                SELECT LEFT(first, 1) AS first_letter, COUNT(*) AS total
                FROM patient
                GROUP BY LEFT(first, 1)
            ) AS t ON LEFT(p.first, 1) = t.first_letter
            GROUP BY LEFT(p.first, 1), p.first, t.total
            UNION
            SELECT CONCAT(UPPER(LEFT(p.last, 1)), ' ', COUNT(1), ' ', ROUND((COUNT(1) / t.total * 100), 2), '%') AS stats
            FROM patient p
            JOIN (
                SELECT LEFT(last, 1) AS last_letter, COUNT(*) AS total
                FROM patient
                GROUP BY LEFT(last, 1)
            ) AS t ON LEFT(p.last, 1) = t.last_letter
            GROUP BY LEFT(p.last, 1), p.last, t.total
            ORDER BY LEFT(stats, 1)";


    
    $result = $conn->query($sql);
    
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo $row["stats"] . "\n";
        }
    } 
    else {
        echo "0 results";
    }
    
    
    $conn->close();
   
} 
catch(PDOException $e) {
    // Handle errors
    echo "Connection failed: " . $e->getMessage();
}


// Close the connection
$conn = null;

?>
