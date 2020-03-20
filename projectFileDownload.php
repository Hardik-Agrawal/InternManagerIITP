<?php include('includes/header.php') ?>

<?php

$id = $_GET["id"];
$query = "SELECT pdfName FROM projects WHERE id=$id";
$result = query($query);
$resume_array = fetch_array($result);
$file_name = $resume_array["pdfName"];
$url = './uploads/projectFile/' . $file_name;
// echo $url;
header('Content-type: application/pdf');
header('Content-Disposition: inline; filename=project.pdf');
header('Content-Transfer-Encoding: binary');
header('Accept-Ranges: bytes');

@readfile($url);
?>

<?php include('includes/footer.php') ?>
