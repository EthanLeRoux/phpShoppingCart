<?php
$DBConnect ="";
// Include the database connection and OnlineStore class
require_once("inc_OnlineStoreDB.php");
include("OnlineStore.php");

// Initialize OnlineStore object
$store = new OnlineStore($DBConnect);

// Fetch store info to get the dynamic CSS file name
$storeInfo = $store->fetchStoreInfo('elecbout'); // Assuming 'coffee' is the store identifier
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

echo "Session ID: " . session_id();
echo "<br>";
print_r($cart);
echo "<br>";

$previousPage = $_SERVER['HTTP_REFERER'];
$previousPageName = basename($previousPage);
echo $previousPageName;

$cssFile = $_SESSION['cssFile'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/<?php echo $cssFile; ?>">
    <title>Shopping Cart</title>
</head>
<body>
<h1>Shopping Cart</h1>
<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Home</a>

<?php
$TableName = "inventory";
$storeID = "coffee";
$SQLstring = "SELECT * FROM $TableName WHERE storeID = '$storeID'";

$QueryResult = @$DBConnect->query($SQLstring);

if ($QueryResult === FALSE) {
    echo "<p>Unable to execute the query. Error code " . $DBConnect->errno . ": " . $DBConnect->error . "</p>\n";
} else {
    echo "<table width='100%' border='1'>\n";
    echo "<tr><th>Product ID</th><th>Name</th><th>Price</th><th>Quantity</th><th>Total Price</th></tr>\n";

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
            echo "<td>{$productID}</td>";
            echo "<td>{$Row['name']}</td>";
            echo "<td>{$price}</td>";
            echo "<td>{$quantity}</td>";
            echo "<td>{$totalPrice}</td>";
            echo "</tr>\n";

            $subTotal += $totalPrice;
        }
    }

    echo "<tr><td colspan='4'>Sub-Total</td><td>{$subTotal}</td></tr>";
    echo "</table>\n";
}
?>

<a href="Checkout.php">Check Out</a>
</body>
</html>
