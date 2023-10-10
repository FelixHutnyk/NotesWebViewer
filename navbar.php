<?php
if (!isset($_SESSION)) session_start();

function getAllContentOfLocation($loc, $isRoot = true) {
    $scandir = scandir($loc);
    $scandir = array_filter($scandir, function ($element) {
        return !preg_match('/^\./', $element);
    });

    if (empty($scandir) && $isRoot) {
        echo '<a style="color:red">Empty Dir</a>';
    }

    foreach ($scandir as $file) {
        $baseLink = $loc . DIRECTORY_SEPARATOR . $file;
        $folderId = md5($baseLink); // Generate a unique ID for each folder

        echo '<ul>';
        if (is_dir($baseLink)) {
            // Check if the folder state is saved in the JSON file
            $folderStates = loadFolderStates();
            $isOpen = false; // Default to closed

            // Check if the folder state is saved in the JSON file
            if (isset($folderStates[$folderId])) {
                $isOpen = $folderStates[$folderId];
            }

            echo '<li class="collapse-dir">';
            echo '<a class="DIR" style="font-weight:bold;">' . $file . '</a>';
            echo '<input type="hidden" class="folder-id" value="' . $folderId . '">';

            if ($isOpen) {
                echo '<ul style="display: block;">';
            } else {
                echo '<ul style="display: none;">';
            }

            // Recursively call the function for nested folders
            getAllContentOfLocation($baseLink, false);

            echo '</ul>';
            echo '</li>';
        } else {
            echo '<li class="NORM"><a class="NORM" href="' . $baseLink . '">' . $file . '</a></li>';
        }
        echo '</ul>';
    }
}

function loadFolderStates() {
    $folderStatesFile = 'assets/folder_states.json';

    if (file_exists($folderStatesFile)) {
        $jsonContents = file_get_contents($folderStatesFile);
        $decoded = json_decode($jsonContents, true);
        $_SESSION['opened_folders'] = $decoded;
        return $decoded;
    } else {
        return array(); // Return an empty array if the file doesn't exist
    }
}

// Save folder states to the JSON file
function saveFolderStates($folderStates) {
    $folderStatesFile = 'assets/folder_states.json';
    file_put_contents($folderStatesFile, json_encode($folderStates, JSON_PRETTY_PRINT));
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

    // Save the folder states to the JSON file
    saveFolderStates($_SESSION['opened_folders']);

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
