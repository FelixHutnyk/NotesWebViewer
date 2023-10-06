<?php
if(!isset($_SESSION)) session_start();

function getAllContentOfLocation($loc) {
    $scandir = scandir($loc);
    $scandir = array_filter($scandir, function ($element) {
        return !preg_match('/^\./', $element);
    });

    if (empty($scandir)) echo '<a style="color:red">Empty Dir</a>';

    foreach ($scandir as $file) {
        $baseLink = $loc . DIRECTORY_SEPARATOR . $file;
        $isOpen = isset($_SESSION['open'][$baseLink]) ? $_SESSION['open'][$baseLink] : false;

        echo '<ul>';
        if (is_dir($baseLink)) {
            echo '<li class="collapse-dir">';
            echo '<a class="DIR" style="font-weight:bold;" data-toggle="collapse" href="#' . md5($baseLink) . '">' . $file . '</a>';
            echo '<div id="' . md5($baseLink) . '" class="' . ($isOpen ? 'show' : '') . '">';
            
            getAllContentOfLocation($baseLink);
            
            echo '</div>';
            echo '</li>';
        } else {
            echo '<li class="NORM"><a class="NORM" href="' . $baseLink . '">' . $file . '</a></li>';
        }
        echo '</ul>';
    }
}

// Save the open state when the user collapses/expands a directory
if (isset($_GET['toggle'])) {
    $toggleDir = $_GET['toggle'];
    if (isset($_SESSION['open'][$toggleDir])) {
        $_SESSION['open'][$toggleDir] = !$_SESSION['open'][$toggleDir];
    } else {
        $_SESSION['open'][$toggleDir] = true;
    }
}

// Call the function to generate the directory tree
getAllContentOfLocation($scan_directory);
?>
