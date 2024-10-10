<?php
$DBConnect = "";
include("inc_OnlineStoreDB.php");
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
<?php
    echo session_id();
?>
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        <h2>Login</h2>
        username: <br>
        <input type="text" name="username" id="" required>
        <br>
        password: <br>
        <input type="password" name="password" id="" required>
        <br>
        <input type="submit" value="Login" name="submit" required>
    </form>
<p>
    <a href="signup.php">Don't have an account? Click here to create an account.</a>
</p>
</body>

</html>
<?php
//filter special chars incase of malicious script:
    if($_SERVER['REQUEST_METHOD']== "POST") {
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
        $hash = md5($password);

        if (empty($username)) {
            echo "Username is empty.";
        } elseif (empty($password)) {
            echo "password is empty.";
        } else {
            $sqlSelect = "SELECT * FROM users WHERE username = '$username'";

            $QueryResult = mysqli_query($DBConnect, $sqlSelect);
            if ($QueryResult === FALSE)
                echo "<p>Unable to execute the query. " .
                    "Error code " . $DBConnect->errno .
                    ": " . $DBConnect->error . "</p>\n";
            else {
                $Row = $QueryResult->fetch_row();
                print_r($Row);

                if ($hash = $Row[3]) {
                    $_SESSION["seshUser"] = $username;
                    $_SESSION["seshPass"] = $password;
                    $_SESSION["userid"] = $Row[0];
                    $_SESSION["userStuff"] = $Row;
                    header("Location: GGC.php");
                } else {
                    echo "User doesnt exist";
                }
            }
        }
    }
?>

<?php
mysqli_close($DBConnect);
?>