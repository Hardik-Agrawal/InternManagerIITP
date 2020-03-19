<?php
$currentDir = getcwd();
$uploadDirectory = "/uploads/studentImages/";
$errors = []; // Store all foreseen and unforseen errors here

$fileExtensions = ['jpeg', 'jpg', 'png']; // Get all the file extensions
if (isset($_POST['submitImage'])) {
    $fileName = $_FILES['myfile']['name'];
    $fileSize = $_FILES['myfile']['size'];
    $fileTmpName  = $_FILES['myfile']['tmp_name'];
    $fileType = $_FILES['myfile']['type'];
    $explodeFile = explode('.', $fileName);
    $fileExtension = strtolower(end($explodeFile));

    $uploadPath = $currentDir . $uploadDirectory . basename($fileName);
    // Add image name to the database

    if (!in_array($fileExtension, $fileExtensions)) {
        $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
    }
    if ($fileSize > 2000000) {
        $errors[] = "This file is more than 2MB. Sorry, it has to be less than or equal to 2MB";
    }

    if (empty($errors)) {

        $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

        if ($didUpload) {
            $str = "The file " . basename($fileName) . " has been uploaded";
            echo "<script>alert('$str')</script>";
            addImagetoDatabase($fileName, $row['email']);
        } else {
            echo '<script>aleart("An error occurred somewhere. Try again or contact the admin")</script>';
        }
    } else {
        foreach ($errors as $error) {
            echo $error . "These are the errors" . "\n";
        }
    }
}
