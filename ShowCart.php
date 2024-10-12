<?php
$DBConnect ="";
// Include the database connection and OnlineStore class
require_once("inc_OnlineStoreDB.php");
include("OnlineStore.php");

// Initialize OnlineStore object
$store = new OnlineStore($DBConnect);

// Fetch store info to get the dynamic CSS file name
$storeInfo = $store->fetchStoreInfo('coffee'); // Assuming 'coffee' is the store identifier
// Start HTML output
?>

<?php
// Start session and include database connection
require_once("inc_OnlineStoreDB.php");

if (isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
} else {
    $cart = array();
}

if (isset($ErrorMsgs) && count($ErrorMsgs) > 0) {
    foreach ($ErrorMsgs as $Msg) {
        echo "<p>" . $Msg . "</p>\n";
    }
} else {
    echo "<p>Successfully connected to the database.<p>\n";
}

$previousPage = $_SERVER['HTTP_REFERER'];
$previousPageName = basename($previousPage);

$cssFile = $_SESSION['cssFile'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/<?php echo $cssFile; ?>">
    <link rel="stylesheet" href="styles/nav.css">
    <title>Cart</title>
</head>
<body>
<div class="nav">
    <ul>
        <li class="heading" style="float:left">
            <a href="GGC.php" style="font-size: 30px"><?php echo $storeInfo[1]; ?></a>
        </li>

        <li style="float:right">
            <a href="GA.php">Antiques</a>
        </li>

        <li style="float:right">
            <a href="GEB.php">Electronic Boutique</a>
        </li>

        <li style="float:right">
            <a href="profile.php">Profile</a>
        </li>

        <li style="float:right">
            <a href="logout.php">Log Out</a>
        </li>
    </ul>
</div>
<br><br>
<?php
$TableName = "inventory";
$storeID = "coffee";
$SQLstring = "SELECT * FROM $TableName WHERE storeID = '$storeID'";

$QueryResult = @$DBConnect->query($SQLstring);

if ($QueryResult === FALSE) {
    echo "<p>Unable to execute the query. Error code " . $DBConnect->errno . ": " . $DBConnect->error . "</p>\n";
} else {
    echo "<table width='100%' border='1'>\n";
    echo "<tr><th>Image</th><th>Product ID</th><th>Name</th><th>Price</th><th>Quantity</th><th>Total Price</th></tr>\n";

    $subTotal = 0;

    // Fetch each row from the database
    while ($Row = $QueryResult->fetch_assoc()) {
        $productID = $Row['productID'];

        // Check if the product is in the cart
        if (array_key_exists($productID, $cart)) {
            $quantity = $cart[$productID];
            $price = $Row['price'];
            $totalPrice = $price * $quantity;

            echo "<tr>";
            echo "<td><img src='img/{$productID}.jpeg' height='100px' width='100px'></td>";
            echo "<td>{$productID}</td>";
            echo "<td>{$Row['name']}</td>";
            echo "<td>{$price}</td>";
            echo "<td>{$quantity}</td>";
            echo "<td>{$totalPrice}</td>";
            echo "</tr>\n";

            $subTotal += $totalPrice;
        }
    }

    $_SESSION["orderTotal"] = $subTotal;

    echo "<tr><td colspan='4'>Sub-Total</td><td>{$subTotal}</td></tr>";
    echo "</table>\n";
}
?>
<br><br>
<form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" style="text-align: center">
    <input type="submit" value="Complete Order" name="submit" required  style="background-color: #008080;
    text-decoration: none;
    color: white;border-radius: 10px;border: none;padding: 10px">
</form>

<?php
if(isset($_POST['submit'])){
    $userid = $_SESSION['userid'];
    $orderNum = session_id();
    $orderItems = print_r($cart,true);
    $orderTotal = $_SESSION["orderTotal"];

    $sqlInsert = "INSERT INTO orders (user_id ,order_total,order_date) VALUES ('$userid',$orderTotal,CURRENT_TIMESTAMP)";
    mysqli_query($DBConnect, $sqlInsert);

    $newOrderId = mysqli_insert_id($DBConnect);
    $result = mysqli_query($DBConnect, "SELECT * FROM Orders WHERE order_id = '$newOrderId'");
    $lastOrderMade = mysqli_fetch_assoc($result);

    if(!empty($cart)){
        foreach ($cart as $key => $value) {
            $findPrice = "SELECT * FROM inventory WHERE productID = '$key'";
            $res = mysqli_query($DBConnect,$findPrice);
            $result = mysqli_fetch_assoc($res);
            $price = $result['price'];

            $sqlInsetItems = "INSERT INTO orderitems(order_id, productID, quantity,price) VALUES ('$lastOrderMade[order_id]','$key','$value',$price)";
            mysqli_query($DBConnect, $sqlInsetItems);
        }
        $cart = array();
        $_SESSION['cart'] = $cart;
        echo "order sent.";
        echo "<br>";
        echo "<a href='GGC.php'>Shop for more Coffees</a>";
    }
    else{
        echo "Cart is empty. Shop for some Coffees!";
    }




}
?>
</body>
</html>
