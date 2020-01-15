<?php
function getUserDetails($email)
{
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = query($sql);
    confirm($result);
    $row = fetch_array($result);
    return $row;
}
function getStudentDetails($email)
{
    $query = "SELECT * FROM students WHERE email = '$email'";
    $result = query($query);
    confirm($result);
    $row  = fetch_array($result);
    return $row;
}
function getProfProjects($id)
{
    $sql = "SELECT * FROM projects WHERE prof_id = $id";
    $result = query($sql);
    confirm($result);
    $data = array();
    while ($row = mysqli_fetch_array($result)) {
        $data[] = $row;
    }
    mysqli_free_result($result);
    return $data;
}
function addImagetoDatabase($name, $email)
{
    $query = "UPDATE students SET imageName = '$name' WHERE email = '$email'";
    $result = query($query);
    confirm($result);
}
function addPdfToDatabase($name, $email)
{
    $query = "UPDATE students SET resumeName = '$name' WHERE email = '$email'";
    $result = query($query);
    confirm($result);
}
function enterData($data, $id)
{
    $title = $data['projectTitle'];
    $abstract = $data['abstract'];
    $description = $data['description'];
    $department = $data['department'];
    $skills = $data['skills'];
    $project_webpage = $data['project_webpage'];
    $faculty_webpage = $data['faculty_webpage'];

    $query = "INSERT INTO projects (prof_id,title,abstract,description,department,skills,project_webpage,faculty_webpage) VALUES ('$id','$title','$abstract','$description','$department','$skills','$project_webpage','$faculty_webpage');";
    $res = query($query);
    confirm($res);
    return redirect("prof_profile.php");
}
function uplodadPDFtoDatabase($id,$name){
    $query = "UPDATE projects SET pdf_loc='$name' WHERE id = '$id'";
    $res = query($query);
    confirm($res);
    return ;
}
function uploadPDF($id,$files)
{
    $currentDir = getcwd();
    $uploadDirectory = "/uploads/projects/";
    $errors = []; // Store all foreseen and unforseen errors here
    $resumeUploadError = '';
    $fileExtensions = ['pdf']; // Get all the file extensions

    $fileName = $files['myfile']['name'];
    $fileSize = $files['myfile']['size'];
    $fileTmpName  = $files['myfile']['tmp_name'];   
    $fileType = $files['myfile']['type'];
    $fileExtension = strtolower(end(explode('.', $fileName)));

    $uploadPath = $currentDir . $uploadDirectory . basename($fileName);
    // Add image name to the database  
    if (!in_array($fileExtension, $fileExtensions)) {
        $errors[] = "This file extension is not allowed. Please upload a pdf file";
    }
    if (empty($errors)) {
        uplodadPDFtoDatabase($id,$fileName);
        $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

        if ($didUpload) {
            // Add image name to the database
            
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
