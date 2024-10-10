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
        <title>Registration</title>
    </head>

    <body>
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        <h2>Registration</h2>
        email: <br>
        <input type="text" name="email" id="">
        <br>
        username: <br>
        <input type="text" name="username" id="">
        <br>
        password: <br>
        <input type="password" name="password" id="">
        <br>
        <input type="submit" value="register" name="submit">
    </form>
    <p>
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

        if(empty($username)){
            echo "Username is empty.";
        }
        elseif(empty($password)){
            echo "password is empty.";
        }
        else{
            //$hash = password_hash($password,PASSWORD_DEFAULT,array("salt"=>"cart"));
            $sqlInsert = "INSERT INTO users (email, username,password) VALUES ('$email','$username','$hash')";
            mysqli_query($DBConnect,$sqlInsert);
            echo "User registered Successfully";

            $_SESSION["seshUser"] = $username;
            $_SESSION["seshPass"] = $password;

            header("Location: index.php");
        }
    }
?>

<?php
mysqli_close($DBConnect);
?>