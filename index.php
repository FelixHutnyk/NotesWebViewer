<?php

require 'config.php';

if ($authentication_enabled) {
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
        header("location: login.php");
        exit;
    }
}

function getAllContentOfLocation($loc) {
    $scandir = scandir($loc);
    $scandir = array_filter($scandir, function ($element) {
        return !preg_match('/^\./', $element);
    });

    if (empty($scandir)) echo '<a style="color:red">Empty Dir</a>';

    foreach ($scandir as $file) {
        $baseLink = $loc . DIRECTORY_SEPARATOR . $file;

        echo '<ul>';
        if (is_dir($baseLink)) {
            echo '<li class="collapse-dir"><a class="DIR" style="font-weight:bold;">' . $file . '</a>';
            getAllContentOfLocation($baseLink);
            echo '</li>';
        } else {
            echo '<li class="NORM"><a class="NORM" href="' . $baseLink . '">' . $file . '</a></li>';
        }
        echo '</ul>';
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
            <?php getAllContentOfLocation($scan_directory); ?>
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