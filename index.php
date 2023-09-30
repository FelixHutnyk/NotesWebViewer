<?php

require 'config.php';

if ($authentication_enabled) {
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
        header("location: login.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title></title>
    <link rel="stylesheet" href="assets/md.css">
    <link rel="stylesheet" href="assets/style.css">
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
</head>

<body>
    <div class="content">

        <div id="preview" class="preview md">
        </div>

        <div class="index">
            <h1>Directory Tree</h1>
            <?php include('navbar.php') ?>
        </div>

        <div class="loading" style="display: none">
            # Notes Viewer
            Select a file from the index
        </div>

    </div>

    <!-- SCRIPTS -->
    <script src="assets/jquery.js"></script>
    <script src="assets/showdown.js"></script>
    <script src="assets/script.js"></script>

</body>

</html>