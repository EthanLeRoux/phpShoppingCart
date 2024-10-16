<?php
$DBConnect = "";
include("inc_OnlineStoreDB.php");
session_start();
$username = $_SESSION["seshUser"];
$userId = $_SESSION["userid"];

$TableName = "store_info";
$storeID = "antique";
$SQLstring = "SELECT * FROM $TableName WHERE storeID = '$storeID'";

$result = $DBConnect->query($SQLstring);

if (!$result) {
    return null;
} else {
    $storeInfo = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/profile.css">
    <link rel="stylesheet" href="styles/antiques.css">
    <link rel="stylesheet" href="styles/<?php echo $storeInfo['css_file'];?>">
    <title>Profile</title>
</head>

<body>
<div class="nav">
    <ul>
        <li class="heading" style="float:left">
            <a href="GGC.php" style="font-size: 30px"><?php echo $storeInfo['name']; ?></a>
        </li>

        <li style="float:right">
            <a href="ShowCart.php">Cart</a>
        </li>

        <li style="float:right">
            <a href="logout.php">Log Out</a>
        </li>

        <li style="float:right">
            <a href="GGC.php">Coffees</a>
        </li>


        <li style="float:right">
            <a href="GEB.php">Electronic Boutique</a>
        </li>
    </ul>
</div>
<br><br>
<h1>Profile</h1>
<br>
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; border: 1px solid #ccc; padding: 10px;">
    <div class="profile">
        <img src="img/profile.png" height="300px" width="300px">
        <?php
        echo "<h1>$username</h1>";
        $userStuff = $_SESSION["userStuff"];
        echo "<h3>$userStuff[1]</h3>";
        ?>
    </div>

    <div>
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
                echo "<tr><th>Order Date</th><th>Order Total</th>" ."</tr>\n";
                echo "<tr><td>{$row[3]}</td>";
                echo "<td>R{$row[2]}</td>";
                echo "</tr>\n";
                echo "</tr>";
                echo "</table>";
                echo "<br>";
            }

        }
        ?>
    </div>
</div>





</body>


</html>