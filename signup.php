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
        <title>Registration</title>
    </head>

    <body>
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" style="text-align: center">
        <h2 style="font-weight: bold; font-size: 45px">Registration</h2>
        <p style="color: #008080; font-weight: bold">Email:</p>
        <input type="email" name="email" id="" style="border-radius: 10px; border-color: #008080;padding: 3px" required>
        <br>
        <p style="color: #008080; font-weight: bold">Username:</p>
        <input type="text" name="username" id="" style="border-radius: 10px; border-color: #008080;padding: 3px" required>
        <br>
        <p style="color: #008080; font-weight: bold">Password:</p>
        <input type="password" name="password" id="" style="border-radius: 10px; border-color: #008080;padding: 3px" required>
        <br><br>
        <input type="submit" value="Register" name="submit" style="background-color: #008080;
    text-decoration: none;
    color: white;border-radius: 10px;border: none;padding: 10px">
    </form>
    <p style="text-align: center">
        <a href="index.php">Already have an account? Click here to login.</a>
    </p>
    </body>

    </html>
<?php
//filter special chars incase of malicious script:
    if($_SERVER['REQUEST_METHOD']== "POST"){
        $email = filter_input(INPUT_POST,"email",FILTER_SANITIZE_SPECIAL_CHARS);
        $username = filter_input(INPUT_POST,"username",FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST,"password",FILTER_SANITIZE_SPECIAL_CHARS);
        $hash = md5($password);

            //$hash = password_hash($password,PASSWORD_DEFAULT,array("salt"=>"cart"));
            $sqlInsert = "INSERT INTO users (email, username,password) VALUES ('$email','$username','$hash')";
            mysqli_query($DBConnect,$sqlInsert);
            echo "User registered Successfully";

            $_SESSION["seshUser"] = $username;
            $_SESSION["seshPass"] = $password;

            header("Location: index.php");

    }
?>

<?php
mysqli_close($DBConnect);
?>