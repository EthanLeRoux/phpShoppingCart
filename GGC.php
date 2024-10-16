<?php
$DBConnect = "";

require_once("inc_OnlineStoreDB.php");
include("OnlineStore.php");

$store = new OnlineStore($DBConnect);

if (isset($_GET['ItemToAdd'])) {
    $store->addToCart($_GET['ItemToAdd']);
}
if (isset($_GET['ItemToRemove'])) {
    $store->removeFromCart($_GET['ItemToRemove']);
}
if (isset($_GET['EmptyCart'])) {
    $store->emptyCart();
}

$store->displayErrorMessages();
$storeInfo = $store->fetchStoreInfo('coffee');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $storeInfo[1]; ?></title>
    <link rel="stylesheet" href="styles/<?php echo $storeInfo[4];
    $_SESSION['cssFile'] = $storeInfo[4];?>">
    <link rel="stylesheet" href="styles/nav.css">
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


<br><br><br><br>
<h2><?php echo $storeInfo[2]; ?></h2>
<p><?php echo $storeInfo[3]; ?></p>

<?php $store->displayCart("coffee"); ?>
<br>
<a href="ShowCart.php" style="padding: 5px;font-weight: normal;font-style: normal; background-color: #008080; color: white; border-radius: 10px">Cart</a>
<a href="ShowCart.php" style="padding: 5px;font-weight: normal;font-style: normal; background-color: #008080; color: white; border-radius: 10px">Complete Order</a>
<!--<br><br>-->
<!--<form action="--><?php //htmlspecialchars($_SERVER['PHP_SELF']) ?><!--" method="post">-->
<!--    <input type="submit" value="Complete Order" name="submit" required  style="background-color: #008080;-->
<!--    text-decoration: none;-->
<!--    color: white;border-radius: 10px;border: none;padding: 10px">-->
<!--</form>-->
<!---->
<?php
//if(isset($_POST['submit'])){
//    $userid = $_SESSION['userid'];
//    $orderNum = session_id();
//    //$orderTotal = $_SESSION["orderTotal"];
//    $orderTotal =0;
//
//    if(isset($_SESSION["orderTotal"])){
//        $sqlInsert = "INSERT INTO orders (user_id ,order_total,order_date) VALUES ('$userid',$orderTotal,CURRENT_TIMESTAMP)";
//        mysqli_query($DBConnect, $sqlInsert);
//
//        $newOrderId = mysqli_insert_id($DBConnect);
//        $result = mysqli_query($DBConnect, "SELECT * FROM Orders WHERE order_id = '$newOrderId'");
//        $lastOrderMade = mysqli_fetch_assoc($result);
//
//        if(!empty($cart)){
//            foreach ($cart as $key => $value) {
//                $findPrice = "SELECT * FROM inventory WHERE productID = '$key'";
//                $res = mysqli_query($DBConnect,$findPrice);
//                $result = mysqli_fetch_assoc($res);
//                $price = $result['price'];
//
//                $sqlInsetItems = "INSERT INTO orderitems(order_id, productID, quantity,price) VALUES ('$lastOrderMade[order_id]','$key','$value',$price)";
//                mysqli_query($DBConnect, $sqlInsetItems);
//            }
//            $cart = array();
//            $_SESSION['cart'] = $cart;
//            echo "order sent.";
//            echo "<br>";
//            echo "<a href='GGC.php'>Shop for more Coffees</a>";
//    }
//        else{
//            echo "<br>";
//            echo "No items were selected. Please shop some more!";
//        }
//
//    }
//    else{
//        $cart = array();
//        $_SESSION['cart'] = $cart;
//    }
//}
//?>
</body>
</html>

<?php
$store->closeConnection();
?>
