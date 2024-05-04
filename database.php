<?php
//I referenced the w3schools link provided in the 
//Project Description, the appropriate AU Information
//Technology articles, and PHP.net for information on implementation.

// MySQL connection info
$servername = "servername";
$username = "username";
$password = "password";
$db = "dbname";

//Get connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Display query results
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = $_POST['query'];

    if (get_magic_quotes_gpc()) {
        $sql = stripslashes($sql);
    }

    if(stripos($sql, 'DROP') !== false) {
        echo "DROP statement not allowed.";

    }
    else {

        $result = $conn->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                echo "Rows Retrieved: " . $result->num_rows . "<br>";

                $column = $result->fetch_fields();
                echo "<table>";
                echo "<tr>";

                foreach ($column as $col) {
                    echo "<th>".$col->name."</th>";
                }

                while($row = $result->fetch_assoc()) {
                    echo "<tr>";

                    foreach ($row as $value) {
                        echo "<td>".$value."</td>";
                    }
                    echo "</tr>";


                }
                echo "</table>";

            }
            else {
                echo "No results for given query.";
            }
        }
    }


}


$conn->close();
?>
