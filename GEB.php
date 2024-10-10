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
$storeInfo = $store->fetchStoreInfo('elecbout');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $storeInfo[1]; ?></title>
    <link rel="stylesheet" href="styles/<?php echo $storeInfo[4];
    $_SESSION['cssFile'] = $storeInfo[4];?>">
</head>
<body>
<h3>
    <?php
    echo "Welcome back user: ".$_SESSION['seshUser'];
    ?>
</h3>

<h1><?php echo $storeInfo[1]; ?></h1>
<h2><?php echo $storeInfo[2]; ?></h2>
<p><?php echo $storeInfo[3]; ?></p>
<a href="GA.php">Antiques</a>
<br>
<a href="GGC.php">Gourmet Coffees</a>
<br>
<a href="logout.php">Log Out</a>

<?php $store->displayCart("elecbout"); ?>
<a href="ShowCart.php">Show Cart</a>
</body>
</html>

<?php
$store->closeConnection();
?>

