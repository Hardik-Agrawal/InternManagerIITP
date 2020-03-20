<?php
// echo $prog_id;
$currentDir = getcwd();
$uploadDirectory = "/uploads/projectFile/";
$errors = []; // Store all foreseen and unforseen errors here
$projectUploadError = '';
$fileExtensions = ['pdf']; // Get all the file extensions
if (isset($_POST['submitProgPdf'])) {
    $prog_id = $_POST["id"];
    $fileName = $_FILES['myfile']['name'];
    $fileSize = $_FILES['myfile']['size'];
    $fileTmpName  = $_FILES['myfile']['tmp_name'];
    $fileType = $_FILES['myfile']['type'];
    $fileExplode = explode('.', $fileName);
    $fileExtension = strtolower(end($fileExplode));

    $uploadPath = $currentDir . $uploadDirectory . basename($fileName);
    // Add image name to the database  
    if (!in_array($fileExtension, $fileExtensions)) {
        $errors[] = "This file extension is not allowed. Please upload a pdf file";
    }

    if (empty($errors)) {

        $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

        if ($didUpload) {
            // Add image name to the database
            addProjectPdftoDatabase($fileName, $prog_id);
            $projectUploadError =  "Successfully Uploaded";
        } else {
            $projectUploadError =  "An error occurred somewhere. Try again or contact the admin";
        }
    } else {
        foreach ($errors as $error) {
            $resumeUploadError = $error . "These are the errors" . "\n";
        }
    }
}
