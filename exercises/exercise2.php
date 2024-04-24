<?php

// Database connection 
$servername = "127.0.0.1:3306";
$username = "mysql"; 
$password = "lihtne123"; // Change this to your database password
$dbname = "hospital";    


try {
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    echo "Connected successfully\n";

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
    $sql = "SELECT 
        SUBSTRING_INDEX(SUBSTRING_INDEX(name, ' ', 1), ' ', -1) AS first_name,
        SUBSTRING_INDEX(SUBSTRING_INDEX(name, ' ', -1), ' ', 1) AS last_name
    FROM
        (SELECT 
            CONCAT(first, ' ', last) AS name
        FROM
            patient) AS name_split
    UNION ALL SELECT 
        SUBSTRING_INDEX(SUBSTRING_INDEX(name, ' ', 1), ' ', -1) AS first_name,
        SUBSTRING_INDEX(SUBSTRING_INDEX(name, ' ', -1), ' ', 1) AS last_name
    FROM
        (SELECT 
            CONCAT(first, ' ', last) AS name
        FROM
            patient) AS name_split;
      ";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $letterCounts = [];
        // Count letters in names
        while($row = $result->fetch_assoc()) {
            $first_name = $row["first_name"];
            $last_name = $row["last_name"];
            $full_name = $first_name . " " . $last_name;

            // Count letter occurrences
            $letters = str_split($full_name);
            foreach ($letters as $letter) {
                if (ctype_alpha($letter)) {
                    $letter = strtolower($letter);
                    if (!isset($letterCounts[$letter])) {
                        $letterCounts[$letter] = 1;
                    } else {
                        $letterCounts[$letter]++;
                    }
                }
            }
        }

        // Calculate total letters
        $totalLetters = array_sum($letterCounts);

        // Calculate percentages and sort alphabetically
        ksort($letterCounts);
        echo "\nLetter Statistics:\n";
        echo "Letter\tCount\tPercentage\n";
        foreach ($letterCounts as $letter => $count) {
            $percentage = number_format(($count / $totalLetters) * 100, 2);
            echo strtoupper($letter) . "\t" . $count . "\t" . $percentage . " %\n";
        }
    }
    else {
        echo "0 results";
    }

    $conn->close();

} 
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


// Close the connection
$conn = null;
?>