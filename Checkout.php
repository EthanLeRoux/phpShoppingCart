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

print_r($cart);
echo "<br>";
echo $_SESSION["userid"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HTML 5 Boilerplate</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
echo "<br>";
echo "Welcome Back ".$_SESSION['seshUser']." !";
?>
    <h2>Checkout</h2>
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        <h2>Purchase the Items</h2>
        Payment Method: <br>
        <input type="text" name="paymentmethod" id="" required>
        <br>
        Address: <br>
        <input type="text" name="address" id="" required>
        <br>
        <input type="submit" value="Complete Order" name="submit" required>
    </form>
</body>
</html>

<?php
if(isset($_POST['submit'])){
    $paymentmethod = $_POST['paymentmethod'];
    $address = $_POST['address'];
    $userid = $_SESSION['userid'];
    $orderNum = session_id();
    $orderItems = print_r($cart,true);
    $sqlInsert = "INSERT INTO orders (user_id ,order_code,order_items,order_date,method, address) VALUES ('$userid','$orderNum','$orderItems',CURRENT_TIMESTAMP,'$paymentmethod','$address')";
    if(mysqli_query($DBConnect,$sqlInsert)){
        $cart = array();
        $_SESSION['cart'] = $cart;
        echo "order sent.";
        echo "<br>";
        echo "<a href='GGC.php'>Shop for more Coffees</a>";
    }
    else{
        echo "unable to place order";
    }
}
?>