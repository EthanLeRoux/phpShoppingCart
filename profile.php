<?php
$DBConnect = "";
include("inc_OnlineStoreDB.php");
session_start();
$username = $_SESSION["seshUser"];
$userId = $_SESSION["userid"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/profile.css">
    <title>Profile</title>
</head>

<body>
<h1>Profile</h1>
<a href="GA.php">Home</a>
<br>
<div class="profile">
    <img src="img/profile.png" height="100px" width="100px">
    <?php
    echo "<h2>$username</h2>";
    print_r($_SESSION["userStuff"]) ;
    ?>
</div>
<h2>Past Orders</h2>
<?php
    $sqlSelect = "SELECT * FROM orders WHERE user_id = '$userId'";

    $QueryResult = mysqli_query($DBConnect, $sqlSelect);
    if ($QueryResult === FALSE)
    echo "<p>Unable to execute the query. " .
        "Error code " . $DBConnect->errno .
        ": " . $DBConnect->error . "</p>\n";
    else {

        $row = array();
        while($row = $QueryResult->fetch_row()){
            echo "<table width='100%' border='1'>\n";
            echo "<tr><th>Order Code</th><th>Order Items</th>" ."<th>Order Date</th></tr>\n";
            echo "<tr><td>{$row[2]}</td>";
            echo "<td>{$row[3]}</td>";
            echo "<td>{$row[4]}</td>";
            echo "</tr>\n";
            echo "</tr>";
            echo "</table>";
            echo "<br>";
        }

    }
?>
</body>


</html>