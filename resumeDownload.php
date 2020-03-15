<?php include('includes/header.php') ?>

<?php

$id = $_GET["id"];
$query = "SELECT resumeName FROM students WHERE id=$id";
$result = query($query);
$resume_array = fetch_array($result);
$resume_name = $resume_array["resumeName"];
$url = './uploads/resumes/' . $resume_name;
// echo $url;
header('Content-type: application/pdf');
header('Content-Disposition: inline; filename=resume.pdf');
header('Content-Transfer-Encoding: binary');
header('Accept-Ranges: bytes');

@readfile($url);
?>

<?php include('includes/footer.php') ?>
