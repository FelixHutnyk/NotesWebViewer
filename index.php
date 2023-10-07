<?php

require 'config.php';

if ($authentication_enabled) {
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
        header("location: login.php");
        exit;
    }
}

$targetDir = "uploads/";
$uploadOk = 1;
$errorMessage = "";

if (isset($_FILES["fileToUpload"])) {
    $file = $_FILES["fileToUpload"];
    $fileName = basename($file["name"]);
    $targetFile = $targetDir . $fileName;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    // Check file size (adjust as needed, this checks for a maximum of 16MB)
    if ($file["size"] > 16 * 1024 * 1024) {
        $errorMessage = "Sorry, your file is too large (maximum 16MB allowed).";
        $uploadOk = 0;
    }
    
    // Handle duplicate filenames by adding an increment
    $fileCount = 1;
    while (file_exists($targetFile)) {
        $fileName = pathinfo($file["name"], PATHINFO_FILENAME);
        $fileName .= "_$fileCount";
        $targetFile = $targetDir . $fileName . "." . $imageFileType;
        $fileCount++;
    }
    
    if ($uploadOk == 0) {
        $errorMessage = "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            $errorMessage = "The file " . htmlspecialchars($fileName) . " has been uploaded.";
        } else {
            $errorMessage = "Sorry, there was an error uploading your file.";
        }
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
            <div class="upload-form">
                <form action="index.php" method="post" enctype="multipart/form-data">
                    <label for="fileToUpload" id="uploadBtn">Upload File</label>
                    <input type="file" name="fileToUpload" id="fileToUpload" onchange="this.form.submit()" required>
                </form>
            </div>
            <?php
            if (!empty($errorMessage)) {
                $messageClass = strpos($errorMessage, 'Error:') === 0 ? 'error-message' : 'success-message';
                echo '<div class="message-box ' . $messageClass . '">' . $errorMessage . '</div>';
            }
            ?>
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