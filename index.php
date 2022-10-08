<?php

$scan_directory="docs";


function getAllContentOfLocation($loc) {   
    $scandir = scandir($loc);

    $scandir = array_filter($scandir, function($element) {
        return !preg_match('/^\./', $element);
    });

    if(empty($scandir)) echo '<a style="color:red">Empty Dir</a>';

    foreach($scandir as $file) {
        $baseLink = $loc . DIRECTORY_SEPARATOR . $file;

        echo '<p>';
        echo '<ul>';
        if(is_dir($baseLink)) {
            echo '<li style="font-weight:bold;color:blue"><a class="DIR" href="'.$baseLink.'">'.$file.'</a></li>';
            getAllContentOfLocation($baseLink);

        } else {
            echo '<li><a class="NORM" href="'.$baseLink.'">'.$file.'</a></li>';
        }
        echo '</ul>';
        echo '</p>';
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Notes Viewer</title>
    <link rel="stylesheet" href="./assets/md.css">
    <link rel="stylesheet" href="./assets/style.css">
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
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
    <script src="./assets/jquery.js"></script>
    <script src="./assets/showdown.js"></script>
    <script src="./assets/script.js"></script>

</body>

</html>
