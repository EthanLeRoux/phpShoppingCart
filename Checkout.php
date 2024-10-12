<?php
$DBConnect = '';
require_once("inc_OnlineStoreDB.php");
session_start();

if(isset($_SESSION['cart'])){
    $cart = $_SESSION['cart'] ;
}
else{
    $cart = array();
}

$TableName = "store_info";
$storeID = "coffee";
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
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HTML 5 Boilerplate</title>
    <link rel="stylesheet" href="styles/GosselinGourmet.css">
    <link rel="stylesheet" href="styles/nav.css">
</head>
<body>
<div class="nav">
    <ul>
        <li class="heading" style="float:left">
            <a href="GGC.php" style="font-size: 30px"><?php echo $storeInfo['name']; ?></a>
        </li>

        <li style="float:right">
            <a href="GGC.php">Home</a>
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
    <h2>Checkout</h2>
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

<br><br>

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
?>
</body>
</html>

