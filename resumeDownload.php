

<?php
$student_id = $GLOBALS['student_id'];
$query = "SELECT resumeName FROM students WHERE id = '$student_id'";

$res = mysqli_query($con, $query);
$obj = mysqli_fetch_array($res);
$resume_name = $obj["resumeName"];
$url = './uploads/resumes/18.pdf';
header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="sample.pdf"');
header('Content-Transfer-Encoding: binary');
header('Accept-Ranges: bytes');

@readfile($url);

?>
