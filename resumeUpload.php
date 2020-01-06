<?php
$currentDir = getcwd();
$uploadDirectory = "/uploads/resumes/";
$errors = []; // Store all foreseen and unforseen errors here
$resumeUploadError = '';
$fileExtensions = ['pdf']; // Get all the file extensions
if (isset($_POST['submitResume'])) {
    $fileName = $_FILES['myfile']['name'];
    $fileSize = $_FILES['myfile']['size'];
    $fileTmpName  = $_FILES['myfile']['tmp_name'];
    $fileType = $_FILES['myfile']['type'];
    $fileExtension = strtolower(end(explode('.', $fileName)));

    $uploadPath = $currentDir . $uploadDirectory . basename($fileName);
    // Add image name to the database  
    if (!in_array($fileExtension, $fileExtensions)) {
        $errors[] = "This file extension is not allowed. Please upload a pdf file";
    }
    if (empty($errors)) {

        $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

        if ($didUpload) {
            // Add image name to the database
            addPdftoDatabase($fileName, $row['email']);
            $resumeUploadError =  "Successfully Uploaded";
        } else {
            $resumeUploadError =  "An error occurred somewhere. Try again or contact the admin";
        }
    } else {
        foreach ($errors as $error) {
            $resumeUploadError = $error . "These are the errors" . "\n";
        }
    }
}
