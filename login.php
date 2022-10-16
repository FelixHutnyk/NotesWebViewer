<?php

require 'config.php';

if ($authentication_enabled) {
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        header("location: index.php");
        exit;
    }
} else {
    header("location: index.php");
}

$password = "";
$password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    if ($password == $authentication_password) {
        $_SESSION["loggedin"] = true;
        header("location: index.php");
    } else {
        $password_err = "Incorrect password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Notes Viewer</title>
    <link rel="stylesheet" href="assets/login.css">
</head>

<body>
    <div class="box">

        <div class="form">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h2>Authentication</h2>
                <div class="inputBox">
                    <input name="password" type="password" required="required">
                    <span>Password</span>
                    <i></i>
                </div>

                <br>
                <?php echo "<h2>".$password_err."</h2>"; ?>
                <br>
                <input type="submit" value="Login" class="c">
            </form>
        </div>
    </div>

</body>

</html>