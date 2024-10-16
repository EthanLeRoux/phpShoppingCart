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
    <link rel="stylesheet" href="styles/nav.css">
    <title>Login</title>
</head>

<body>
<?php
echo "Session ID: ".session_id();
?>
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" style="text-align: center">
        <h2 style="font-weight: bold; font-size: 45px">Login</h2>
        <p style="color: #008080; font-weight: bold">Username:</p>
        <input type="text" name="username" id=""  style="border-radius: 10px; border-color: #008080;padding: 3px" required>
        <br>
        <p style="color: #008080; font-weight: bold">Password:</p>
        <input type="password" name="password" id="" style="border-radius: 10px; border-color: #008080;padding: 3px" required>
        <br><br>
        <input type="submit" value="Login" name="submit" style="background-color: #008080;
    text-decoration: none;
    color: white;border-radius: 10px;border: none;padding: 10px" required>
    </form>
<p style="text-align: center">
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