<?php

require 'config.php';

if ($authentication_enabled) {
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
        header("location: login.php");
        exit;
    }
}

$uploadDir = 'uploads/';
$files = scandir($uploadDir);

// Filter out "." and ".." from the list
$files = array_diff($files, array('.', '..'));

if (isset($_GET['file'])) {
    $fileToDelete = $_GET['file'];
    $filePath = $uploadDir . $fileToDelete;

    if (file_exists($filePath)) {
        unlink($filePath);
        header('Location: files.php'); 
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Manager</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7; /* Light gray background */
            padding: 20px;
            margin: 0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #007bff; /* Header background color */
            color: #fff; /* Header text color */
            padding: 10px 20px;
        }

        .header-title {
            font-size: 24px;
            font-weight: bold;
        }

        .header-button {
            background: none;
            border: none;
            cursor: pointer;
            color: #fff; /* Button text color */
            font-weight: bold;
            text-decoration: underline;
        }

        .file-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between; /* Space between file cards */
            margin-top: 20px;
        }

        .file-card {
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            margin: 0 0 20px 0; /* Add bottom margin for spacing */
            display: flex;
            flex-direction: column;
            align-items: center;
            width: calc(32% - 20px); /* Adjust card width */
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1); /* Add box shadow for cards */
        }

        .file-card img {
            max-width: 80px;
            max-height: 80px;
            margin-bottom: 10px; /* Add space between image and file name */
        }

        .file-details {
            text-align: center;
            flex-grow: 1;
        }

        .file-actions {
            margin-top: 10px; /* Add space between file details and actions */
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .action-button {
            background-color: #007bff; /* Button background color */
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            color: #fff; /* Button text color */
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px; /* Add space between buttons */
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-title">File Manager</div>
        <a href="/" class="header-button">Go to Site Root</a>
    </div>
    <div class="file-list">
        <?php

        foreach ($files as $file) :
        ?>
            <div class="file-card" style="border-color: #007bff;">
                <div class="file-details">
                    <p><?= $file ?></p>
                </div>
                <div class="file-actions">
                    <a href="<?= $uploadDir . $file ?>" download class="action-button">Download</a>
                    <a href="?file=<?= urlencode($file) ?>" class="action-button">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
