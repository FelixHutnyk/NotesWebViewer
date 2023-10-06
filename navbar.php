<?php
if(!isset($_SESSION)) session_start();


function getAllContentOfLocation($loc) {
    $scandir = scandir($loc);
    $scandir = array_filter($scandir, function ($element) {
        return !preg_match('/^\./', $element);
    });

    if (empty($scandir)) {
        echo '<a style="color:red">Empty Dir</a>';
    }

    foreach ($scandir as $file) {
        $baseLink = $loc . DIRECTORY_SEPARATOR . $file;
        $folderId = md5($baseLink); // Generate a unique ID for each folder

        echo '<ul>';
        if (is_dir($baseLink)) {
            // Check if the folder is open in the session
            $isOpen = isset($_SESSION['opened_folders'][$folderId]) && $_SESSION['opened_folders'][$folderId] === true;

            echo '<li class="collapse-dir">';
            echo '<a class="DIR" style="font-weight:bold;">' . $file . '</a>';
            echo '<input type="hidden" class="folder-id" value="' . $folderId . '">';

            if ($isOpen) {
                echo '<ul style="display: block;">';
            } else {
                echo '<ul style="display: none;">';
            }

            getAllContentOfLocation($baseLink);

            echo '</ul>';
            echo '</li>';
        } else {
            echo '<li class="NORM"><a class="NORM" href="' . $baseLink . '">' . $file . '</a></li>';
        }
        echo '</ul>';
    }
}

// Handle AJAX requests to toggle folder state
if (isset($_POST['action']) && $_POST['action'] === 'toggleFolder') {
    $folderId = $_POST['folderId'];

    // Toggle folder state in the session
    if (isset($_SESSION['opened_folders'][$folderId])) {
        $_SESSION['opened_folders'][$folderId] = !$_SESSION['opened_folders'][$folderId];
    } else {
        $_SESSION['opened_folders'][$folderId] = true;
    }

    // Send a response to indicate success
    echo 'success';
    exit;
}

// Check if 'opened_folders' session variable is set
if (!isset($_SESSION['opened_folders'])) {
    $_SESSION['opened_folders'] = array();
}

// Call the function to generate the directory tree
getAllContentOfLocation($scan_directory);
?>
