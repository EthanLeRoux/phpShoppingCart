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
    <link rel="stylesheet" href="styles/elecbout.css">
</head>
<body>

<div class="nav">
    <ul>
        <li class="heading" style="float:left">
            <a href="GEB.php" style="font-size: 30px"><?php echo $storeInfo[1]; ?></a>
        </li>

        <li style="float:right">
            <a href="GA.php">Antiques</a>
        </li>

        <li style="float:right">
            <a href="GGC.php">Gourmet Coffees</a>
        </li>

        <li style="float:right">
            <a href="profileElec.php">Profile</a>
        </li>

        <li style="float:right">
            <a href="logout.php">Log Out</a>
        </li>
    </ul>
</div>
<br><br>
<h1><?php echo $storeInfo[1]; ?></h1>
<h2><?php echo $storeInfo[2]; ?></h2>
<p><?php echo $storeInfo[3]; ?></p>
<?php $store->displayCart("elecbout"); ?>
<a href="ShowCartElec.php">Show Cart</a>
<a href="ShowCartElec.php">Check-out Order</a>
</body>
</html>

<?php
$store->closeConnection();
?>

